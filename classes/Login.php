<?php

/**
 * handles the user login/logout/session
 * @author Panique
 * @link http://www.php-login.net
 * @link https://github.com/panique/php-login-advanced/
 * @license http://opensource.org/licenses/MIT MIT License
 */
class Login {

    /**
     * @var object $db_connection The database connection
     */
    private $db_connection = null;

    /**
     * @var int $user_id The user's id
     */
    private $user_id = null;

    /**
     * @var string $user_name The user's name
     */
    private $user_name = "";
    private $user_cpf = "";
    private $user_nome = "";
    private $user_sexo = "";
    private $user_nasc = "";
    private $user_formacao = "";
    private $user_fone = "";
    private $user_admissao = "";
    private $user_cargo = "";

    /**
     * @var string $user_email The user's mail
     */
    private $user_email = "";

    /**
     * @var boolean $user_is_logged_in The user's login status
     */
    private $user_is_logged_in = false;

    /**
     * @var string $user_gravatar_image_url The user's gravatar profile pic url (or a default one)
     */
    public $user_gravatar_image_url = "";

    /**
     * @var string $user_gravatar_image_tag The user's gravatar profile pic url with <img ... /> around
     */
    public $user_gravatar_image_tag = "";

    /**
     * @var boolean $password_reset_link_is_valid Marker for view handling
     */
    private $password_reset_link_is_valid = false;

    /**
     * @var boolean $password_reset_was_successful Marker for view handling
     */
    private $password_reset_was_successful = false;

    /**
     * @var array $errors Collection of error messages
     */
    public $errors = array();

    /**
     * @var array $messages Collection of success / neutral messages
     */
    public $messages = array();

    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$login = new Login();"
     */
    public function __construct() {
// create/read session
        session_start();

// TODO: organize this stuff better and make the constructor very small
// TODO: unite Login and Registration classes ?
// check the possible login actions:
// 1. logout (happen when user clicks logout button)
// 2. login via session data (happens each time user opens a page on your php project AFTER he has successfully logged in via the login form)
// 3. login via cookie
// 4. login via post data, which means simply logging in via the login form. after the user has submit his login/password successfully, his
//    logged-in-status is written into his session data on the server. this is the typical behaviour of common login scripts.
// if user tried to log out
        if (isset($_GET["logout"])) {
            $this->doLogout();

// if user has an active session on the server
        } elseif (!empty($_SESSION['user_name']) && ($_SESSION['user_logged_in'] == 1)) {
            $this->loginWithSessionData();

// checking for form submit from editing screen
// user try to change his username
            if (isset($_POST["user_edit_form_name"])) {
// function below uses use $_SESSION['user_id'] et $_SESSION['user_email']
                /* $this->editUserDates($_POST['user_name'], $_POST['user_nome'], $_POST['user_cpf'], $_POST['user_sexo'], 
                  $_POST['user_nasc'], $_POST['user_formacao'], $_POST['user_fone'], $_POST['user_admissao'], $_POST['user_cargo']);
                 */
                $this->editUserName($_POST['user_name']);
// user try to change his email
// function below uses use $_SESSION['user_id'] et $_SESSION['user_email']
                $this->editUserEmail($_POST['user_email']);
// user try to change his password
            } elseif (isset($_POST["user_edit_submit_outros"])) {
                $this->editUserCpf($_POST['user_cpf']);
                // $this->editUserDates($_POST['user_sexo'], $_POST['user_nasc']);         
                // $this->editUserDates($_POST['user_sexo'], $_POST['user_nasc'], $_POST['user_formacao']); 
                $this->editUserDates($_POST['user_nome'], $_POST['user_sexo'], $_POST['user_nasc'], $_POST['user_formacao'], $_POST['user_fone'], $_POST['user_admissao'], $_POST['user_cargo']);


// $this->editUserDates($this->user_id, $_POST['user_nome'], $_POST['user_cpf'], $_POST['user_sexo'], $_POST['user_nasc'], $_POST['user_formacao'], $_POST['user_fone'], $_POST['user_admissao'], $_POST['user_cargo']);
            } elseif (isset($_POST["user_edit_submit_password"])) {
// function below uses $_SESSION['user_name'] and $_SESSION['user_id']
                $this->editUserPassword($_POST['user_password_old'], $_POST['user_password_new'], $_POST['user_password_repeat']);
            }

// login with cookie
        } elseif (isset($_COOKIE['rememberme'])) {
            $this->loginWithCookieData();

// if user just submitted a login form
        } elseif (isset($_POST["login"])) {
            if (!isset($_POST['user_rememberme'])) {
                $_POST['user_rememberme'] = null;
            }
            $this->loginWithPostData($_POST['user_name'], $_POST['user_password'], $_POST['user_rememberme']);
        }

// checking if user requested a password reset mail
        if (isset($_POST["request_password_reset"]) && isset($_POST['user_name'])) {
            $this->setPasswordResetDatabaseTokenAndSendMail($_POST['user_name']);
        } elseif (isset($_GET["user_name"]) && isset($_GET["verification_code"])) {
            $this->checkIfEmailVerificationCodeIsValid($_GET["user_name"], $_GET["verification_code"]);
        } elseif (isset($_POST["submit_new_password"])) {
            $this->editNewPassword($_POST['user_name'], $_POST['user_password_reset_hash'], $_POST['user_password_new'], $_POST['user_password_repeat']);
        }

// get gravatar profile picture if user is logged in
        if ($this->isUserLoggedIn() == true) {
            $this->getGravatarImageUrl($this->user_email);
        }
    }

