
<div id="container">
<?php require_once '../app/views/templates/menu.php'; ?>

<br>
<div id="home.content" style="margin-left:20%;margin-right: 20%;text-align: center;">
<div class="page.header" style="font-size:30px;font-style:bolder;">Documenten</div>

<?php
	if(isset($data['docs']))
	{
		$docs = $data['docs'];
		$id = $data['id'];
	}
?>
	<style>
	#comments {
	    border-collapse: collapse;
	}

	#comments td {
		width:150px;
	    border: 1px solid black;
	}
	#com {
		left:50%;
	}
	</style>
	<table style="margin-left:-20%;float:left">
		<tr>
			<td>
			<a href="/projecten/show/<?php echo $id ?>">Project</a>
			</td>
		</tr>
		<tr>
			<td>
			<a href="/projecten/comments/<?php echo $id ?>">Reacties</a>
			</td>
		</tr>
		<tr>
			<td>
			<a href="/projecten/documenten/<?php echo $id ?>">Documenten</a>
			</td>
		</tr>
	</table>
	<div id="docs">
		<table>
        <thead >
            <th>Bestandsnaam</th>
            <th style="text-align: center">Type</th>
        </thead>
			
			<?php foreach ($docs as $doc) { ?>
			<tr>
				<td><?php echo str_replace("/docs/", "", $doc['file_path']); ?></td>
				<td style="width:100px;text-align: center"><?php echo $doc['ext'] ?></td>
				<td><a href="/projecten/downloaddoc/<?php echo $doc['doc_id'].'/'.$id ?>">Downloaden</a></td>
			</tr>
			<?php } ?>
			
		</table>
	</div>
</div>