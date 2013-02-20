<div id="chart1"></div>
<script>
$(document).ready(function(){
  var data = [
    <?php foreach($ventes as $i => $vente) : ?>
	['<?php echo html($vente['nom']);?>', <?php echo $vente['ventes'];?>]<?php echo ($i < count($ventes) -1) ? "," : "";?> 
    <?php endforeach; ?>
  ];
  var plot1 = jQuery.jqplot ('chart1', [data], 
    { 
      seriesDefaults: {
        renderer: jQuery.jqplot.PieRenderer, 
        rendererOptions: {
          showDataLabels: true
        }
      }, 
      legend: { show:true, location: 'e' }
    }
  );
});
</script>