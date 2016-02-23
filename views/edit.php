
<?php include('_header.php'); ?>

<!-- clean separation of HTML and PHP -->
<h3><?php echo 'EDITAR DADOS CADASTRAIS' ?></h3>
<!-- backlink 
<a href="index.php">VOLTAR</a>  -->

<ul class="pager">
    <li><a class="control-label col-sm-3" href="index.php"><?php echo WORDING_BACK_TO_LOGIN; ?></a></li>
</ul>

<h5><?php echo htmlspecialchars($_SESSION['user_name']); ?><?php echo WORDING_EDIT_YOUR_CREDENTIALS; ?></h5>



<form method="post" action="edit.php" name="user_edit_form_name"  class="form-horizontal" role="form">   <!-- o que importa é o name do button submit -->
    <h3>Alterar Dados do Login</h3>
    <div class="form-group">
        <label class="control-label col-sm-2" for="user_name">Usuário:</label>  
        <div class="col-sm-10">
            <input id="user_name" type="text" name="user_name" value=<?php echo htmlspecialchars($_SESSION['user_name']); ?> pattern="[a-zA-Z0-9]{2,64}" required />
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" for="user_email">Email</label>         
        <div class="col-sm-10"> 
            <input class="form-control" id="user_email" type="email" name="user_email" value=<?php echo htmlspecialchars($_SESSION['user_email']); ?> required /> 
        </div>
    </div>

    <div class="form-group"> 
        <div class="col-sm-offset-2 col-sm-10">         
            <button type="submit" class="btn btn-primary" name="user_edit_form_name"  >Alterar Dados de Login</button>
        </div>
    </div>
</form><hr/>



<form method="post" action="edit.php" name="user_edit_submit_outros" class="form-horizontal" role="form">
    <h3>Alterar Dados Cadastrais</h3>
    <div class="form-group">
        <label class="control-label col-sm-2" for="user_nome">Nome Completo:</label>  
        <div class="col-sm-10">
            <input id="user_nome" type="text" name="user_nome" value=<?php echo htmlspecialchars($_SESSION['user_nome']); ?> />
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="user_email">CPF:</label>         
        <div class="col-sm-10"> 
            <input class="form-control" id="user_cpf" type="text" name="user_cpf" value=<?php echo htmlspecialchars($_SESSION['user_cpf']); ?> pattern="[0-9]{11,11}" required />
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="user_email">Sexo:</label>         
        <div class="col-sm-10"> 
            <input class="form-control" id="user_sexo" type="text" name="user_sexo" value=<?php echo htmlspecialchars($_SESSION['user_sexo']); ?> /> 
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="user_email">Data de Nascimento:</label>         
        <div class="col-sm-10"> 
            <input class="form-control" id="user_nasc" type="text" name="user_nasc" value=<?php echo htmlspecialchars($_SESSION['user_nasc']); ?>  />
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="user_email">Formação:</label>         
        <div class="col-sm-10"> 		
            <input class="form-control" id="user_formacao" type="text" name="user_formacao" value=<?php echo htmlspecialchars($_SESSION['user_formacao']); ?> />
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="user_email">Fone:</label>         
        <div class="col-sm-10"> 
            <input class="form-control" id="user_fone" type="text" name="user_fone" value=<?php echo htmlspecialchars($_SESSION['user_fone']); ?> /> 
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="user_email">Admissão:</label>         
        <div class="col-sm-10"> 
            <input class="form-control" id="user_admissao" type="text" name="user_admissao" value=<?php echo htmlspecialchars($_SESSION['user_admissao']); ?>  />
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="user_email">Cargo:</label>         
        <div class="col-sm-10"> 
            <input class="form-control" id="user_cargo" type="text" name="user_cargo" value=<?php echo htmlspecialchars($_SESSION['user_cargo']); ?> />
        </div>
    </div>
    <div class="form-group"> 
        <div class="col-sm-offset-2 col-sm-10">         
            <button type="submit" class="btn btn-primary" name="user_edit_submit_outros"> Alterar Dados Pessoais </button>
        </div>
    </div>
</form><hr/>






<form class="form-horizontal" method="post" action="edit.php" name="user_edit_form_password" role="form">
    <h3>Alterar Senha</h3>
    <div class="form-group">
        <label class="control-label col-sm-2" for="email">Senha:</label>
        <div class="col-sm-10">
            <input id="user_password_old" class="form-control" type="password" name="user_password_old" autocomplete="off" placeholder="Senha Atual" />
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="pwd">Nova:</label>
        <div class="col-sm-10"> 
            <input id="user_password_new" class="form-control" type="password" name="user_password_new" autocomplete="off" placeholder="Nova Senha" />
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="pwd">Repetir:</label>
        <div class="col-sm-10"> 
            <input id="user_password_repeat" class="form-control" type="password" name="user_password_repeat" autocomplete="off" placeholder="Repetir Nova" />
        </div>
    </div>
    <div class="form-group"> 
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-primary" name="user_edit_submit_password">Alterar Senha</button>
        </div>
    </div>
</form><hr/>


<ul class="pager">
    <li><a class="control-label col-sm-3" href="index.php"><?php echo WORDING_BACK_TO_LOGIN; ?></a></li>
</ul>
<ul class="pager">
    <li><a class="control-label col-sm-2" href="index.php?logout">Logout</a></li>
</ul>

<?php include('_footer.php'); ?>
