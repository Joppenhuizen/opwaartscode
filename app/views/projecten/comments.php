<?php require_once '../app/views/templates/menu.php'; ?>
<div class="container">
<br>
<div id="home.content" style="margin-left:20%;margin-right: 20%;text-align: center;">
<div class="page.header" style="font-size:30px;font-style:bolder;">Reacties</div>

<?php
	if(isset($data['comment']))
	{
		$comments = $data['comment'];
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
			<a href="/projecten/docs/<?php echo $id ?>">Documenten</a>
			</td>
		</tr>
	</table>
	<div id="com">
		<table id='comments' style="text-align: center;">
			<tr>
			<?php foreach ($comments as $comment) { ?>
				<td><img style="border-radius: 50%;width:50px;" src="/public<?php echo $comment['image_path'] ?>"/></td>
				<td><?php echo $comment['voornaam'] ?></td>
				<tr>
				<td colspan="2"><?php echo $comment['comment'] ?></td>
				</tr>
			<?php } ?>
			</tr>
		</table>
	</div>
</div>