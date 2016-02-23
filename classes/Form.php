<?php

/**
 * Handles the user registration
 * @author Panique
 * @link http://www.php-login.net
 * @link https://github.com/panique/php-login-advanced/
 * @license http://opensource.org/licenses/MIT MIT License
 */
class Form {

    /**
     * @var object $db_connection The database connection
     */
    private $db_connection = null;
    public $value = null;

    /**
     * @var bool success state of registration
     */
    public $registration_successful = false;  // serve para retornar a um menu anterior caso ja tenha cadastrado

    /**
     * @var bool success state of verification
     */
    public $verification_successful = false;

    /**
     * @var array collection of error messages
     */
    public $errors = array();

    /**
     * @var array collection of success / neutral messages
     */
    public $messages = array();

    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$login = new Login();"
     */
    public function __construct() {
        session_start();

        //$value = getValue();
        //echo $value;
        // if we have such a POST request, call the registerNewUser() method        //  ///

        if (isset($_POST["form_new_eixo"])) {
            $this->registerNewEixo($_POST['nome_eixo'], $_POST['desc_eixo']);
        }
        if (isset($_POST["form_new_subeixo"])) {
            $this->registerNewSubEixo($_POST['nome_subeixo'], $_POST['desc_subeixo'], $_POST['id_eixo'], $_POST['pont_max_subeixo']);
        }
        if (isset($_POST["form_new_item"])) {
            $this->registerNewItem($_POST['nome_item'], $_POST['id_subeixo'], null, $_POST['desc_item'], $_POST['pont_max_item'], $_POST['desc_pont_item'], $_POST['docprob_item']);
        }
        if (isset($_POST["form_new_subitem"])) {
            $this->registerNewItem($_POST['nome_item'], null, $_POST['id_itempai'], $_POST['desc_item'], $_POST['pont_max_item'], $_POST['desc_pont_item'], $_POST['docprob_item']);
        }
        if (isset($_POST["form_new_class"])) {
            $this->registerNewClass($_POST['nome_class'], null, $_POST['id_item'], $_POST['pont_max_class'], $_POST['desc_pont_class']);
        } else if (isset($_POST["register"])) {
            $this->registerNewUser($_POST['user_name'], $_POST['user_nome'], $_POST['user_email'], $_POST['user_password_new'], $_POST['user_password_repeat'], $_POST["captcha"]);
            // if we have such a GET request, call the verifyNewUser() method
        } else if (isset($_GET["id"]) && isset($_GET["verification_code"])) {
            $this->verifyNewUser($_GET["id"], $_GET["verification_code"]);
        }
    }

    /**
     * Checks if database connection is opened and open it if not
     */
    private function databaseConnection() {
        // connection already opened
        if ($this->db_connection != null) {
            return true;
        } else {
            // create a database connection, using the constants from config/config.php
            try {
                // Generate a database connection, using the PDO connector
                // @see http://net.tutsplus.com/tutorials/php/why-you-should-be-using-phps-pdo-for-database-access/
                // Also important: We include the charset, as leaving it out seems to be a security issue:
                // @see http://wiki.hashphp.org/PDO_Tutorial_for_MySQL_Developers#Connecting_to_MySQL says:
                // "Adding the charset to the DSN is very important for security reasons,
                // most examples you'll see around leave it out. MAKE SURE TO INCLUDE THE CHARSET!"
                $this->db_connection = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
                return true;
                // If an error is catched, database connection failed
            } catch (PDOException $e) {
                $this->errors[] = MESSAGE_DATABASE_ERROR;
                return false;
            }
        }
    }

    public static function connect() {
        //return $this->db_connection;
        return $db_connection;
    }

