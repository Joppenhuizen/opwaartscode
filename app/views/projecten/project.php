

<div id="container">
	

	
<?php require_once '../app/views/templates/menu.php'; ?>
<?php

	if(isset($data['project'])){
		$project = $data['project']['project'][0];
		$images = $data['project']['images'];
		$logo = $data['project']['devlogo'][0];
		$types = $data['project']['types'];
	}
?>

	<div class="row">
			<div class="col-sm-12 col-md-12 padding-0 ">
	<div style="background-image:url(http://astoconsult.com/themes/front/images/pagehead.jpg); height:100px; "><div class="text-lefth" ><?php echo $project['project_naam'] ?></div></div>
	<br>
	</div>
	</div>

<div id="home.content" style="margin-left:20%;margin-right: 20%;text-align: center;">



   <div class="row">
   	    	<div class="col-sm-9 col-md-9">
<div id="myCarousel" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
  		<?php 
  		$counter = 1;
  		foreach ($images as $image) { ?>
  		  <li data-target="#myCarousel" data-slide-to="0" class=<?php if ($counter == 1) echo ' active'; ?>></li>
	<?php $counter++; } ?>

  </ol>


  <!-- Wrapper for slides -->
  
  <div class="carousel-inner" role="listbox">

  		<?php 
  		$counter = 1;
  		foreach ($images as $image) { ?>
  		<div class="item<?php if ($counter == 1) echo ' active'; ?>">
		<image style="width:100%; height: 350px; " src=<?php echo '/public'.$image['image_path'] ?> /></div>
	<?php $counter++; } ?>
	
  </div>

  <!-- Left and right controls -->
  <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
</div>
		<div class="col-sm-3 col-md-3">
            <div class="well">
        		<h2 class="text-muted">Project Info</h2>
        		<p><?php foreach ($types as $type) { ?><span class="label label-default"><?php echo $type['type_naam'];?></span> <?php } ?></p>
        			<tr>
	 	<td><?php echo $project['project_naam']; ?></td>
	</tr>
	<br>
	<tr>
	 	<td><?php echo $project['project_locatie']; ?></td>
	</tr>
	<br>
	<tr>
	 	<td><?php echo $project['project_omschrijving']; ?></td>
	</tr>
	<br>
	<tr>
		<td>Rendement:</td>
	 	<td><?php echo $project['rendement']; ?></td>
	</tr>
	<br>
		<tr>
		<td>Status:</td>
	 	<td><?php echo $project['status']; ?></td>
	</tr>
	<br>
	<tr>
	 	<td>
	 		
	 		<div class="progress">
  			<div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $project['ingelegt'] ?>" aria-valuemin="0" aria-valuemax="<?php echo $project['doelbedrag']; ?>" style="min-width: 2em; width: 2%;">
   			 <?php 
   			 $a = $project['ingelegt'];
   			 $b = $project['doelbedrag'];
   			 $c = $a / $b;
   			 echo round($c)."%"
   			 
   			 ?>
  			</div>
			</div>

	 		</td>
	</tr>
	<tr>
	<td>
		<?php if($project['status_id'] == 2){ ?><p><a class="btn btn-default btn-lg" href="/projecten/invest/<?php echo $project['project_id'] ?>'" type="submit" value="" <i class="icon-ok"></i> Investeren</a></p> <?php } ?>
	</td>
	</tr>

        	</div>
        </div>
        </div>


   <div class="row">
   	<br>
	</div>
	
    <div class="row">
    	<div class="col-sm-9 col-md-9">
    		<div class="well">
  				<h1><?php echo $project['project_naam'] ?></h1>
  				<p>	<?php echo $project['content']; ?></p>
				</div>
    		</div>

		<div class="col-sm-3 col-md-3">
            <div class="well">
	<tr>
        		<h2 class="text-muted">Ontwikelaar Info</h2>
	</tr>

	<tr>
		<td>Naam:</td>
	 	<td><?php echo $project['naam']; ?></td>
	</tr>
	<br>
	<tr>
		<td>Locatie:</td>
	 	<td><?php echo $project['plaats']; ?></td>
	</tr>
	<br>
	<tr>
		<td>Korte omschrijving:</td>
	 	<td><?php echo $project['omschrijving']; ?></td>
	</tr>
	<br>
	<tr>
		<td>KvK:</td>
	 	<td><?php echo $project['kvk']; ?></td>
	</tr>
	<br>
	<tr>
	<td colspan="2" style="text-align: center;"><image style="width:100px" src=<?php echo '/public'.$logo['image_path'] ?> /></td>
	</tr>
        </div>
	</div>










 <div class="row">
 	    <div class="col-sm-9 col-md-9">
  				<p>	<?php echo $project['content']; ?></p>
      <p>
  
      </p>
      
    </div>
    <div class="col-sm-3 col-md-3">
      <h2>Google Maps</h2>
      
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2646.2531389455903!2d-89.23024619999998!3d48.4516724!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4d5923dbfe697737%3A0xc9d925c9bc9573fa!2s116+Bruce+St%2C+Thunder+Bay%2C+ON+P7A+5W6!5e0!3m2!1sen!2sca!4v1424272264157" width="250" height="200" frameborder="0" style="border:0"></iframe>
      
    </div>

  </div>











<table style="margin-left:-20%;float:left">
	<tr>
		<td>
		<a href="/projecten/show/<?php echo $project['project_id'] ?>">Project</a>
		</td>
	</tr>
	<tr>
		<td>
		<a href="/projecten/comments/<?php echo $project['project_id'] ?>">Reacties</a>
		</td>
	</tr>
	<tr>
		<td>
		<a href="/projecten/docs/<?php echo $project['project_id'] ?>">Documenten</a>
		</td>
	</tr>
</table>



<div class="row">
    	<div class="col-sm-9 col-md-9">
    		<div class="well">
  			
			
<?php
	if(isset($data['comments']))
	{
		$comments = $data['comments'];
	}
?>


	<div id="com">
		<table id='comments' style="text-align: center;">
			<tr>
				<h1>Reacties op dit project</h1>
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
    		</div>


</div>