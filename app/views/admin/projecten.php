
<div id="container" style="margin-left:20%;margin-right: 20%;text-align: center;">
<?php require_once '../app/views/templates/menu.php'; ?>

<link rel="stylesheet" type="text/css" href="/public/css/list.css">

<br>
<div id="home.content">
<div class="page.header" style="font-size:30px;font-style:bolder;">Projecten</div>

<a href="/admin/addproject">Project toevoegen</a>
<br>
<div id="projecten">
  <input class="search" placeholder="Zoeken..." />
  <table>
        <thead >
        <th></th>
            <th class="sort" data-sort="naam">naam</th>
            <th class="sort" data-sort="omschrijving">omschrijving</th>
            <th class="sort" data-sort="locatie">locatie</th>
            <th class="sort" data-sort="start">start</th>
            <th class="sort" data-sort="eind">eind</th>
            <th class="sort" data-sort="ingelegt">ingelegt</th>
            <th class="sort" data-sort="doelbedrag">doelbedrag</th>
            <th class="sort" data-sort="vanaf">vanaf</th>
            <th class="sort" data-sort="tot">tot</th>
            <th class="sort" data-sort="rendement">rendement</th>
            <th class="sort" data-sort="tonen">tonen</th>
            <th class="sort" data-sort="status">status</th>
        </thead>
    <tbody class="list">
<?php foreach ($data['projecten'] as $project) { ?>

      <tr>
      	<td style="text-align: center"><a href="/admin/editproject/<?php echo $project['project_id'] ?>">Wijzigen</a></td>
        <td class="naam"><?php echo $project['project_naam'] ?></td>
        <td class="omschrijving"><?php echo $project['project_omschrijving'] ?></td>
        <td class="locatie"><?php echo $project['project_locatie'] ?></td>
        <td class="start"><?php echo $project['start_datum'] ?></td>
        <td class="eind"><?php echo $project['eind_datum'] ?></td>
        <td class="ingelegt"><?php echo $project['ingelegt'] ?></td>
        <td class="doelbedrag"><?php echo $project['doelbedrag'] ?></td>
        <td class="vanaf"><?php echo $project['inleg_vanaf'] ?></td>
        <td class="tot"><?php echo $project['inleg_tot'] ?></td>
        <td class="rendement"><?php echo $project['rendement'] ?></td>
        <td class="tonen"><?php echo $project['tonen'] ?></td>
        <td class="status"><?php echo $project['status'] ?></td>
      </tr>


<?php } ?>

    </tbody>
  </table>

</div>
<script src="/public/js/list.js"></script>
<script>
var options = {
  valueNames: ['naam','omschrijving' ,'locatie' ,'start' ,'eind' ,'ingelegt' ,'doelbedrag' ,'vanaf' ,'tot' ,'rendement' ,'tonen' ,'status']
};

var projectList = new List('projecten', options);
</script>




</div>