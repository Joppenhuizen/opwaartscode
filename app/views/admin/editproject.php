
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
<div class="page.header" style="font-size:30px;font-style:bolder;">Project wijzigen</div>
<?php 
//if(isset($data['project'])){ echo };
if(isset($data['project']))
	{
		$project = $data['project']['project'][0];
		$images = $data['project']['images'];
		$docs = $data['project']['docs'];
		$logo = $data['project']['devlogo'][0];
		$protypes = $data['projecttypes'];
	}
?>
	<form action="/admin/editproject/<?php echo $project['project_id']?>" method="post" enctype="multipart/form-data">
		<table>
			<tr>
				<td>Project naam: </td>
				<td><input type=text name='pnaam' value="<?php echo $project['project_naam']; ?>"></td>
			</tr>
			<tr>
				<td>Project locatie: </td>
				<td><input type=text name='plocatie' value="<?php echo $project['project_locatie']; ?>"></td>
			</tr>
			<tr>
				<td>Project omschrijving: </td>
				<td><input type=textarea name='pomschrijving' value="<?php echo $project['project_omschrijving']; ?>"></td>
			</tr>
			<tr>
				<td>Doelbedrag: </td>
				<td><input type=text name='pdoelbedrag' value="<?php echo $project['doelbedrag']; ?>"></td>
			</tr>
			<tr>
				<td>Rendement: </td>
				<td><input type=text name='prendement' value="<?php echo $project['rendement']; ?>"></td>
			</tr>
			<tr>
				<td>Risico: </td>
				<td><input type=text name='prisico' value="<?php echo $project['risico_indicatie']; ?>"></td>
			</tr>
			<tr>
				<td>LTV: </td>
				<td><input type=text name='pltv' value="<?php echo $project['ltv']; ?>"></td>
			</tr>
			<tr>
				<td>Duurzaamheidslabel: </td>
				<td><input type=text name='plabel' value="<?php echo $project['duurzaamheidslabel']; ?>"></td>
			</tr>
			<tr>
				<td>Start/eind datum: </td>
				<td><input type=date name='pstart' value="<?php echo $project['start_datum']; ?>"> - <input type=date name='peind' value="<?php echo $project['eind_datum']; ?>"></td>
			</tr>
			<tr>
				<td>Inleg vanaf/tot: </td>
				<td><input type=text name='pvanaf' value="<?php echo $project['inleg_vanaf']; ?>"> - <input type=text name='ptot' value="<?php echo $project['inleg_tot']; ?>"></td>
			</tr>
			<tr>
				<td>Types: </td>
			</tr>
						<?php 
							foreach ($data['types'] as $type)
							{
								echo "<tr><td>".$type['type_naam']."</td><td><input type='checkbox' name='types[]' value='".$type['type_id']."'".(in_array($type['type_id'],$protypes) ? 'checked' : '')."></td></tr>";
							}
						?>
			<?php if(!isset($_SESSION['ont'])){ ?>
			<tr>
				<td>Ontwikkelaar: </td>
				<td>
					<select name="ontwikkelaar">
						<?php 
							foreach ($data['ontwikkelaars'] as $ontwikkelaar)
							{
								echo "<option value=".$ontwikkelaar['ontwikkelaar_id'].($ontwikkelaar['ontwikkelaar_id'] == $project['ontwikkelaar_id'] ? " selected=\"selected\">" : ">") . $ontwikkelaar['naam'] . "</option>";
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
								echo "<option value=".$status['status_id'].($status['status_id'] == $project['status_id'] ? " selected=\"selected\">" : ">") . $status['status'] . "</option>";
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
				<td>
					<?php foreach ($images as $image) { ?>
					<a href="/admin/removeimg/<?php echo $project['project_id'].'/'.$image['image_id'] ?>" style="position: absolute;">
					  <img src="/public/images/delete.png">
					</a>
					<image style="width:75px" src=<?php echo '/public'.$image['image_path'] ?> />
					<?php } ?>
				</td>
			</tr>
			<tr>
				<td>Thumbnail: </td>
				<td><input type="file" name="thumbnail" /></td>
			</tr>
			<tr>
			<td>
				<image style="width:75px" src=<?php echo '/public'.$project['image_path'] ?> />
			</td>
			</tr>
			<tr>
				<td>Documenten: </td>
				<td><input type="file" multiple="multiple" name="docs[]" /></td>
			</tr>
			<tr>
				<td>
					<?php foreach ($docs as $doc) { ?>
					<tr>
					<td>
					<?php echo str_replace("/docs/", "", $doc['file_path']); ?> 
					</td>
					<td>					
						<a href="/admin/removedoc/<?php echo $project['project_id'].'/'.$doc['doc_id'] ?>">
						  Verwijderen
						</a>
					</td>
					</tr>
					<?php } ?>

				</td>
			</tr>
			<tr>
				<td>Tonen: </td>
				<td><input type="checkbox" name='tonen' <?php if($project['tonen']==1) {echo "checked";}?> ></td>
			</tr>
			<tr>
				<td>Content: </td>
				<td style="width:100px;height:300px"><textarea rows="10" cols="50" name='content'> <?php echo $project['content'] ?></textarea></td>
			</tr>

			<tr>
				<td colspan="1" style="text-align: center"><input type="submit" value="Wijzigen"></td>
				<?php if(isset($data['msg']) && $data['msg'] != ''){ ?> <td>Project gewijzigt</td> <?php } ?>
		<!-- 	<?php if($data['viewparam'] == 'exists'){?> <td><a>Dit email adres is al in gebruik.</a></td> <?php }?>
				<?php if($data['viewparam'] == 'err'){?> <td><a>Vul aub alle velden in.</a></td> <?php }?> -->
			</tr>
		</table>
	</form>
</div>
