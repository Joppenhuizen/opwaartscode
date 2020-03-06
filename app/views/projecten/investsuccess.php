<?php if(!isset($_SESSION['user'])){header("Location:/home");}?>
<div id="container" style="margin-left:20%;margin-right: 20%;text-align: center;">
<?php require_once '../app/views/templates/menu.php'; ?>
<br>
<div id="home.content">
<div class="page.header" style="font-size:30px;font-style:bolder;">Geinvesteerd</div>
U heeft : <?php echo  "€".$data['cur'].",-" ?> geinvesteerd in: <?php echo  $data['project'][0]['project_naam'] ?>

<table>

</table>
</div>
