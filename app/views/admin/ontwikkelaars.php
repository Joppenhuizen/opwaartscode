
<div id="container" style="margin-left:20%;margin-right: 20%;text-align: center;">
<?php require_once '../app/views/templates/menu.php'; ?>

<link rel="stylesheet" type="text/css" href="/public/css/list.css">

<br>
<div id="home.content">
<div class="page.header" style="font-size:30px;font-style:bolder;">Ontwikkelaars</div>

<?php if($_SESSION['user']['rechten_id'] == 1){ ?><a href="/admin/adddev">Ontwikkelaar toevoegen</a> <?php } ?>
<br>
<div id="projecten">
  <input class="search" placeholder="Zoeken..." />
  <table>
        <thead >
        <th></th>
            <th>logo</th>
            <th class="sort" data-sort="naam">naam</th>
            <th class="sort" data-sort="locatie">locatie</th>
            <th class="sort" data-sort="kvk">kvk</th>
            <th class="sort" data-sort="email">email</th>
            <th class="sort" data-sort="omschrijving">omschrijving</th>
        </thead>
    <tbody class="list">
<?php foreach ($data['ont'] as $ontwikkelaar) { ?>

      <tr>
      	<td style="text-align: center"><a href="/admin/editontwikkelaar/<?php echo $ontwikkelaar['ontwikkelaar_id'] ?>">Wijzigen</a></td>
        <td class="logo"><img style="width:100px;" src="/public<?php echo $ontwikkelaar['image_path'] ?>"/></td>
        <td class="naam"><?php echo $ontwikkelaar['naam'] ?></td>
        <td class="locatie"><?php echo $ontwikkelaar['plaats'] ?></td>
        <td class="kvk"><?php echo $ontwikkelaar['kvk'] ?></td>
        <td class="email"><?php echo $ontwikkelaar['email'] ?></td>
        <td class="omschrijving"><?php echo $ontwikkelaar['omschrijving'] ?></td>
      </tr>


<?php } ?>

    </tbody>
  </table>

</div>
<script src="/public/js/list.js"></script>
<script>
var options = {
  valueNames: ['naam','omschrijving' ,'locatie' ,'kvk', 'email']
};

var projectList = new List('projecten', options);
</script>




</div>