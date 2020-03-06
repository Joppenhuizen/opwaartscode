
<div id="container" style="margin-left:20%;margin-right: 20%;text-align: center;">
<?php require_once '../app/views/templates/menu.php'; ?>
<br>
<div id="home.content">
<div class="page.header" style="font-size:30px;font-style:bolder;">Account</div>
 <link href="https://cdnjs.cloudflare.com/ajax/libs/nvd3/1.8.3/nv.d3.min.css" rel="stylesheet">
    <script src="https://d3js.org/d3.v3.min.js" charset="utf-8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/nvd3/1.8.3/nv.d3.min.js"></script>



   
    


 

<div id="chart1">
  <svg></svg>
</div>

 
 <script>

 var data = [
  {
    key:"Forecast",
    values: [{x:0,y:10}]},
  {
    key:"Actual",
    values: [{x:0,y:15}]}
]

   nv.addGraph(function() {
    var chart = nv.models.multiBarChart()
      .reduceXTicks(true)   //If 'false', every single x-axis tick label will be rendered.
      .rotateLabels(0)      //Angle to rotate x-axis labels.
      .showControls(true)   //Allow user to switch between 'Grouped' and 'Stacked' mode.
      .groupSpacing(0.1)    //Distance between each group of bars.
    ;

    chart.xAxis
        .tickFormat(d3.format(',f'));

    chart.yAxis
        .tickFormat(d3.format(',.1f'));

    d3.select('#chart1 svg')
        .datum(data)
        .call(chart);

    nv.utils.windowResize(chart.update);

    return chart;
});
   
 </script>


<style>
.table table {
    border-collapse: collapse;

}

.table td ,tr,th{
    border: 1px solid black;
    text-align: center;
}
.table td{
	width:100px;
}
.table{
	width:100%;
	margin-top:20px;
	display: block;
}
</style>

<div class="container">
    <div class="row">
    	<div class="col-md-3">
    	    <a class="info-tiles tiles-inverse has-footer" href="#">
    		    <div class="tiles-heading">
			        <div class="tiles-title-left">Orders</div>
			        <div class="tiles-title-right">Test</div>
			    </div>
			    <div class="tiles-body">
			        <div class="text-center">1,275</div>
			    </div>
			    <div class="tiles-footer">
                    <div class="tiles-footer-left">manage</div>
    		        <div class="tiles-footer-right percent-change">-10%</div>
			    </div>
			</a>
    	</div>
        
        <div class="col-md-3">
        	<a class="info-tiles tiles-green has-footer" href="#">
			    <div class="tiles-heading">
    		        <div class="tiles-title-left">Revenues</div>
			        <div class="tiles-title-right">Test</div>
			    </div>
			    <div class="tiles-body">
			        <div class="text-center">$71,250</div>
			    </div>
			    <div class="tiles-footer">
                    <div class="tiles-footer-left">manage</div>
    		        <div class="tiles-footer-right percent-change">-10%</div>
			    </div>
			</a>
    	</div>    
        
        <div class="col-md-3">
        	<a class="info-tiles tiles-blue has-footer" href="#">
			    <div class="tiles-heading">
    		        <div class="tiles-title-left">Tickets</div>
			        <div class="tiles-title-right">Test</div>
			    </div>
			    <div class="tiles-body">
			        <div class="text-center">1,500</div>
			    </div>
			    <div class="tiles-footer">
                    <div class="tiles-footer-left">manage</div>
    		        <div class="tiles-footer-right percent-change">-10%</div>
			    </div>
			</a>
    	</div>
        
        <div class="col-md-3">
        	<a class="info-tiles tiles-midnightblue has-footer" href="#">
			    <div class="tiles-heading">
        	        <div class="tiles-title-left">Members</div>
			        <div class="tiles-title-right">Test</div>
			    </div>
			    <div class="tiles-body">
			        <div class="text-center">6,500</div>
			    </div>
			    <div class="tiles-footer">
                    <div class="tiles-footer-left">manage</div>
			        <div class="tiles-footer-right percent-change">-10%</div>
			    </div>
			</a>
    	</div>
	</div>
	
	    <div class="row">
    	<div class="col-md-6">
    		grafiek 1
    </div>		
    	<div class="col-md-6">
    		grafiek 2	
	</div>
</div>
</div>
</div>







<div class='table'>
<table id='intern'>
<tr><td colspan="2">Interne transacties</td></tr>
<tr><th>transactie nummer</th> <th>Project naam</th> <th>Datum</th> <th>Type</th> <th>Bedrag</th></tr>

	<?php foreach ($data['trans']['intern'] as $intern) { ?>
		<tr>
		<td> <?php echo $intern['transnummer'] ?></td>
		<td> <?php echo $intern['project_naam'] ?></td>
		<td> <?php echo $intern['datum'] ?></td>
		<td> <?php echo $intern['type_naam'] ?></td>
		<td> <?php echo '€'.$intern['mutatie'].',-' ?></td>
		</tr>
	<?php } ?>
</table>
</div>

<div class='table'>
<table id='extern'>
<tr><td colspan="2">Externe transacties</td></tr>
<tr><th>transactie nummer</th> <th>Datum</th> <th>Type</th> <th>Bedrag</th></tr>

	<?php foreach ($data['trans']['extern'] as $extern) { ?>
		<tr>
		<td> <?php echo $extern['transnummer'] ?></td>
		<td> <?php echo $extern['datum'] ?></td>
		<td> <?php echo $extern['type_naam'] ?></td>
		<td> <?php echo '€'.$extern['mutatie'].',-' ?></td>
		</tr>
	<?php } ?>
</table>
</div>
<a href="/account/addcur">Balans verhogen</a>
<a href="/account/withdrawal">Balans uitbetalen</a>
<a href="/account/edit">Account wijzigen</a>
<a href="/account/editwacht">Wachtwoord wijzigen</a>
</div>
</div>
<?php require_once '../app/views/templates/footer.php'; ?>