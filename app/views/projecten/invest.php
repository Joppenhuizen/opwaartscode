<?php if(!isset($_SESSION['user'])){header("Location:/home");}?>
<?php require_once '../app/views/templates/menu.php'; ?>
<div class="container">
<br>
<div id="home.content">
<div class="page.header" style="font-size:30px;font-style:bolder;">Investeren</div>
<div class="row">

	<img src="http://i.imgur.com/7Cof6M7.jpg" class="img-responsive" alt="Cinque Terre">

<div class="row">
<form action="/projecten/invest" method="post">
<input type="hidden" name="check" value="1"/>
<table>
	<tr>
		<td>Bedrag: </td>
		<td>					
			<select name="cur">
				<option value="60">60</option>";
				<option value="100">100</option>";
				<option value="175">175</option>";
				<option value="250">250</option>";
				<option value="500">500</option>";
				<option value="1000">1000</option>";
				<option value="5000">5000</option>";
			</select> 
		</td>
	</tr>
	<tr>
		<td colspan="1" style="text-align: center"><input type="submit" value="Investeren"></td>
	</tr>
</table>
<input type='hidden' name="id" value=<?php echo $data['id'] ?>></input>
</form>
</div>
</div>
