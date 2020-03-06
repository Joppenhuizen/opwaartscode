
<div id="container" style="margin-left:20%;margin-right: 20%;text-align: center;">
<?php require_once '../app/views/templates/menu.php'; ?>
<br>
<div id="home.content">
<div class="page.header" style="font-size:30px;font-style:bolder;">Admin</div>
<style>
table {
	margin-top:30px;
}
td {
	padding-top:10px;
	width:150px;
}
</style>
<?php 

		//print_r($data['inv'][1][0]);
		//$array[0]['inves'][0]['naam']

		
		for($j=0;$j < count($data['inv']); $j++)
		{
			
			echo '<table>';
			echo '<th>'.$data['inv'][$j]['project_naam'].'</th>';
			echo '<tr><th>Voornaam</th><th>Achternaam</th><th>Mutatie</th></tr>';

			for($i=0;$i < count($data['inv'][$j])-1; $i++)
			{
				echo '<tr>';
				echo '<td>'.$data['inv'][$j][$i]['voornaam'].'</td>';
				echo '<td>'.$data['inv'][$j][$i]['achternaam'].'</td>';
				echo '<td>€'.$data['inv'][$j][$i]['mutatie'].',-</td>';
				echo '</tr>';
			}

			echo '</table>';
		}
?>

</div>