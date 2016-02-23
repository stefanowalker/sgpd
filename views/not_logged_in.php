<?php include('_header.php'); ?>


<div class="container">
    <h2>Login</h2>
    <form class="form-horizontal" role="form" method="post" action="index.php" name="loginform">

        <div class="form-group">
            <label class="control-label col-sm-2" for="email">Usuário:</label>
            <div class="col-sm-10">
                <input id="user_name" class="form-control" type="text" name="user_name" placeholder="usuário" required />
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="pwd">Password:</label>
            <div class="col-sm-10">          
                <input id="user_password" class="form-control" type="password" name="user_password" autocomplete="off" value="123456" placeholder="Enter password" required />
            </div>
        </div>
        <div class="form-group">        
            <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">                        
                    <label>
                        <input type="checkbox" id="user_rememberme" value="1"> Remember me
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">        
            <div class="col-sm-offset-2 col-sm-10">
                <button name="login" type="submit" class="btn btn-success btn-lg">Entrar</button>
            </div>
        </div>


        <ul class="pager">
            <li><a class="col-sm-offset-2 col-sm-2" href="register.php"><?php echo WORDING_REGISTER_NEW_ACCOUNT; ?></a></li>
        </ul>
        <ul class="pager">
            <li><a class="col-sm-offset-2 col-sm-2" href="password_reset.php"><?php echo WORDING_FORGOT_MY_PASSWORD; ?></a></li>
        </ul>

    </form>
</div>

<!--
<ul class="pager">
    <li><a href="register.php"><?php echo WORDING_REGISTER_NEW_ACCOUNT; ?></a></li> </br>
    <li><a href="password_reset.php"><?php echo WORDING_FORGOT_MY_PASSWORD; ?></a></li>
</ul>
-->


<a href="register.php"></a></br>
<a href="password_reset.php"></a>

<?php include('_footer.php'); ?>
