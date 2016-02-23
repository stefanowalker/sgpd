<?php include('_header.php'); ?>
<a href="index.php"><?php echo WORDING_BACK_TO_LOGIN; ?></a>

<!-- show registration form, but only if we didn't submit already -->

<?php if (!$registration->registration_successful && !$registration->verification_successful) { ?>
    <h4><?php echo 'REGISTRAR CADASTRO' ?></h4>
    <form method="post" action="register.php" name="registerform">
        <label for="user_name"><?php echo WORDING_REGISTRATION_USERNAME; ?></label>
        <input id="user_name" type="text" pattern="[a-zA-Z0-9]{2,64}" name="user_name" required />

        <label for="user_nome"><?php echo 'Nome:'; ?></label>
        <input id="user_nome" type="text" pattern="{2,90}" name="user_nome" required value="nome"/>

        <label for="user_email"><?php echo WORDING_REGISTRATION_EMAIL; ?></label>
        <input id="user_email" type="email" name="user_email" required />	
        <!--
        public function editUserDates(
        $user_name, $user_nome, $user_cpf, $user_sexo, $user_nasc, $user_formacao, $user_fone, $user_admissao, $user_cargo)
        -->	
        <label for="user_cpf"><?php echo 'CPF:'; ?></label>
        <input id="user_cpf" type="text" pattern="[0-9]{1,13}" name="user_cpf" value="12345678900" required />

        <label for="user_sexo"><?php echo 'Sexo:'; ?></label>
        <input id="user_sexo" type="text" name="user_sexo" value="masculino"  />

        <label for="user_nasc"><?php echo 'Data Nascimento:'; ?></label>
        <input id="user_nasc" type="text" name="user_nasc" value="01/01/1991"  />

        <label for="user_formacao"><?php echo 'Formação:'; ?></label>
        <input id="user_formacao" type="text" name="user_formacao" value="Graduação"  />

        <label for="user_fone"><?php echo 'Número de Telefone:'; ?></label>
        <input id="user_fone" type="text" name="user_fone" value="8888-8888"  />	

        <label for="user_admissao"><?php echo 'Data de Admissão:'; ?></label>
        <input id="user_admissao" type="text" name="user_admissao" value="data"  />

        <label for="user_cargo"><?php echo 'Cargo:'; ?></label>
        <input id="user_cargo" type="text" name="user_cargo" value="Cargo"  />	

        </br>
        </br>
        <label for="user_password_new"><?php echo WORDING_REGISTRATION_PASSWORD; ?></label>
        <input id="user_password_new" type="password" name="user_password_new" pattern=".{6,}" required autocomplete="off" value="123456"/>

        <label for="user_password_repeat"><?php echo WORDING_REGISTRATION_PASSWORD_REPEAT; ?></label>
        <input id="user_password_repeat" type="password" name="user_password_repeat" pattern=".{6,}" required autocomplete="off" value="123456"/>

        <img src="tools/showCaptcha.php" alt="captcha" />

        <label><?php echo WORDING_REGISTRATION_CAPTCHA; ?></label>
        <input type="text" name="captcha" required />

        <input type="submit" name="register" value="<?php echo WORDING_REGISTER; ?>" />
    </form>
<?php } ?>
</br>
<a href="index.php"><?php echo WORDING_BACK_TO_LOGIN; ?></a>

<?php include('_footer.php'); ?>
