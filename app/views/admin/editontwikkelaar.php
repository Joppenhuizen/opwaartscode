
<?php 
if($_SESSION['user']['rechten_id'] == 2 && !isset($_SESSION['user']['rechten_id']))
	{
		header("Location:/home");
	} 

	$ontwikkelaar = $data['ontwikkelaars'][0];

?>
<div id="container" style="margin-left:20%;margin-right: 20%;text-align: center;">
<?php require_once '../app/views/templates/menu.php'; ?>
<br>
<div id="home.content">
<div class="page.header" style="font-size:30px;font-style:bolder;">Ontwikkelaar wijzigen</div>
	<form action="/admin/editontwikkelaar/<?php echo $ontwikkelaar['ontwikkelaar_id']?>" method="post" enctype="multipart/form-data">
		<table>
			<tr>
				<td>Ontwikkelaar naam: </td>
				<td><input type=text name='devnaam' value="<?php echo  $ontwikkelaar['naam']?>"></td>
			</tr>
			<tr>
				<td>E-mail: </td>
				<td><input type=text name='email' value="<?php echo  $ontwikkelaar['email']?>"></td>
			</tr>
			<tr>
				<td>Plaats: </td>
				<td><input type=text name='devlocatie' value="<?php echo  $ontwikkelaar['plaats']?>"></td>
			</tr>
			<tr>
				<td>KvK: </td>
				<td><input type=textarea name='devkvk' value="<?php echo  $ontwikkelaar['kvk']?>"></td>
			</tr>
			<tr>
				<td>Omschrijving: </td>
				<td><input type=text name='devomschrijving' value="<?php echo  $ontwikkelaar['omschrijving']?>"></td>
			</tr>
			<tr>
				<td>Logo: </td>
				<td><input type="file" name="logo" /></td>
			</tr>
			<tr><td><img style="width:100px" src="/public<?php echo $ontwikkelaar['image_path'] ?>"/></td></tr>
			<tr>
				<td colspan="1" style="text-align: center"><input type="submit" value="wijzigen"></td>
				<?php if(isset($data['msg']) && $data['msg'] != ''){ ?> <td>Gewijzigt</td> <?php } ?>
		<!-- 	<?php if($data['viewparam'] == 'exists'){?> <td><a>Dit email adres is al in gebruik.</a></td> <?php }?>
				<?php if($data['viewparam'] == 'err'){?> <td><a>Vul aub alle velden in.</a></td> <?php }?> -->
			</tr>
		</table>
	</form>
</div>