    /**
     * handles the entire registration process. checks all error possibilities, and creates a new user in the database if
     * everything is fine
     */
    private function registerNewUser($user_name, $user_nome, $user_email, $user_password, $user_password_repeat, $captcha) {
        // we just remove extra space on username and email
        $user_name = trim($user_name);
        $user_nome = trim($user_nome);
        $user_email = trim($user_email);


        // check provided data validity
        // TODO: check for "return true" case early, so put this first
        if (strtolower($captcha) != strtolower($_SESSION['captcha'])) {
            $this->errors[] = MESSAGE_CAPTCHA_WRONG;
        } elseif (empty($user_name)) {
            $this->errors[] = MESSAGE_USERNAME_EMPTY;
        } elseif (empty($user_password) || empty($user_password_repeat)) {
            $this->errors[] = MESSAGE_PASSWORD_EMPTY;
        } elseif ($user_password !== $user_password_repeat) {
            $this->errors[] = MESSAGE_PASSWORD_BAD_CONFIRM;
        } elseif (strlen($user_password) < 6) {
            $this->errors[] = MESSAGE_PASSWORD_TOO_SHORT;
        } elseif (strlen($user_name) > 64 || strlen($user_name) < 2) {
            $this->errors[] = MESSAGE_USERNAME_BAD_LENGTH;
        } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $user_name)) {
            $this->errors[] = MESSAGE_USERNAME_INVALID;
        } elseif (empty($user_email)) {
            $this->errors[] = MESSAGE_EMAIL_EMPTY;
        } elseif (strlen($user_email) > 64) {
            $this->errors[] = MESSAGE_EMAIL_TOO_LONG;
        } elseif (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = MESSAGE_EMAIL_INVALID;

            // finally if all the above checks are ok
        } else if ($this->databaseConnection()) {
            // check if username or email already exists
            $query_check_user_name = $this->db_connection->prepare('SELECT user_name, user_email FROM users WHERE user_name=:user_name OR user_email=:user_email');
            $query_check_user_name->bindValue(':user_name', $user_name, PDO::PARAM_STR);
            //   ///
            $query_check_user_name->bindValue(':user_email', $user_email, PDO::PARAM_STR);
            $query_check_user_name->execute();
            $result = $query_check_user_name->fetchAll();

            // if username or/and email find in the database
            // TODO: this is really awful!
            if (count($result) > 0) {
                for ($i = 0; $i < count($result); $i++) {
                    $this->errors[] = ($result[$i]['user_name'] == $user_name) ? MESSAGE_USERNAME_EXISTS : MESSAGE_EMAIL_ALREADY_EXISTS;
                }
            } else {
                // check if we have a constant HASH_COST_FACTOR defined (in config/hashing.php),
                // if so: put the value into $hash_cost_factor, if not, make $hash_cost_factor = null
                $hash_cost_factor = (defined('HASH_COST_FACTOR') ? HASH_COST_FACTOR : null);
                // crypt the user's password with the PHP 5.5's password_hash() function, results in a 60 character hash string
                // the PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using PHP 5.3/5.4, by the password hashing
                // compatibility library. the third parameter looks a little bit shitty, but that's how those PHP 5.5 functions
                // want the parameter: as an array with, currently only used with 'cost' => XX.
                $user_password_hash = password_hash($user_password, PASSWORD_DEFAULT, array('cost' => $hash_cost_factor));
                // generate random hash for email verification (40 char string)
                $user_activation_hash = sha1(uniqid(mt_rand(), true));
                // write new users data into database
                $query_new_user_insert = $this->db_connection->prepare('INSERT INTO users '
                        . '(user_name, user_nome, user_password_hash, user_email, user_activation_hash, user_registration_ip, user_registration_datetime) '
                        . 'VALUES(:user_name, :user_nome,:user_password_hash, :user_email, :user_activation_hash, :user_registration_ip, now())');
                $query_new_user_insert->bindValue(':user_name', $user_name, PDO::PARAM_STR);
                $query_new_user_insert->bindValue(':user_nome', $user_nome, PDO::PARAM_STR);     //   ///
                $query_new_user_insert->bindValue(':user_password_hash', $user_password_hash, PDO::PARAM_STR);
                $query_new_user_insert->bindValue(':user_email', $user_email, PDO::PARAM_STR);
                $query_new_user_insert->bindValue(':user_activation_hash', $user_activation_hash, PDO::PARAM_STR);
                $query_new_user_insert->bindValue(':user_registration_ip', $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR);
                $query_new_user_insert->execute();
                // id of new user
                $user_id = $this->db_connection->lastInsertId();


                if ($query_new_user_insert) {  // se foi inserido com sucesso
                    //para inserir na outra tabela
                    $this->registerNewUser2($user_id, $_POST['user_nome'], $_POST['user_email'], $_POST['user_cpf'], $_POST['user_sexo'], $_POST['user_nasc'], $_POST['user_formacao'], $_POST['user_fone'], $_POST['user_admissao'], $_POST['user_cargo']
                    );



                    if ($this->sendVerificationEmail($user_id, $user_email, $user_activation_hash)) {
                        // when mail has been send successfully
                        $this->messages[] = MESSAGE_VERIFICATION_MAIL_SENT . ' de mentinha</br>';
                        $this->registration_successful = true;
                    } else {  // nunca passará por aki, enqto for de mentirinha..
                        // delete this users account immediately, as we could not send a verification email
                        $query_delete_user = $this->db_connection->prepare('DELETE FROM users WHERE user_id=:user_id');
                        $query_delete_user->bindValue(':user_id', $user_id, PDO::PARAM_INT);
                        $query_delete_user->execute();
                        $this->errors[] = MESSAGE_VERIFICATION_MAIL_ERROR;
                    }
                } else {
                    $this->errors[] = MESSAGE_REGISTRATION_FAILED . '1';
                }
            }
        }
    }

    private function registerNewSubEixo($nome_subeixo, $desc_subeixo, $id_eixo, $pont_max_subeixo) {
        $nome_subeixo = trim($nome_subeixo);
        $desc_subeixo = trim($desc_subeixo);
        $id_eixo = trim($id_eixo);
        $pont_max_subeixo = trim($pont_max_subeixo);
        if ($this->databaseConnection()) {

            $query_new_user_insert = $this->db_connection->prepare('INSERT INTO subeixo '
                    . '(nome_subeixo, id_eixo, desc_subeixo, pont_max_subeixo) '
                    . 'VALUES(:nome_subeixo, :id_eixo, :desc_subeixo, :pont_max_subeixo)');
            $query_new_user_insert->bindValue(':nome_subeixo', $nome_subeixo, PDO::PARAM_STR);
            $query_new_user_insert->bindValue(':id_eixo', $id_eixo, PDO::PARAM_STR);
            $query_new_user_insert->bindValue(':desc_subeixo', $desc_subeixo, PDO::PARAM_STR);
            $query_new_user_insert->bindValue(':pont_max_subeixo', $pont_max_subeixo, PDO::PARAM_STR);
            $query_new_user_insert->execute();
            // id of new user
            $user_id = $this->db_connection->lastInsertId();
            if ($query_new_user_insert) {  // se foi inserido com sucesso
                echo 'SubEixo Cadastrado com Sucesso !';
            }
        }
    }

    private function registerNewItem($nome_item, $id_subeixo, $id_itempai, $desc_item, $pont_max_item, $desc_pont_item, $docprob_item) {
        $nome_item = trim($nome_item);
        $desc_item = trim($desc_item);
        $id_itempai = trim($id_itempai);
        $id_subeixo = trim($id_subeixo);
        $pont_max_item = trim($pont_max_item);
        $desc_pont_item = trim($desc_pont_item);
        $docprob_item = trim($docprob_item);
        if ($this->databaseConnection()) {

            $query_new_user_insert = $this->db_connection->prepare('INSERT INTO item '
                    . '(nome_item, id_subeixo, id_itempai, desc_item, pont_max_item, desc_pont_item,docprob_item) '
                    . 'VALUES(:nome_item, :id_subeixo, :id_itempai, :desc_item, :pont_max_item, :desc_pont_item,:docprob_item)');
            $query_new_user_insert->bindValue(':nome_item', $nome_item, PDO::PARAM_STR);
            $query_new_user_insert->bindValue(':id_subeixo', $id_subeixo, PDO::PARAM_STR);
            $query_new_user_insert->bindValue(':id_itempai', $id_itempai, PDO::PARAM_STR);
            $query_new_user_insert->bindValue(':desc_item', $desc_item, PDO::PARAM_STR);
            $query_new_user_insert->bindValue(':pont_max_item', $pont_max_item, PDO::PARAM_STR);
            $query_new_user_insert->bindValue(':desc_pont_item', $desc_pont_item, PDO::PARAM_STR);
            $query_new_user_insert->bindValue(':docprob_item', $docprob_item, PDO::PARAM_STR);
            $query_new_user_insert->execute();
            // id of new user
            $user_id = $this->db_connection->lastInsertId();
            if ($query_new_user_insert) {  // se foi inserido com sucesso
                if ($id_itempai == 0)
                    echo 'ITEM Cadastrado com Sucesso !';
                else
                    echo 'SUBITEM Cadastrado com Sucesso !';
            }
        }
    }

    private function registerNewClass($nome_class, $id_item, $pont_max_class, $desc_pont_class, $bonus_class) {

        if ($this->databaseConnection()) {

            $query_new_user_insert = $this->db_connection->prepare('INSERT INTO class '
                    . '(id_item, nome_class, pont_max_class, desc_pont_class) '
                    . 'VALUES(:id_item, :nome_class, :pont_max_class, :desc_pont_class)');

            $query_new_user_insert->bindValue(':id_item', $id_item, PDO::PARAM_STR);
            $query_new_user_insert->bindValue(':nome_class', $nome_class, PDO::PARAM_STR);
            $query_new_user_insert->bindValue(':pont_max_class', $pont_max_class, PDO::PARAM_STR);
            $query_new_user_insert->bindValue(':desc_pont_class', $desc_pont_class, PDO::PARAM_STR);
            //$query_new_user_insert->bindValue(':bonus_class', $bonus_class, PDO::PARAM_STR);

            $query_new_user_insert->execute();
            // id of new user
            $user_id = $this->db_connection->lastInsertId();
            if ($query_new_user_insert) {  // se foi inserido com sucesso
                echo 'CLASSIFICAÇÃO Cadastrada com Sucesso !';
            }
        }
    }

    private function registerNewEixo($nome_eixo, $desc_eixo) {
        $nome_eixo = trim($nome_eixo);
        $desc_eixo = trim($desc_eixo);
        if ($this->databaseConnection()) {

            $query_new_user_insert = $this->db_connection->prepare('INSERT INTO eixo '
                    . '(nome_eixo, desc_eixo) '
                    . 'VALUES(:nome_eixo, :desc_eixo)');
            $query_new_user_insert->bindValue(':nome_eixo', $nome_eixo, PDO::PARAM_STR);
            $query_new_user_insert->bindValue(':desc_eixo', $desc_eixo, PDO::PARAM_STR);
            $query_new_user_insert->execute();
            // id of new user
            // $user_id = $this->db_connection->lastInsertId();
            if ($query_new_user_insert) {  // se foi inserido com sucesso
                echo 'Eixo Cadastrado com Sucesso !';
            }
        }
    }

    private function getValue() {
        if ($this->databaseConnection()) {
            $query_user = $this->db_connection->prepare('SELECT id_eixo FROM eixo');                                   //
            $query_user->execute();
            return $query_user->fetchObject();
        } else {
            return false;
        }
    }

    private function registerNewUser2($user_id, $user_nome, $user_email, $user_cpf, $user_sexo, $user_nasc, $user_formacao, $user_fone, $user_admissao, $user_cargo) {
        if ($this->databaseConnection()) {
            $query_check_user_name = $this->db_connection->prepare('SELECT user_id, user_nome, user_cpf '
                    . 'FROM users_dates WHERE user_id=:user_id OR user_nome=:user_nome OR user_cpf=:user_cpf');
            $query_check_user_name->bindValue(':user_id', $user_id, PDO::PARAM_STR);
            $query_check_user_name->bindValue(':user_nome', $user_nome, PDO::PARAM_STR);
            $query_check_user_name->bindValue(':user_cpf', $user_cpf, PDO::PARAM_STR);
            $query_check_user_name->execute();
            $result = $query_check_user_name->fetchAll();

            if (count($result) > 0) {
                for ($i = 0; $i < count($result); $i++) {
                    //PODE PESSOAS COM MESMO NOME    // colocar opção para VERIFICAR SE HÁ CPFs IGUAIS
                    $this->errors[] = ($result[$i]['user_cpf'] == $user_cpf) ? ' cpf já existe :( ' : MESSAGE_EMAIL_ALREADY_EXISTS . ' cpf';
                }
            } else {  // SE NÃO ACHOU REPETIDOS:
                // check if we have a constant HASH_COST_FACTOR defined (in config/hashing.php),
                // if so: put the value into $hash_cost_factor, if not, make $hash_cost_factor = null
                // write new users data into database
                $query_new_user_insert = $this->db_connection->prepare('INSERT INTO users_dates '
                        . '(user_id, user_nome, user_cpf, user_sexo, user_nasc, user_formacao, user_fone, user_admissao, user_cargo)'
                        . 'VALUES(:user_id, :user_nome, :user_cpf, :user_sexo, :user_nasc, :user_formacao, :user_fone, :user_admissao, :user_cargo)');
                $query_new_user_insert->bindValue(':user_id', $user_id, PDO::PARAM_STR);
                $query_new_user_insert->bindValue(':user_nome', $user_nome, PDO::PARAM_STR);     //   ///                
                //$query_new_user_insert->bindValue(':user_email', $user_email, PDO::PARAM_STR);

                $query_new_user_insert->bindValue(':user_cpf', $user_cpf, PDO::PARAM_STR);
                $query_new_user_insert->bindValue(':user_sexo', $user_sexo, PDO::PARAM_STR);
                $query_new_user_insert->bindValue(':user_nasc', $user_nasc, PDO::PARAM_STR);
                $query_new_user_insert->bindValue(':user_formacao', $user_formacao, PDO::PARAM_STR);
                $query_new_user_insert->bindValue(':user_fone', $user_fone, PDO::PARAM_STR);
                $query_new_user_insert->bindValue(':user_admissao', $user_admissao, PDO::PARAM_STR);
                $query_new_user_insert->bindValue(':user_cargo', $user_cargo, PDO::PARAM_STR);

                $query_new_user_insert->execute();


                // id of new user  // ELE JÁ TEM O user_id
                //$user_id = $this->db_connection->lastInsertId();
                if ($query_new_user_insert) {
                    $this->messages[] = 'ok ';
                } else {
                    $query_delete_user = $this->db_connection->prepare('DELETE FROM users_dates WHERE user_id=:user_id');
                    $query_delete_user->bindValue(':user_id', $user_id, PDO::PARAM_INT);
                    $query_delete_user->execute();
                    //$this->deleteById('user', $user_id);
                    //$this->deleteById('user_dates', $user_id);
                    $this->errors[] = MESSAGE_REGISTRATION_FAILED . '  na inserção da tabela 2, tentei excluir linha inserida';
                    $this->errors[] = MESSAGE_VERIFICATION_MAIL_ERROR;
                }
            }
        }
    }

    private function deleteById($table, $user_id) {
        $query_delete_user = $this->db_connection->prepare('DELETE FROM table WHERE user_id=:user_id');
        $query_delete_user->bindValue(':table', $table, PDO::PARAM_INT);
        $query_delete_user->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $query_delete_user->execute();
        echo 'deletados';
    }

    /*
     * sends an email to the provided email address
     * @return boolean gives back true if mail has been sent, gives back false if no mail could been sent
     */

    public function sendVerificationEmail($user_id, $user_email, $user_activation_hash) {
        return true;  //
        /*  FUNÇÃO SUSPENSA TEMPORAREAMENTE !

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

          $mail->From = EMAIL_VERIFICATION_FROM;
          $mail->FromName = EMAIL_VERIFICATION_FROM_NAME;
          $mail->AddAddress($user_email);
          $mail->Subject = EMAIL_VERIFICATION_SUBJECT;

          $link = EMAIL_VERIFICATION_URL.'?id='.urlencode($user_id).'&verification_code='.urlencode($user_activation_hash);

          // the link to your register.php, please set this value in config/email_verification.php
          $mail->Body = EMAIL_VERIFICATION_CONTENT.' '.$link;

          if(!$mail->Send()) {
          $this->errors[] = MESSAGE_VERIFICATION_MAIL_NOT_SENT . $mail->ErrorInfo;
          return false;
          } else {
          return true;
          }

         */
    }

    /**
     * checks the id/verification code combination and set the user's activation status to true (=1) in the database
     */
    public function verifyNewUser($user_id, $user_activation_hash) {
        // if database connection opened
        if ($this->databaseConnection()) {
            // try to update user with specified information
            $query_update_user = $this->db_connection->prepare('UPDATE users SET user_active = 1, user_activation_hash = NULL WHERE user_id = :user_id AND user_activation_hash = :user_activation_hash');
            $query_update_user->bindValue(':user_id', intval(trim($user_id)), PDO::PARAM_INT);
            $query_update_user->bindValue(':user_activation_hash', $user_activation_hash, PDO::PARAM_STR);
            $query_update_user->execute();

            if ($query_update_user->rowCount() > 0) {
                $this->verification_successful = true;
                $this->messages[] = MESSAGE_REGISTRATION_ACTIVATION_SUCCESSFUL;
            } else {
                $this->errors[] = MESSAGE_REGISTRATION_ACTIVATION_NOT_SUCCESSFUL;
            }
        }
    }

}
