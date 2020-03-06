
<div id="container" style="margin-left:20%;margin-right: 20%;text-align: center;">
<?php require_once '../app/views/templates/menu.php'; ?>
<br>
<div id="home.content">
<div class="page.header" style="font-size:30px;font-style:bolder;">Admin</div>

<table style="text-align:center;width:60%;margin-right:20%;margin-left:20%;margin-top:50px;">

<tr>
<td><a href="/admin/projecten">Projecten</a><td>
<td><a href="/admin/investeerders">Investeerders</a><td>
<td><a href="/admin/email">Email versturen</a><td>
<td><a href="/admin/ontwikkelaars">Ontwikkelaars</a><td>
<?php if(isset($_SESSION['user']['rechten_id']) && $_SESSION['user']['rechten_id'] == 1) {?>
<td><a href="/admin/users">Gebruikers</a><td>
<td><a href="/admin/sepa">SEPA</a><td>
<?php } ?>
</tr>

</table>

</div>