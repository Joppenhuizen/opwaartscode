
<?php if(!isset($_SESSION['user'])){header("Location:/home");}?>
<div id="container" style="margin-left:20%;margin-right: 20%;text-align: center;">
<?php require_once '../app/views/templates/menu.php'; ?>
<br>
<div id="home.content">
<div class="page.header" style="font-size:30px;font-style:bolder;">Account wijzigen</div>

<form action="/account/editwacht" method="post">
<input type="hidden" name="check" value="1"/>
<table>
	<tr>
		<td>Oude wachtwoord: </td>
		<td><input type=text name='oldpass'></td>
	</tr>
	<tr>
		<td>Nieuwe wachtwoord: </td>
		<td><input type=text name='newpass'></td>
	</tr>
	<tr>
		<td>Herhaal wachtwoord: </td>
		<td><input type=text name='repass'></td>
	</tr>
	<tr>
		<td colspan="2" style="text-align: center"><input type="submit" value="Wijzigen"></td>
		<?php if($data['viewparam']==1){ echo "<td>Opgeslagen</td>";} ?>
		<?php if($data['viewparam']==3){ echo "<td>Wachtwoorden zijn niet gelijk</td>";} ?>
	</tr>
</table>
</form>
</div>
</div>
<?php require_once '../app/views/templates/footer.php'; ?>