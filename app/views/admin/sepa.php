
<div id="container" style="margin-left:20%;margin-right: 20%;text-align: center;">
<?php require_once '../app/views/templates/menu.php'; ?>
<link rel="stylesheet" type="text/css" href="/public/css/list.css">
<br>
<div id="home.content">
<div class="page.header" style="font-size:30px;font-style:bolder;">SEPA</div>

<?php echo 'Er staan '.$data['pending'][0]['count'].' transacties klaar.'; ?>
<br><a href="/admin/generatesepa">SEPA genereren</a>
<div id="payments">
  <input class="search" placeholder="Zoeken..." />
  <table>
        <thead >
            <th class="sort" data-sort="gegenereerd">Gegenereerd op</th>
            <th class="sort" data-sort="tranacties"># tranacties</th>
            <th class="sort" data-sort="gedownload">Gedownload</th>
        </thead>
    <tbody class="list">
<?php foreach ($data['payment'] as $payment) { ?>

      <tr>
        <td class="gegenereerd"><?php echo $payment['datum'] ?></td>
        <td class="tranacties"><?php echo $payment['transacties'] ?></td>
        <td class="gedownload"><?php if($payment['gedownload']){echo 'Ja';} else{echo 'Nee';} ?></td>
        <td><a href="/admin/downloadsepa/<?php echo $payment['sepa_id'] ?>">Downloaden</a></td>
      </tr>


<?php } ?>

    </tbody>
  </table>

</div>
<script src="/public/js/list.js"></script>
<script>
var options = {
  valueNames: ['gegenereerd','tranacties' ,'gedownload']
};

var paymentList = new List('payments', options);
</script>
</div>
</div>
<?php require_once '../app/views/templates/footer.php'; ?>