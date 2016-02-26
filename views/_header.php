<!DOCTYPE html>
<html>
    <head>
        <!-- <meta charset="utf-8">  -->
        <title>sgpd</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<link rel="shortcut icon" href="favicon.ico" type="prog.png" />
        <link rel="stylesheet" type="text/css"  href="estilo.css" />
        <!--  <meta charset="utf-8"> -->

		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!--
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

        -->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="bijou-master/css/bijou.min.css">  <!-- // http://andhart.github.io/bijou/  css para tabela e font-->

		<script type="application/javascript" src="bootstrap/js/bootstrap.min.js"></script>
		
        <link   href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="bootstrap/js/jquery.min.js"></script>      
        <script src="bootstrap/js/bootstrap.min_tab.js"></script>  
<?php
 ini_set('default_charset','UTF-8');
?>
    <h3><?php echo "SISTEMA DE GESTÃO DE PROGRESSÃO DOCENTE "; ?></br></h3>
   <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    -->
    <style type="text/css">
        /* just for the demo */
		


        html {
			/*
            background-color: #e6e9e9;
            background-image: -webkit-linear-gradient(270deg,rgb(230,233,233) 0%,rgb(216,221,221) 100%);
            background-image: linear-gradient(270deg,rgb(230,233,233) 0%,rgb(216,221,221) 100%);
            -webkit-font-smoothing: antialiased;  */
        }

        body {
			display: block;
            margin: 0 auto;
            padding: 2em 2em 2em;
           // max-width: 900px;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 16px;
            line-height: 1.5em;
            color: #545454;
            background-color: #ffffff;
            box-shadow: 0 0 2px rgba(0, 0, 0, 0.06);
        }
		
		
		table {
    max-width: 540px;
}
td {
    width: 35px;
}
		
		/*http://www.bootply.com/98425#  */
			
		select {
			margin: 0px;
			width: 300px !important;			
		}
		select.custom {
			padding: 0px;
		}

        h1, h2, h3, h4, h5, h6 {
            color: #222;
            font-weight: 600;
            line-height: 1.3em;
        }

        h4 {
            color: #007FFF;
            font-weight: 600;
            line-height: 1.3em;
        }



        b, strong {
            font-weight: 600;
        }
        a {
            color: #0083e8;
        }
        li {
            display: block;
            margin-bottom: 20px;
        }

        img {
            -webkit-animation: colorize 2s cubic-bezier(0, 0, .78, .36) 1;
            animation: colorize 2s cubic-bezier(0, 0, .78, .36) 1;
            background: transparent;
            border: 10px solid rgba(0, 0, 0, 0.12);
            border-radius: 4px;
            display: block;
            margin: 1.3em auto;
            max-width: 70%;
        }



        label {
            position: relative;
            vertical-align: middle;
            bottom: 1px;
        }
		

		textarea,
        input[type=email],
        input[type=text],
        input[type=password],
		input[type=number],
        input[type=submit]{
            display: block;
            margin-bottom: 10px;
            padding: 5px;
            border: 1px solid #E5E5E5;
            width: 300px;
            color: 	#000000;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 8px;
            -moz-box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 8px;
            -webkit-box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 8px;		
        }

        input[type=checkbox] {
            margin-bottom: 15px;
        }
        input[type=text], input[type=text] {
            margin-bottom: 1px;
        } 



    </style>
</head>

<body>

    <!--
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">WebSiteName</a>
            </div>
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Home</a></li>
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Page 1 <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Page 1-1</a></li>
                        <li><a href="#">Page 1-2</a></li>
                        <li><a href="#">Page 1-3</a></li>
                    </ul>
                </li>
                <li><a href="#">Page 2</a></li>
                <li><a href="#">Page 3</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
            </ul>
        </div>
    </nav>
    -->

    <?php
    //include("menu.html");
// show potential errors / feedback (from login object)
    if (isset($login)) {
        if ($login->errors) {
            foreach ($login->errors as $error) {
                echo $error;
            }
        }
        if ($login->messages) {
            foreach ($login->messages as $message) {
                echo $message;
            }
        }
    }
    ?>

    <?php
// show potential errors / feedback (from registration object)
    if (isset($registration)) {
        if ($registration->errors) {
            foreach ($registration->errors as $error) {
                echo $error;
            }
        }
        if ($registration->messages) {
            foreach ($registration->messages as $message) {
                echo $message;
            }
        }
    }
    ?>
