<?php require_once '../app/views/templates/menu.php'; ?>
<div class="container-fluid" >
<div style="background-image: url(http://i.imgur.com/hbkLxJZ.jpg); width: 100%; height:60%; background-repeat: no-repeat; background-size: cover; display: flex; justify-content: center; align-items: center; color:white; border-bottom: 5px solid #a3cad9;" class="container-fluid  hidden-xs">
     <h1>Projecten</h1>
</div>
</div>

<div class="container">
 <div class="row"></div>
<br>
<div id="home.content">
<div class="page.header" style="font-size:30px;font-style:bolder;">Projecten</div>



<table id="projecten">
<?php foreach ($data['projecten'] as $project) { ?>
<td>
 <table class="project">
  <tr>

 	<td colspan="2" style="text-align: center"><image style="width:200px" class="thumbnail" src= <?php echo '/public'.$project['image_path']; ?> /></td>
 </tr>
 <tr>
 	<td>Naam:</td>
 	<td><?php echo $project['project_naam']; ?></td>
 </tr>
  <tr>
 	<td>Locatie:</td>
 	<td><?php echo $project['project_locatie']; ?></td>
 </tr>
  <tr>
 	<td>Rendement:</td>
 	<td><?php echo $project['rendement']; ?></td>
 </tr>
  <tr>
 	<td>Doel:</td>
 	<td><progress value="<?php echo $project['ingelegt'] ?>" max="<?php echo $project['doelbedrag']; ?>"><span id="goal"><?php echo $project['ingelegt']."/".$project['doelbedrag']; ?></span></progress>
 		 </td>
 </tr>
 <tr>
 <td colspan="2" style="text-align: center"><br><button name="p" onclick="location.href='/projecten/show/<?php echo $project['project_id'] ?>'" type="submit" value="" >Bekijk</button></td>
 </tr>
 </table>
</td>
<?php } ?>
</table>




</div></div>
</div>
<?php require_once '../app/views/templates/footer.php'; ?>