    /**
     * Checks if database connection is opened. If not, then this method tries to open it.
     * @return bool Success status of the database connecting process
     */
    private function databaseConnection() {
// if connection already exists
        if ($this->db_connection != null) {
            return true;
        } else {
            try {
                $this->db_connection = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASS);			
                return true;
            } catch (PDOException $e) {
                $this->errors[] = MESSAGE_DATABASE_ERROR . $e->getMessage();
            }
        }
// default return
        return false;
    }

    /**
     * Search into database for the user data of user_name specified as parameter
     * @return user data as an object if existing user
     * @return false if user_name is not found in the database
     * TODO: @devplanete This returns two different types. Maybe this is valid, but it feels bad. We should rework this.
     * TODO: @devplanete After some resarch I'm VERY sure that this is not good coding style! Please fix this.
     */
    private function getUserData($user_name) {
// if database connection opened
        if ($this->databaseConnection()) {
// database query, getting all the info of the selected user
            $query_user = $this->db_connection->prepare('SELECT * FROM users WHERE user_name = :user_name');
            $query_user->bindValue(':user_name', $user_name, PDO::PARAM_STR);                                     //
            $query_user->execute();
// get result row (as an object)
            return $query_user->fetchObject();
        } else {
            return false;
        }
    }

    private function getUserData2($user_id) {
// if database connection opened
        if ($this->databaseConnection()) {
// database query, getting all the info of the selected user

            $query_user = $this->db_connection->prepare('SELECT * FROM users_dates WHERE user_id= :user_id');
            $query_user->bindValue(':user_id', $user_id, PDO::PARAM_STR);                                     //
            $query_user->execute();
// get result row (as an object)
            return $query_user->fetchObject();
        } else {
            return false;
        }
    }
	
	
    private function isAdm($user_name) {
// if database connection opened
        if ($this->databaseConnection()) {
// database query, getting all the info of the selected user
            $query_user = $this->db_connection->prepare('SELECT * FROM users WHERE user_name = :user_name');
            $query_user->bindValue(':user_name', $user_name, PDO::PARAM_STR);                                     //
            $query_user->execute();
// get result row (as an object)
            return $query_user->fetchObject();
        } else {
            return false;
        }
    }
	

    /**
     * Logs in with S_SESSION data.
     * Technically we are already logged in at that point of time, as the $_SESSION values already exist.
     */
    private function loginWithSessionData() {
        $this->user_name = $_SESSION['user_name'];
        $this->user_email = $_SESSION['user_email'];
        $this->user_nome = $_SESSION['user_nome'];
        $this->user_cpf = $_SESSION['user_cpf'];
        $this->user_sexo = $_SESSION['user_sexo'];
        $this->user_nasc = $_SESSION['user_nasc'];
        $this->user_formacao = $_SESSION['user_formacao'];
        $this->user_fone = $_SESSION['user_fone'];
        $this->user_admissao = $_SESSION['user_admissao'];
        $this->user_cargo = $_SESSION['user_cargo'];
        $this->user_is_logged_in = true;
    }

    /**
     * Logs in via the Cookie
     * @return bool success state of cookie login
     */
    private function loginWithCookieData() {
        if (isset($_COOKIE['rememberme'])) {
// extract data from the cookie
            list ($user_id, $token, $hash) = explode(':', $_COOKIE['rememberme']);
// check cookie hash validity
            if ($hash == hash('sha256', $user_id . ':' . $token . COOKIE_SECRET_KEY) && !empty($token)) {
// cookie looks good, try to select corresponding user
                if ($this->databaseConnection()) {
// get real token from database (and all other data)
                    $sth = $this->db_connection->prepare("SELECT user_id, user_name, user_email FROM users WHERE user_id = :user_id
                                                      AND user_rememberme_token = :user_rememberme_token AND user_rememberme_token IS NOT NULL");
                    $sth->bindValue(':user_id', $user_id, PDO::PARAM_INT);
                    $sth->bindValue(':user_rememberme_token', $token, PDO::PARAM_STR);
                    $sth->execute();
// get result row (as an object)
                    $result_row = $sth->fetchObject();
// PEGA DADOS DA TABELA 2:
                    $sth2 = $this->db_connection->prepare('SELECT * FROM users_dates WHERE user_id= :user_id');
                    $sth2->bindValue(':user_id', $user_id, PDO::PARAM_INT);
                    $sth2->execute();
// get result row (as an object)
                    $result_row2 = $sth2->fetchObject();

                    if (!isset($result_row->user_id) OR ! isset($result_row2->user_id)) {

                        $_SESSION['user_id'] = $result_row->user_id;
                        $_SESSION['user_name'] = $result_row->user_name;
                        $_SESSION['user_email'] = $result_row->user_email;
                        $_SESSION['user_nome'] = $result_row2->user_nome;
                        $_SESSION['user_cpf'] = $result_row2->user_cpf;
                        $_SESSION['user_sexo'] = $result_row2->user_sexo;
                        $_SESSION['user_nasc'] = $result_row2->user_nasc;
                        $_SESSION['user_formacao'] = $result_row2->user_formacao;
                        $_SESSION['user_fone'] = $result_row2->user_fone;
                        $_SESSION['user_admissao'] = $result_row2->user_admissao;
                        $_SESSION['user_cargo'] = $result_row2->user_cargo;
                        $_SESSION['user_logged_in'] = 1;
// declare user id, set the login status to true
                        $this->user_id = $result_row->user_id;
                        $this->user_name = $result_row->user_name;
                        $this->user_email = $result_row->user_email;
                        $this->user_nome = $result_row2->user_nome;
                        $this->user_cpf = $result_row2->user_cpf;
                        $this->user_sexo = $result_row2->user_sexo;
                        $this->user_nasc = $result_row2->user_nasc;
                        $this->user_formacao = $result_row2->user_formacao;
                        $this->user_fone = $result_row2->user_fone;
                        $this->user_admissao = $result_row2->user_admissao;
                        $this->user_cargo = $result_row2->user_cargo;
                        $this->user_is_logged_in = true;

// Cookie token usable only once
                        $this->newRememberMeCookie();
                        return true;
                    }
                }
            }
// A cookie has been used but is not valid... we delete it
            $this->deleteRememberMeCookie();
            $this->errors[] = MESSAGE_COOKIE_INVALID;
        }
        return false;
    }

    /**
     * Logs in with the data provided in $_POST, coming from the login form
     * @param $user_name
     * @param $user_password
     * @param $user_rememberme
     */
    private function loginWithPostData($user_name, $user_password, $user_rememberme) {
        if (empty($user_name)) {
            $this->errors[] = MESSAGE_USERNAME_EMPTY;
        } else if (empty($user_password)) {
            $this->errors[] = MESSAGE_PASSWORD_EMPTY;

// if POST data (from login form) contains non-empty user_name and non-empty user_password
        } else {
// user can login with his username or his email address.
// if user has not typed a valid email address, we try to identify him with his user_name
            if (!filter_var($user_name, FILTER_VALIDATE_EMAIL)) {
// database query, getting all the info of the selected user
                $result_row = $this->getUserData(trim($user_name));

                if (isset($result_row->user_id)) {
                    $_SESSION['user_id'] = $result_row->user_id;
                    $this->user_id = $result_row->user_id;
                    $result_row2 = $this->getUserData2($this->user_id);
                } else {
                    $this->errors[] = 'Usuário não Existe </br>';
                    return;
                }

// $result_row2 = $this->getUserData(trim($user_name));
// if user has typed a valid email address, we try to identify him with his user_email
            } else if ($this->databaseConnection()) {
// database query, getting all the info of the selected user
                /*
                  $query_user = $this->db_connection->prepare('SELECT * FROM users WHERE user_email = :user_email');
                  $query_user->bindValue(':user_email', trim($user_name), PDO::PARAM_STR);
                  $query_user->execute();
                  // get result row (as an object)
                  $result_row = $query_user->fetchObject();
                 */
            }

// if this user not exists
            if (!isset($result_row->user_id) OR ! isset($result_row2->user_id)) {
// was MESSAGE_USER_DOES_NOT_EXIST before, but has changed to MESSAGE_LOGIN_FAILED
// to prevent potential attackers showing if the user exists
                $this->errors[] = MESSAGE_LOGIN_FAILED;
            } else if (($result_row->user_failed_logins >= 3) && ($result_row->user_last_failed_login > (time() - 30))) {
                $this->errors[] = MESSAGE_PASSWORD_WRONG_3_TIMES;
// using PHP 5.5's password_verify() function to check if the provided passwords fits to the hash of that user's password
            } else if (!password_verify($user_password, $result_row->user_password_hash)) {
// increment the failed login counter for that user
                $sth = $this->db_connection->prepare('UPDATE users '
                        . 'SET user_failed_logins = user_failed_logins+1, user_last_failed_login = :user_last_failed_login '
                        . 'WHERE user_name = :user_name OR user_email = :user_name');
                $sth->execute(array(':user_name' => $user_name, ':user_last_failed_login' => time()));

                $this->errors[] = MESSAGE_PASSWORD_WRONG;
// has the user activated their account with the verification email
            } else if ($result_row->user_active != 1) {
                $this->errors[] = MESSAGE_ACCOUNT_NOT_ACTIVATED;
            } else {
// write user data into PHP SESSION [a file on your server]
                $_SESSION['user_id'] = $result_row->user_id;
                $_SESSION['user_name'] = $result_row->user_name;
                $_SESSION['user_email'] = $result_row->user_email;

                $_SESSION['user_nome'] = $result_row2->user_nome;
                $_SESSION['user_cpf'] = $result_row2->user_cpf;
                $_SESSION['user_sexo'] = $result_row2->user_sexo;
                $_SESSION['user_nasc'] = $result_row2->user_nasc;
                $_SESSION['user_formacao'] = $result_row2->user_formacao;
                $_SESSION['user_fone'] = $result_row2->user_fone;
                $_SESSION['user_admissao'] = $result_row2->user_admissao;
                $_SESSION['user_cargo'] = $result_row2->user_cargo;
                $_SESSION['user_logged_in'] = 1;

// declare user id, set the login status to true
                $this->user_id = $result_row->user_id;
                $this->user_name = $result_row->user_name;
                $this->user_email = $result_row->user_email;

                $this->user_nome = $result_row2->user_nome;
                $this->user_cpf = $result_row2->user_cpf;
                $this->user_sexo = $result_row2->user_sexo;
                $this->user_nasc = $result_row2->user_nasc;
                $this->user_formacao = $result_row2->user_formacao;
                $this->user_fone = $result_row2->user_fone;
                $this->user_admissao = $result_row2->user_admissao;
                $this->user_cargo = $result_row2->user_cargo;

                $this->user_is_logged_in = true;

// reset the failed login counter for that user
                $sth = $this->db_connection->prepare('UPDATE users '
                        . 'SET user_failed_logins = 0, user_last_failed_login = NULL '
                        . 'WHERE user_id = :user_id AND user_failed_logins != 0');
                $sth->execute(array(':user_id' => $result_row->user_id));

// if user has check the "remember me" checkbox, then generate token and write cookie
                if (isset($user_rememberme)) {
                    $this->newRememberMeCookie();
                } else {
// Reset remember-me token
                    $this->deleteRememberMeCookie();
                }

// OPTIONAL: recalculate the user's password hash
// DELETE this if-block if you like, it only exists to recalculate users's hashes when you provide a cost factor,
// by default the script will use a cost factor of 10 and never change it.
// check if the have defined a cost factor in config/hashing.php
                if (defined('HASH_COST_FACTOR')) {
// check if the hash needs to be rehashed
                    if (password_needs_rehash($result_row->user_password_hash, PASSWORD_DEFAULT, array('cost' => HASH_COST_FACTOR))) {

// calculate new hash with new cost factor
                        $user_password_hash = password_hash($user_password, PASSWORD_DEFAULT, array('cost' => HASH_COST_FACTOR));

// TODO: this should be put into another method !?
                        $query_update = $this->db_connection->prepare('UPDATE users SET user_password_hash = :user_password_hash WHERE user_id = :user_id');
                        $query_update->bindValue(':user_password_hash', $user_password_hash, PDO::PARAM_STR);
                        $query_update->bindValue(':user_id', $result_row->user_id, PDO::PARAM_INT);
                        $query_update->execute();

                        if ($query_update->rowCount() == 0) {
// writing new hash was successful. you should now output this to the user ;)
                        } else {
// writing new hash was NOT successful. you should now output this to the user ;)
                        }
                    }
                }
            }
        }
    }

    /**
     * Create all data needed for remember me cookie connection on client and server side
     */
    private function newRememberMeCookie() {
// if database connection opened
        if ($this->databaseConnection()) {
// generate 64 char random string and store it in current user data
            $random_token_string = hash('sha256', mt_rand());
            $sth = $this->db_connection->prepare("UPDATE users SET user_rememberme_token = :user_rememberme_token WHERE user_id = :user_id");
            $sth->execute(array(':user_rememberme_token' => $random_token_string, ':user_id' => $_SESSION['user_id']));

// generate cookie string that consists of userid, randomstring and combined hash of both
            $cookie_string_first_part = $_SESSION['user_id'] . ':' . $random_token_string;
            $cookie_string_hash = hash('sha256', $cookie_string_first_part . COOKIE_SECRET_KEY);
            $cookie_string = $cookie_string_first_part . ':' . $cookie_string_hash;

// set cookie
            setcookie('rememberme', $cookie_string, time() + COOKIE_RUNTIME, "/", COOKIE_DOMAIN);
        }
    }

    /**
     * Delete all data needed for remember me cookie connection on client and server side
     */
    private function deleteRememberMeCookie() {
// if database connection opened
        if ($this->databaseConnection()) {
// Reset rememberme token
            $sth = $this->db_connection->prepare("UPDATE users SET user_rememberme_token = NULL WHERE user_id = :user_id");
            $sth->execute(array(':user_id' => $_SESSION['user_id']));
        }
// set the rememberme-cookie to ten years ago (3600sec * 365 days * 10).
// that's obivously the best practice to kill a cookie via php
// @see http://stackoverflow.com/a/686166/1114320
        setcookie('rememberme', false, time() - (3600 * 3650), '/', COOKIE_DOMAIN);
    }

    /**
     * Perform the logout, resetting the session
     */
    public function doLogout() {
        $this->deleteRememberMeCookie();

        $_SESSION = array();
        session_destroy();

        $this->user_is_logged_in = false;
        $this->messages[] = MESSAGE_LOGGED_OUT;
    }

    /**
     * Simply return the current state of the user's login
     * @return bool user's login status
     */
    public function isUserLoggedIn() {
        return $this->user_is_logged_in;
    }

    /**
     * Edit the user's name, provided in the editing form
     */
    public function editUserName($user_name) {
// prevent database flooding
        $user_name = substr(trim($user_name), 0, 64);

        if (!empty($user_name) && $user_name == $_SESSION['user_name']) {
            $this->errors[] = MESSAGE_USERNAME_SAME_LIKE_OLD_ONE;

// username cannot be empty and must be azAZ09 and 2-64 characters
// TODO: maybe this pattern should also be implemented in Registration.php (or other way round)
        } elseif (empty($user_name) || !preg_match("/^(?=.{2,64}$)[a-zA-Z][a-zA-Z0-9]*(?: [a-zA-Z0-9]+)*$/", $user_name)) {
            $this->errors[] = MESSAGE_USERNAME_INVALID;
        } else {
// check if new username already exists
            $result_row = $this->getUserData($user_name);

            if (isset($result_row->user_id)) {
                $this->errors[] = MESSAGE_USERNAME_EXISTS;
            } else {
// write user's new data into database
                $query_edit_user_name = $this->db_connection->prepare('UPDATE users SET user_name = :user_name WHERE user_id = :user_id');
                $query_edit_user_name->bindValue(':user_name', $user_name, PDO::PARAM_STR);
                $query_edit_user_name->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
                $query_edit_user_name->execute();

                if ($query_edit_user_name->rowCount()) {
                    $_SESSION['user_name'] = $user_name;
                    $this->messages[] = MESSAGE_USERNAME_CHANGED_SUCCESSFULLY . $user_name;
                } else {
                    $this->errors[] = MESSAGE_USERNAME_CHANGE_FAILED;
                }
            }
        }
    }

    /**
     * Edit the user's email, provided in the editing form
     */
    public function editUserEmail($user_email) {
// prevent database flooding
        $user_email = substr(trim($user_email), 0, 64);

        if (!empty($user_email) && $user_email == $_SESSION["user_email"]) {
            $this->errors[] = MESSAGE_EMAIL_SAME_LIKE_OLD_ONE;
// user mail cannot be empty and must be in email format
        } elseif (empty($user_email) || !filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = MESSAGE_EMAIL_INVALID;
        } else if ($this->databaseConnection()) {
// check if new email already exists
            $query_user = $this->db_connection->prepare('SELECT * FROM users WHERE user_email = :user_email');
            $query_user->bindValue(':user_email', $user_email, PDO::PARAM_STR);
            $query_user->execute();
// get result row (as an object)
            $result_row = $query_user->fetchObject();

// if this email exists
            if (isset($result_row->user_id)) {
                $this->errors[] = MESSAGE_EMAIL_ALREADY_EXISTS;
            } else {
// write users new data into database
                $query_edit_user_email = $this->db_connection->prepare('UPDATE users SET user_email = :user_email WHERE user_id = :user_id');
                $query_edit_user_email->bindValue(':user_email', $user_email, PDO::PARAM_STR);
                $query_edit_user_email->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
                $query_edit_user_email->execute();

                if ($query_edit_user_email->rowCount()) {
                    $_SESSION['user_email'] = $user_email;
                    $this->messages[] = MESSAGE_EMAIL_CHANGED_SUCCESSFULLY . $user_email;
                } else {
                    $this->errors[] = MESSAGE_EMAIL_CHANGE_FAILED;
                }
            }
        }
    }

    private function editUserCpf($user_cpf) {
// prevent database flooding
// $user_cpf = substr(trim($user_cpf), 0, 64);
        $this->validaCPF($_POST['user_cpf']);   // vê se cpf é válido, mas não impede de inseri-lo
        if ($this->databaseConnection()) {
// check if new cpf already exists
            $query_user = $this->db_connection->prepare('SELECT * FROM users_dates WHERE user_cpf = :user_cpf');
            $query_user->bindValue(':user_cpf', $user_cpf, PDO::PARAM_STR);
            $query_user->execute();
// get result row (as an object)
            $result_row = $query_user->fetchObject();
// if this cpf exists
            //            if (!empty($user_cpf) && !($user_cpf == $_SESSION["user_cpf"])) { 

            if (($user_cpf == $_SESSION["user_cpf"])) {
                $this->errors[] = 'cpf é igual ao anterior';    // break
            } else {
                if (isset($result_row->user_id)) {
                    $this->errors[] = 'cpf já existe em outro cadastro';
                } else {
// write users new data into database
                    $query_edit_user_cpf = $this->db_connection->prepare('UPDATE users_dates SET user_cpf = :user_cpf WHERE user_id = :user_id');
                    $query_edit_user_cpf->bindValue(':user_cpf', $user_cpf, PDO::PARAM_STR);
                    $query_edit_user_cpf->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
                    $query_edit_user_cpf->execute();

                    if ($query_edit_user_cpf->rowCount()) {
                        $_SESSION['user_cpf'] = $user_cpf;
                        $this->messages[] = '</br> alteração de cpf ' . $user_cpf;
                    } else {
                        $this->errors[] = '</br> alteração de cpf falhou';
                    }
                }
            }//
        }
    }

    // private function editUserDates($user_sexo, $user_nasc, $user_formacao) {
    private function editUserDates($user_nome, $user_sexo, $user_nasc, $user_formacao, $user_fone, $user_admissao, $user_cargo) {
// prevent database flooding
// $user_sexo = substr(trim($user_sexo), 0, 64);
        if ($this->databaseConnection()) {
// write users new data into database
            $query_edit_user_sexo = $this->db_connection->prepare('UPDATE users_dates '
                    . 'SET user_nome = :user_nome, user_sexo = :user_sexo, user_nasc = :user_nasc, user_formacao = :user_formacao,'
                    . ' user_fone = :user_fone, user_admissao = :user_admissao, user_cargo = :user_cargo'
                    . ' WHERE user_id = :user_id');

            $query_edit_user_sexo->bindValue(':user_nome', $user_nome, PDO::PARAM_STR);
            $query_edit_user_sexo->bindValue(':user_sexo', $user_sexo, PDO::PARAM_STR);
            $query_edit_user_sexo->bindValue(':user_nasc', $user_nasc, PDO::PARAM_STR);
            $query_edit_user_sexo->bindValue(':user_formacao', $user_formacao, PDO::PARAM_STR);
            $query_edit_user_sexo->bindValue(':user_fone', $user_fone, PDO::PARAM_STR);
            $query_edit_user_sexo->bindValue(':user_admissao', $user_admissao, PDO::PARAM_STR);
            $query_edit_user_sexo->bindValue(':user_cargo', $user_cargo, PDO::PARAM_STR);


            $query_edit_user_sexo->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
            $query_edit_user_sexo->execute();

            if ($query_edit_user_sexo->rowCount()) {
                $_SESSION['user_nome'] = $user_nome;
                $_SESSION['user_sexo'] = $user_sexo;
                $_SESSION['user_nasc'] = $user_nasc;
                $_SESSION['user_formacao'] = $user_formacao;
                $_SESSION['user_fone'] = $user_fone;
                $_SESSION['user_admissao'] = $user_admissao;
                $_SESSION['user_cargo'] = $user_cargo;

                $this->messages[] = ' </br> Nome alterado: ' . $user_nome;
                $this->messages[] = ' </br> Sexo alterado: ' . $user_sexo;
                $this->messages[] = ' </br> Data Nascimento alterado: ' . $user_nasc;
                $this->messages[] = ' </br> Formação alterado: ' . $user_formacao;
                $this->messages[] = ' </br> Fone alterado: ' . $user_fone;
                $this->messages[] = ' </br> Admissao alterado: ' . $user_admissao;
                $this->messages[] = ' </br> Cargo alterado: ' . $user_cargo;
            } else {
                $this->errors[] = '</br> Nenhum dados alterado ';
            }
        }
    }

    function validaCPF($user_cpf) {
// Verifica se um número foi informado
        if (empty($user_cpf)) {
            return false;
        }
// Elimina possivel mascara
// $user_cpf = ereg_replace('[^0-9]', '', $user_cpf);
// $user_cpf = str_pad($user_cpf, 11, '0', STR_PAD_LEFT);
// Verifica se o numero de digitos informados é igual a 11 
        if (strlen($user_cpf) != 11) {
            return false;
        }
// Verifica se nenhuma das sequências invalidas abaixo 
// foi digitada. Caso afirmativo, retorna falso
        else if ($user_cpf == '00000000000' ||
                $user_cpf == '11111111111' ||
                $user_cpf == '22222222222' ||
                $user_cpf == '33333333333' ||
                $user_cpf == '44444444444' ||
                $user_cpf == '55555555555' ||
                $user_cpf == '66666666666' ||
                $user_cpf == '77777777777' ||
                $user_cpf == '88888888888' ||
                $user_cpf == '99999999999') {
            return false;
// Calcula os digitos verificadores para verificar se o
// user_cpf é válido
        } else {
            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $user_cpf{$c} * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($user_cpf{$c} != $d) {
                    echo'user_cpf FALSO';
                    return false;
                }
            }
            echo'user_cpf OK';
            return true;
        }
    }

    /**
     * Edit the user's password, provided in the editing form
     */
    public function editUserPassword($user_password_old, $user_password_new, $user_password_repeat) {
        if (empty($user_password_new) || empty($user_password_repeat) || empty($user_password_old)) {
            $this->errors[] = MESSAGE_PASSWORD_EMPTY;
// is the repeat password identical to password
        } elseif ($user_password_new !== $user_password_repeat) {
            $this->errors[] = MESSAGE_PASSWORD_BAD_CONFIRM;
// password need to have a minimum length of 6 characters
        } elseif (strlen($user_password_new) < 6) {
            $this->errors[] = MESSAGE_PASSWORD_TOO_SHORT;

// all the above tests are ok
        } else {
// database query, getting hash of currently logged in user (to check with just provided password)
            $result_row = $this->getUserData($_SESSION['user_name']);

// if this user exists
            if (isset($result_row->user_password_hash)) {

// using PHP 5.5's password_verify() function to check if the provided passwords fits to the hash of that user's password
                if (password_verify($user_password_old, $result_row->user_password_hash)) {

// now it gets a little bit crazy: check if we have a constant HASH_COST_FACTOR defined (in config/hashing.php),
// if so: put the value into $hash_cost_factor, if not, make $hash_cost_factor = null
                    $hash_cost_factor = (defined('HASH_COST_FACTOR') ? HASH_COST_FACTOR : null);

// crypt the user's password with the PHP 5.5's password_hash() function, results in a 60 character hash string
// the PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using PHP 5.3/5.4, by the password hashing
// compatibility library. the third parameter looks a little bit shitty, but that's how those PHP 5.5 functions
// want the parameter: as an array with, currently only used with 'cost' => XX.
                    $user_password_hash = password_hash($user_password_new, PASSWORD_DEFAULT, array('cost' => $hash_cost_factor));

// write users new hash into database
                    $query_update = $this->db_connection->prepare('UPDATE users SET user_password_hash = :user_password_hash WHERE user_id = :user_id');
                    $query_update->bindValue(':user_password_hash', $user_password_hash, PDO::PARAM_STR);
                    $query_update->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
                    $query_update->execute();

// check if exactly one row was successfully changed:
                    if ($query_update->rowCount()) {
                        $this->messages[] = MESSAGE_PASSWORD_CHANGED_SUCCESSFULLY;
                    } else {
                        $this->errors[] = MESSAGE_PASSWORD_CHANGE_FAILED;
                    }
                } else {
                    $this->errors[] = MESSAGE_OLD_PASSWORD_WRONG;
                }
            } else {
                $this->errors[] = MESSAGE_USER_DOES_NOT_EXIST;
            }
        }
    }

    /**
     * Sets a random token into the database (that will verify the user when he/she comes back via the link
     * in the email) and sends the according email.
     */
    public function setPasswordResetDatabaseTokenAndSendMail($user_name) {
        $user_name = trim($user_name);

        if (empty($user_name)) {
            $this->errors[] = MESSAGE_USERNAME_EMPTY;
        } else {
// generate timestamp (to see when exactly the user (or an attacker) requested the password reset mail)
// btw this is an integer ;)
            $temporary_timestamp = time();
// generate random hash for email password reset verification (40 char string)
            $user_password_reset_hash = sha1(uniqid(mt_rand(), true));
// database query, getting all the info of the selected user
            $result_row = $this->getUserData($user_name);

// if this user exists
            if (isset($result_row->user_id)) {

// database query:
                $query_update = $this->db_connection->prepare('UPDATE users SET user_password_reset_hash = :user_password_reset_hash,
                                                               user_password_reset_timestamp = :user_password_reset_timestamp
                                                               WHERE user_name = :user_name');
                $query_update->bindValue(':user_password_reset_hash', $user_password_reset_hash, PDO::PARAM_STR);
                $query_update->bindValue(':user_password_reset_timestamp', $temporary_timestamp, PDO::PARAM_INT);
                $query_update->bindValue(':user_name', $user_name, PDO::PARAM_STR);
                $query_update->execute();

// check if exactly one row was successfully changed:
                if ($query_update->rowCount() == 1) {
// send a mail to the user, containing a link with that token hash string
                    $this->sendPasswordResetMail($user_name, $result_row->user_email, $user_password_reset_hash);
                    return true;
                } else {
                    $this->errors[] = MESSAGE_DATABASE_ERROR;
                }
            } else {
                $this->errors[] = MESSAGE_USER_DOES_NOT_EXIST;
            }
        }
// return false (this method only returns true when the database entry has been set successfully)
        return false;
    }

    /**
     * Sends the password-reset-email.
     */
    public function sendPasswordResetMail($user_name, $user_email, $user_password_reset_hash) {
        $mail = new PHPMailer;

// please look into the config/config.php for much more info on how to use this!
// use SMTP or use mail()
        if (EMAIL_USE_SMTP) {
// Set mailer to use SMTP
            $mail->IsSMTP();
//useful for debugging, shows full SMTP errors
//$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
// Enable SMTP authentication
            $mail->SMTPAuth = EMAIL_SMTP_AUTH;
// Enable encryption, usually SSL/TLS
            if (defined(EMAIL_SMTP_ENCRYPTION)) {
                $mail->SMTPSecure = EMAIL_SMTP_ENCRYPTION;
            }
// Specify host server
            $mail->Host = EMAIL_SMTP_HOST;
            $mail->Username = EMAIL_SMTP_USERNAME;
            $mail->Password = EMAIL_SMTP_PASSWORD;
            $mail->Port = EMAIL_SMTP_PORT;
        } else {
            $mail->IsMail();
        }

        $mail->From = EMAIL_PASSWORDRESET_FROM;
        $mail->FromName = EMAIL_PASSWORDRESET_FROM_NAME;
        $mail->AddAddress($user_email);
        $mail->Subject = EMAIL_PASSWORDRESET_SUBJECT;

        $link = EMAIL_PASSWORDRESET_URL . '?user_name=' . urlencode($user_name) . '&verification_code=' . urlencode($user_password_reset_hash);
        $mail->Body = EMAIL_PASSWORDRESET_CONTENT . ' ' . $link;

        if (!$mail->Send()) {
            $this->errors[] = MESSAGE_PASSWORD_RESET_MAIL_FAILED . $mail->ErrorInfo;
            return false;
        } else {
            $this->messages[] = MESSAGE_PASSWORD_RESET_MAIL_SUCCESSFULLY_SENT;
            return true;
        }
    }

    /**
     * Checks if the verification string in the account verification mail is valid and matches to the user.
     */
    public function checkIfEmailVerificationCodeIsValid($user_name, $verification_code) {
        $user_name = trim($user_name);

        if (empty($user_name) || empty($verification_code)) {
            $this->errors[] = MESSAGE_LINK_PARAMETER_EMPTY;
        } else {
// database query, getting all the info of the selected user
            $result_row = $this->getUserData($user_name);

// if this user exists and have the same hash in database
            if (isset($result_row->user_id) && $result_row->user_password_reset_hash == $verification_code) {

                $timestamp_one_hour_ago = time() - 3600; // 3600 seconds are 1 hour

                if ($result_row->user_password_reset_timestamp > $timestamp_one_hour_ago) {
// set the marker to true, making it possible to show the password reset edit form view
                    $this->password_reset_link_is_valid = true;
                } else {
                    $this->errors[] = MESSAGE_RESET_LINK_HAS_EXPIRED;
                }
            } else {
                $this->errors[] = MESSAGE_USER_DOES_NOT_EXIST;
            }
        }
    }

    /**
     * Checks and writes the new password.
     */
    public function editNewPassword($user_name, $user_password_reset_hash, $user_password_new, $user_password_repeat) {
// TODO: timestamp!
        $user_name = trim($user_name);

        if (empty($user_name) || empty($user_password_reset_hash) || empty($user_password_new) || empty($user_password_repeat)) {
            $this->errors[] = MESSAGE_PASSWORD_EMPTY;
// is the repeat password identical to password
        } else if ($user_password_new !== $user_password_repeat) {
            $this->errors[] = MESSAGE_PASSWORD_BAD_CONFIRM;
// password need to have a minimum length of 6 characters
        } else if (strlen($user_password_new) < 6) {
            $this->errors[] = MESSAGE_PASSWORD_TOO_SHORT;
// if database connection opened
        } else if ($this->databaseConnection()) {
// now it gets a little bit crazy: check if we have a constant HASH_COST_FACTOR defined (in config/hashing.php),
// if so: put the value into $hash_cost_factor, if not, make $hash_cost_factor = null
            $hash_cost_factor = (defined('HASH_COST_FACTOR') ? HASH_COST_FACTOR : null);

// crypt the user's password with the PHP 5.5's password_hash() function, results in a 60 character hash string
// the PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using PHP 5.3/5.4, by the password hashing
// compatibility library. the third parameter looks a little bit shitty, but that's how those PHP 5.5 functions
// want the parameter: as an array with, currently only used with 'cost' => XX.
            $user_password_hash = password_hash($user_password_new, PASSWORD_DEFAULT, array('cost' => $hash_cost_factor));

// write users new hash into database
            $query_update = $this->db_connection->prepare('UPDATE users SET user_password_hash = :user_password_hash,
                                                           user_password_reset_hash = NULL, user_password_reset_timestamp = NULL
                                                           WHERE user_name = :user_name AND user_password_reset_hash = :user_password_reset_hash');
            $query_update->bindValue(':user_password_hash', $user_password_hash, PDO::PARAM_STR);
            $query_update->bindValue(':user_password_reset_hash', $user_password_reset_hash, PDO::PARAM_STR);
            $query_update->bindValue(':user_name', $user_name, PDO::PARAM_STR);
            $query_update->execute();

// check if exactly one row was successfully changed:
            if ($query_update->rowCount() == 1) {
                $this->password_reset_was_successful = true;
                $this->messages[] = MESSAGE_PASSWORD_CHANGED_SUCCESSFULLY;
            } else {
                $this->errors[] = MESSAGE_PASSWORD_CHANGE_FAILED;
            }
        }
    }

    /**
     * Gets the success state of the password-reset-link-validation.
     * TODO: should be more like getPasswordResetLinkValidationStatus
     * @return boolean
     */
    public function passwordResetLinkIsValid() {
        return $this->password_reset_link_is_valid;
    }

    /**
     * Gets the success state of the password-reset action.
     * TODO: should be more like getPasswordResetSuccessStatus
     * @return boolean
     */
    public function passwordResetWasSuccessful() {
        return $this->password_reset_was_successful;
    }

    /**
     * Gets the username
     * @return string username
     */
    public function getUsername() {
        return $this->user_name;
    }

    /**
     * Get either a Gravatar URL or complete image tag for a specified email address.
     * Gravatar is the #1 (free) provider for email address based global avatar hosting.
     * The URL (or image) returns always a .jpg file !
     * For deeper info on the different parameter possibilities:
     * @see http://de.gravatar.com/site/implement/images/
     *
     * @param string $email The email address
     * @param string $s Size in pixels, defaults to 50px [ 1 - 2048 ]
     * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
     * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
     * @param array $atts Optional, additional key/value attributes to include in the IMG tag
     * @source http://gravatar.com/site/implement/images/php/
     */
    public function getGravatarImageUrl($email, $s = 50, $d = 'mm', $r = 'g', $atts = array()) {
        $url = 'http://www.gravatar.com/avatar/';
        $url .= md5(strtolower(trim($email)));
        $url .= "?s=$s&d=$d&r=$r&f=y";

// the image url (on gravatarr servers), will return in something like
// http://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50?s=80&d=mm&r=g
// note: the url does NOT have something like .jpg
        $this->user_gravatar_image_url = $url;

// build img tag around
        $url = '<img src="' . $url . '"';
        foreach ($atts as $key => $val)
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';

// the image url like above but with an additional <img src .. /> around
        $this->user_gravatar_image_tag = $url;
    }

}
