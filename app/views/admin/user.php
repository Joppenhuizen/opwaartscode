
<div id="container" style="margin-left:20%;margin-right: 20%;text-align: center;">
<?php require_once '../app/views/templates/menu.php'; ?>

<link rel="stylesheet" type="text/css" href="/public/css/list.css">

<br>
<div id="home.content">
<div class="page.header" style="font-size:30px;font-style:bolder;">Gebruikers</div>
<br>
<div id="projecten">
  <input class="search" placeholder="Zoeken..." />
  <table>
        <thead >
            <th class="sort" data-sort="email">email</th>
            <th class="sort" data-sort="voornaam">voornaam</th>
            <th class="sort" data-sort="achternaam">achternaam</th>
            <th class="sort" data-sort="balans">balans</th>
            <th class="sort" data-sort="nieuwsbrief">nieuwsbrief</th>
        </thead>
    <tbody class="list">
<?php foreach ($data['users'] as $user) { ?>

      <tr>
        <td class="email"><?php echo $user['email'] ?></td>
        <td class="voornaam"><?php echo $user['voornaam'] ?></td>
        <td class="achternaam"><?php echo $user['achternaam'] ?></td>
        <td class="balans"><?php echo $user['balans'] ?></td>
        <td class="nieuwsbrief"><?php echo $user['nieuwsbrief'] ?></td>
      </tr>


<?php } ?>

    </tbody>
  </table>

</div>
<script src="/public/js/list.js"></script>
<script>
var options = {
  valueNames: ['email' ,'voornaam' ,'achternaam' ,'balans' ,'nieuwsbrief']
};

var projectList = new List('projecten', options);
</script>




</div>