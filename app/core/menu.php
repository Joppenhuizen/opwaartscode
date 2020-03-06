<head>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>	
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<link src="/public/css/custom.css" rel="stylesheet" type='text/css' media="all"  data-turbolinks-track="true" >
</head>
<body>


<header class="navbar navbar-fixed-top navbar-inverse">
      <div class="container">
        <a href="/home">OPWAARTS</a>
        <nav>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="/home">Home</a></li>              	
            <li><a href="/projecten">Projecten</a></li>              	
            <li><a href="/contact">Neem contact op</a></li>            
            <li><a href="/about">Over ons</a></li>
            <li><a href="/hoewerkthet">Hoe werkt het</a></li>

	<?php
			if(isset($_SESSION['user']))
			{ 
?>				<li><a href="/account">Account</a></li>
				<li><a href="/login/uitloggen">Uitloggen</a></li>
				<?php
				if($_SESSION['user']['rechten_id'] == 1)
				{
					?><li><a href="/admin">Admin</a></li><?php
				}?>
				<li>ingelogt als:<?php echo "<br>voornaam:".$_SESSION['user']['voornaam']."<br>achternaam:".$_SESSION['user']['achternaam']."<br>Account:".$_SESSION['user']['naam']."<br>Balans:".$_SESSION['user']['balans']?></li>
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
    </header>	