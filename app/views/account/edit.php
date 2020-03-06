
<?php if(!isset($_SESSION['user'])){header("Location:/home");}?>
<div id="container" style="margin-left:20%;margin-right: 20%;text-align: center;">
<?php require_once '../app/views/templates/menu.php'; ?>
<br>
<div id="home.content">
<div class="page.header" style="font-size:30px;font-style:bolder;">Account wijzigen</div>
<form action="/account/edit" method="post" enctype="multipart/form-data">
<input type="hidden" name="check" value="1"/>
<table>
	<tr>
		<td>E-mail: </td>
		<td><input type=text name='username' value="<?php echo $_SESSION['user']['email'] ?> "></td>
	</tr>
	<tr>
		<td>Voornaam: </td>
		<td><input type=text name='voornaam' value="<?php echo $_SESSION['user']['voornaam'] ?>"></td>
	</tr>
	<tr>
		<td>Achternaam: </td>
		<td><input type=text name='achternaam' value="<?php echo $_SESSION['user']['achternaam'] ?>"></td>
	</tr>
	<tr>
		<td>IBAN: </td>
		<td><input type=text name='iban' <?php if(isset($_SESSION['user']['bankrekening']) && $_SESSION['user']['bankrekening'] != ''){ echo "value='".$_SESSION['user']['bankrekening']."'"; } ?> ></td>
		<?php if($data['viewparam'] == 'iban'){?> <td>Er is nog geen IBAN bij ons gekend</td> <?php }?>
		<?php if($data['viewparam'] == 3){?> <td>Ongeldig iban nummer</td> <?php }?>
	</tr>
	<tr>
		<td>Afbeelding: </td>
		<td><input type="file" name="userpic" /></td>
	</tr>
	<tr>
		<td><img style="border-radius: 50%;" src="/public<?php echo $_SESSION['user']['image_path'] ?>"/></td>
	</tr>
	<tr>
		<td>Nieuwsbrief: </td>
		<td><input type=checkbox name='nieuwsbrief' <?php if($_SESSION['user']['nieuwsbrief']) {echo "checked";}?> ></td>
	</tr>
	<tr>
		<td colspan="2" style="text-align: center"><input type="submit" value="Wijzigen"></td>
		<?php if($data['viewparam']==1){ echo "<td>Opgeslagen</td>";} ?>
	</tr>
</table>
</form>
</div>
</div>
<?php require_once '../app/views/templates/footer.php'; ?>