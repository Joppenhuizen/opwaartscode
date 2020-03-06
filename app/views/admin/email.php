
<?php 
if($_SESSION['user']['rechten_id'] == 2 || !isset($_SESSION['user']['rechten_id']))
	{
		header("Location:/home");
	} 
?>
<div id="container" style="margin-left:20%;margin-right: 20%;text-align: center;">
<?php require_once '../app/views/templates/menu.php'; ?>
<script type="text/javascript">
$(document).ready(function() {
    setOptions(); // on load
    $('#ont').change(setOptions); // on change

    function setOptions() {       
        switch ($("#ont").val()) {
            case "3" :
                $("#project").show();
                break;
            case "1":
                $("#project").hide();
                break;
            case "2":
                $("#project").hide();
                break;
            case "4":
                $("#project").hide();
                break;
            case "":
                $("#project").hide();
                break;
            }
    }; 
})
</script>
<br>
<style>
td {
	padding-top:10px;
}
</style>
<div id="home.content">
<div class="page.header" style="font-size:30px;font-style:bolder;">Email</div>
	<form action="/admin/sendemail" method="post" enctype="multipart/form-data">
		<table>
			<tr>
				<td>Ontvanger:</td>
				<td>					
					<select id="ont" name="ontvanger">
						<?php if ($_SESSION['user']['rechten_id'] == 1) {?>
						<option value="1">Nieuwsbrief</option>
						<option value="2">Alle investeerders</option>
						<?php } ?>
						<option value="3">Speciefiek investeerders</option>
						<?php if ($_SESSION['user']['rechten_id'] == 1) {?>
						<option value="4">Ontwikkelaars</option>
						<option value="5">Iedereen</option>
						<?php } ?>
					</select>
				</td>

				<td>
					<div id="project"> 	
					Project: 				
					<select id="pro" name="project">
					<?php 
					
						foreach ($data['projecten'] as $project)
						{
							echo "<option value=".$project['project_id'].">" . $project['project_naam'] . "</option>";
						}
					?>
					</select>
					</div>
				</td>
			</tr>
			<tr>
				<td>Onderwerp: </td>
				<td><input type=text name='onderwerp'></td>
			</tr>
			<tr>
				<td>Inhoud: </td>
				<td><textarea  cols="45" rows="10" name='inhoud'></textarea></td>
			</tr>

			<tr>
				<td  colspan="2" style="padding-top:10px;text-align: center"><input type="submit" value="versturen"></td>
				<?php if(isset($data['msg']) && $data['msg'] != ''){ ?> <td>Project toegevoegt</td> <?php } ?>
		<!-- 	<?php if($data['viewparam'] == 'exists'){?> <td><a>Dit email adres is al in gebruik.</a></td> <?php }?>
				<?php if($data['viewparam'] == 'err'){?> <td><a>Vul aub alle velden in.</a></td> <?php }?> -->
			</tr>
		</table>
	</form>
</div>
