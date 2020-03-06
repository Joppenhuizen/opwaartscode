
<?php 
if($_SESSION['user']['rechten_id'] != 1)
	{
		header("Location:/home");
	} 
?>
<div id="container" style="margin-left:20%;margin-right: 20%;text-align: center;">
<?php require_once '../app/views/templates/menu.php'; ?>
<br>
<div id="home.content">
<div class="page.header" style="font-size:30px;font-style:bolder;">Ontwikkelaar toevoegen</div>
	<form action="/admin/adddev" method="post" enctype="multipart/form-data">
		<table>
			<tr>
				<td>Ontwikkelaar naam: </td>
				<td><input type=text name='devnaam'></td>
			</tr>
			<tr>
				<td>E-mail: </td>
				<td><input type=text name='email'></td>
			</tr>
			<tr>
				<td>Wachtwoord: </td>
				<td><input type=password name='wachtwoord'></td>
			</tr>
			<tr>
				<td>Plaats: </td>
				<td><input type=text name='devlocatie'></td>
			</tr>
			<tr>
				<td>KvK: </td>
				<td><input type=textarea name='devkvk'></td>
			</tr>
			<tr>
				<td>Omschrijving: </td>
				<td><input type=text name='devomschrijving'></td>
			</tr>
			<tr>
				<td>Logo: </td>
				<td><input type="file" name="logo" /></td>
			</tr>
			<tr>
				<td colspan="1" style="text-align: center"><input type="submit" value="toevoegen"></td>
				<?php if(isset($data['msg']) && $data['msg'] != ''){ ?> <td><?php echo $data['msg']; ?></td> <?php } ?>
		<!-- 	<?php if($data['viewparam'] == 'exists'){?> <td><a>Dit email adres is al in gebruik.</a></td> <?php }?>
				<?php if($data['viewparam'] == 'err'){?> <td><a>Vul aub alle velden in.</a></td> <?php }?> -->
			</tr>
		</table>
	</form>
</div>
