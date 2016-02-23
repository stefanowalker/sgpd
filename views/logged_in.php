<?php include('_header.php'); ?>
<h3><?php echo 'BEM VINDO'?></h3>
<?php
// if you need the user's information, just put them into the $_SESSION variable and output them here
echo WORDING_YOU_ARE_LOGGED_IN_AS . "'". htmlspecialchars($_SESSION['user_name']) ."'". "<br />";
//echo WORDING_PROFILE_PICTURE . '<br/><img src="' . $login->user_gravatar_image_url . '" />;
//echo WORDING_PROFILE_PICTURE . '<br/>' . $login->user_gravatar_image_tag;

echo "<a>Nome:  </a>"."'". htmlspecialchars($_SESSION['user_name']) ."'". "<br/>";
echo "<a>Email:  </a>"."'". htmlspecialchars($_SESSION['user_email']) ."'". "<br/>";
?>

<ul class="pager">
    <li><a class="control-label col-sm-4" href="edit.php"><?php echo WORDING_EDIT_USER_DATA; ?></a></li>
    </ul>
	
<ul class="pager">
    <li><a class="control-label col-sm-4" href="formc.php">Editar Formulário de Pontuação</a></li>
</ul>

<ul class="pager">
    <li><a class="control-label col-sm-4" href="index.php?logout">Logout</a></li>
</ul>




<?php include('_footer.php'); ?>
