
<?php if(isset($_SESSION['user'])){header("Location:/home");}?>
<div class="container">
<?php require_once '../app/views/templates/menu1.php'; ?>
<br>
<div id="home.content">

		<?php if(strlen($data['msg']) > 0)
		{
			?>
			<div class="alert alert-danger" role="alert"><?php echo $data['msg']; ?></div>
			<?php
		} ?>

</div>
</div>






    <div class="container">    
        <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
            <div class="panel panel-info" >
                    <div class="panel-heading">
                        <div class="panel-title">Inloggen</div>
                        <div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="#">Wachtwoord vergeten?</a></div>
                    </div>     

                    <div style="padding-top:30px" class="panel-body" >

                        <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                            
                        <form id="loginform" class="form-horizontal" role="form" action="/login" method="post">
                                    
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input id="login-username" type="text" class="form-control" name="username" value="" placeholder="E-mail">                                        
                                    </div>
                                
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        <input id="login-password" type="password" class="form-control" name="wachtwoord" placeholder="Wachtwoord">
                                    </div>
                                    

                                
                         

                                <div style="margin-top:10px" class="form-group">
                                    <!-- Button -->

                                    <div class="col-sm-12 controls">
                                      <input id="btn-login" type="submit" value="Inloggen" class="btn btn-success">
                                      <a id="btn-fblogin" href="/registreren" class="btn btn-primary">Registreren</a>

                                    </div>
                                </div>


                              
                            </form>     



                        </div>                     
                    </div>  
        </div>

    </div>
    <?php require_once '../app/views/templates/footer.php'; ?>