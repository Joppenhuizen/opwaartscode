
<?php if(!isset($_SESSION['user'])){header("Location:/home");}?>
<div id="container" style="margin-left:20%;margin-right: 20%;text-align: center;">
<?php require_once '../app/views/templates/menu.php'; ?>
<br>
<div id="home.content">
<div class="page.header" style="font-size:30px;font-style:bolder;">Belans verhogen</div>

<form action="/account/addcur" method="post">
<input type="hidden" name="check" value="1"/>
<table>
	<tr><td><?php if(isset($data['msg'])){echo $data['msg'];} ?></td></tr>
	<tr>
		<td>Bedrag: </td>
		<td>					
			<select name="cur">
				<option value="20">20</option>";
				<option value="50">50</option>";
				<option value="100">100</option>";
				<option value="200">200</option>";
			</select> 
		</td>
	</tr>
	<tr>
		<td colspan="1" style="text-align: center"><input type="submit" value="Betalen"></td>
	</tr>
</table>
</form>
</div>
