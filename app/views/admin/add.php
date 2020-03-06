
<?php 
if(!isset($_SESSION['user']) || $_SESSION['user']['rechten_id'] == 2)
	{
		header("Location:/home");
	} 
?>
<div id="container" style="margin-left:20%;margin-right: 20%;text-align: center;">
<?php require_once '../app/views/templates/menu.php'; ?>
<br>
<div id="home.content">
<div class="page.header" style="font-size:30px;font-style:bolder;">Project toevoegen</div>
<?php 
//if(isset($data['project'])){ echo };
?>
	<form action="/admin/addproject" method="post" enctype="multipart/form-data">
		<table>
			<tr>
				<td>Project naam: </td>
				<td><input type=text name='pnaam'></td>
			</tr>
			<tr>
				<td>Project locatie: </td>
				<td><input type=text name='plocatie'></td>
			</tr>
			<tr>
				<td>Project omschrijving: </td>
				<td><input type=textarea name='pomschrijving'></td>
			</tr>
			<tr>
				<td>Doelbedrag: </td>
				<td><input type=text name='pdoelbedrag'></td>
			</tr>
			<tr>
				<td>Rendement: </td>
				<td><input type=text name='prendement'></td>
			</tr>
			<tr>
				<td>Risico: </td>
				<td><input type=text name='prisico'></td>
			</tr>
			<tr>
				<td>LTV: </td>
				<td><input type=text name='pltv'></td>
			</tr>
			<tr>
				<td>Duurzaamheidslabel: </td>
				<td><input type=text name='plabel'></td>
			</tr>
			<tr>
				<td>Start/eind datum: </td>
				<td><input type=date name='pstart' > - <input type=date name='peind' ></td>
			</tr>
			<tr>
				<td>Inleg vanaf/tot: </td>
				<td><input type=text name='pvanaf' > - <input type=text name='ptot' ></td>
			</tr>
			<tr>
			<tr>
				<td>Types: </td>
			</tr>
						<?php 
							foreach ($data['types'] as $type)
							{
								echo "<tr><td>".$type['type_naam']."</td><td><input type='checkbox' name='types[]' value='".$type['type_id']."'"."></td></tr>";
							}
						?>
			</tr>
			<?php if(!isset($_SESSION['ont'])){ ?>
			<tr>
				<td>Ontwikkelaar: </td>
				<td>
					<select name="ontwikkelaar">
						<?php 
							foreach ($data['ontwikkelaars'] as $ontwikkelaar)
							{
								echo "<option value=".$ontwikkelaar['ontwikkelaar_id'].">" . $ontwikkelaar['naam'] . "</option>";
							}
						?>
					</select>
				</td>
			</tr>
			<?php } ?>
			
			<tr>
				<td>Status: </td>
				<td>
					<select name="status">
						<?php 
							foreach ($data['status'] as $status)
							{
								echo "<option value=".$status['status'].">" . $status['status'] . "</option>";
							}
						?>
					</select>
				</td>
			</tr>

			<tr>
				<td>Afbeeldingen: </td>
				<td><input type="file" multiple="multiple" name="images[]" /></td>
			</tr>
			<tr>
				<td>Thumbnail: </td>
				<td><input type="file" name="thumbnail" /></td>
			</tr>
			<tr>
				<td>Documenten: </td>
				<td><input type="file" multiple="multiple" name="docs[]" /></td>
			</tr>
			<tr>
				<td>Tonen: </td>
				<td><input type="checkbox" name='tonen'></td>
			</tr>
			<tr>
				<td>Content: </td>
				<td style="width:100px;height:300px"><textarea rows="10" cols="50" name='content'></textarea></td>
			</tr>
			<tr>
				<td colspan="1" style="text-align: center"><input type="submit" value="toevoegen"></td>
				<?php if(isset($data['msg']) && $data['msg'] != ''){ ?> <td>Project toegevoegt</td> <?php } ?>
		<!-- 	<?php if($data['viewparam'] == 'exists'){?> <td><a>Dit email adres is al in gebruik.</a></td> <?php }?>
				<?php if($data['viewparam'] == 'err'){?> <td><a>Vul aub alle velden in.</a></td> <?php }?> -->
			</tr>
		</table>
	</form>
</div>
