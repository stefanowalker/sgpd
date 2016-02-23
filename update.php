<?php 
	
	require 'database.php';

	$id_eixo = null;
	if ( !empty($_GET['id_eixo'])) {
		$id_eixo = $_REQUEST['id_eixo'];
		echo $id_eixo;		
	}
	
	if ( null==$id_eixo ) {
		header("Location: index.php");
	}
	
	if ( !empty($_POST)) {  // se _POST não for vazio
		
		echo ' testeeee ';
		// keep track validation errors
		$nome_eixoError = null;
		$desc_eixoError = null;
		$mobileError = null;
		
		echo $nome_eixoError;
		
		// keep track post values
		$nome_eixo = $_POST['nome_eixo'];
		$desc_eixo = $_POST['desc_eixo'];

		
		// validate input
		$valid = true;
		if (empty($nome_eixo)) {
			$nome_eixoError = 'Please enter nome_eixo';
			$valid = false;
		}
		
		if (empty($desc_eixo)) {
			$desc_eixoError = 'Please enter desc_eixo Address';
			$valid = false;
		} else if ( !filter_var($desc_eixo,FILTER_VALIDATE_desc_eixo) ) {
			$desc_eixoError = 'Please enter a valid desc_eixo Address';
			$valid = false;
		}
		
		echo 'testeeee';
		// update data
		if ($valid) {
			
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE eixo set nome_eixo = ?, desc_eixo = ? WHERE id_eixo = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($nome_eixo,$desc_eixo,$id_eixo));
			echo 'testeeee';
			Database::disconnect();
			header("Location: index.php");
		}
	} else {  // se _POST for vazio
		echo 'teste';
		
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM eixo where id_eixo = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id_eixo));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$nome_eixo = $data['nome_eixo'];
		$desc_eixo = $data['desc_eixo'];
		Database::disconnect();
	}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Update a Customer</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="update.php?id_eixo=<?php echo $id_eixo?>" method="post">
					  <div class="control-group <?php echo !empty($nome_eixoError)?'error':'';?>">
					    <label class="control-label">nome_eixo</label>
					    <div class="controls">
					      	<input nome_eixo="nome_eixo" type="text"  placeholder="nome_eixo" value="<?php echo !empty($nome_eixo)?$nome_eixo:'';?>">
					      	<?php if (!empty($nome_eixoError)): ?>
					      		<span class="help-inline"><?php echo $nome_eixoError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($desc_eixoError)?'error':'';?>">
					    <label class="control-label">desc_eixo</label>
					    <div class="controls">
					      	<input nome_eixo="desc_eixo" type="text" placeholder="desc_eixo Address" value="<?php echo !empty($desc_eixo)?$desc_eixo:'';?>">
					      	<?php if (!empty($desc_eixoError)): ?>
					      		<span class="help-inline"><?php echo $desc_eixoError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>

					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Update</button>
						  <a class="btn" href="formc.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>