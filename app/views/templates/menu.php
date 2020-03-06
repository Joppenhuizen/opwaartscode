<head>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>	
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="/public/css/custom.css">
</head>
<body>





<div class="navbar  transparent hidden-xs" style="    position: absolute;
    left: 1%; right:1%;">
      <div class="container">
        <a id="logo" href="/home" >OPWAARTS</a>
        <nav>
          <ul class="nav navbar-nav navbar-right">
            <li><a style="color:white;"href="/home">Home</a></li>              	
            <li><a style="color:white;"href="/projecten">Projecten</a></li>              	
            <li><a style="color:white;"href="/contact">Neem contact op</a></li>            
            <li><a style="color:white;"href="/about">Over ons</a></li>
            <li><a style="color:white;"href="/hoewerkthet">Hoe werkt het</a></li>

	<?php
			if(isset($_SESSION['user']))
			{ 
?>				<li><a href="/account">Account</a></li>
				<li><a href="/login/uitloggen">Uitloggen</a></li>
				<?php
				if($_SESSION['user']['rechten_id'] == 1 || $_SESSION['user']['rechten_id'] == 3)
				{
					?><li><a href="/admin">Admin</a></li><?php
				}?>
				<li><img style=" border-radius: 50%" src="/public<?php echo $_SESSION['user']['image_path'] ?>"/></li>
				<li style="color:#9d9d9d;margin-top:5px;margin-left:10px"><?php echo "voornaam:".$_SESSION['user']['voornaam']."<br>Balans: €".$_SESSION['user']['balans'].',-'?></li>
<?php
			}
			else
			{
?>				<li><a href="/registreren">Registreren</a></li>
				<li><a href="/login">Inloggen</a></li> 
<?php		}
	?>
	          </ul>
        </nav>

      </div>
    </div>	
