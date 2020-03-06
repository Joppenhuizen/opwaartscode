<?php if(!isset($_SESSION['user'])){header("Location:/home");}?>
<div id="container" style="margin-left:20%;margin-right: 20%;text-align: center;">
<?php require_once '../app/views/templates/menu.php'; ?>
<br>
<div id="home.content">
<div class="page.header" style="font-size:30px;font-style:bolder;">Uibetaald</div>

Het opgenomen bedrag zal zo speodig mogelijk op uw bankrekening worden bijgeschreven, uw nieuwe balans is: <?php echo  $data['user']['balans'] ?>

<table>

</table>
</div>
