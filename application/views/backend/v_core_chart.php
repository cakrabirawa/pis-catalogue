<?php

?>
<div class="row">
  <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 form-group">
    <div id="chart1" style="width: 100%; height: 300px;"><div class="center-h-w"><i class="fa fa-spin fa-cog fa-4x"></i><br />Loading Chart...</div></div>
  </div>
  <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 form-group">
    <div id="chart2" style="width: 100%; height: 300px;"><div class="center-h-w"><i class="fa fa-spin fa-cog fa-4x"></i><br />Loading Chart...</div></div>
  </div>
  <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 form-group">
    <div id="chart3" style="width: 100%; height: 300px;"><div class="center-h-w"><i class="fa fa-spin fa-cog fa-4x"></i><br />Loading Chart...</div></div>
  </div>
</div>

<?php 
  //$oChartOrders = json_decode($o_chart_orders, true);
?>

<script type="text/javascript">
$(function()
{
  $.ajax({
    type: 'GET',
    url: "<?php print site_url(); ?>c_core_main/gf_chart/",
    beforeSend: function() {
    },
    success: function(data) {
      var JSON = $.parseJSON(data);
      gf_chart_01(JSON[0]);
      gf_chart_02(JSON[1]);
      gf_chart_03(JSON[2]);
      //console.log(JSON[2])
    },
    error: function(xhr) {
    },
    complete: function() {
    },
  });
});
function gf_chart_01(data) {  
  var o = [],
      oName = data.sDatas.split("~"),
      oValue = data.sDatasX.split("~"); 
  for(i=0; i<oName.length; i++) {
    o.push({
      "name": oName[i].split(",")[0],
      "data": oValue[i].split(",").map(Number),
    })
  }
  Highcharts.chart('chart1', {
    chart: { type: 'spline' },
    title: { text: 'Distribution By Qty This Week Last 7 Days' },
    subtitle: { text: null },
    xAxis: { categories: data.sFieldsX.split(",") },
    yAxis: { title: { text: 'Qty Orders' } },
    tooltip: { crosshairs: true, shared: true },
    plotOptions: { spline: { marker: { radius: 4, lineColor: '#666666', lineWidth: 1 } } },
    series: o,
    credits: { enabled: false },
    plotOptions: { series: { label: { connectorAllowed: false }, } },
    responsive: { rules: [{ condition: { maxWidth: 400 }, chartOptions: { legend: { layout: 'horizontal', align: 'center', verticalAlign: 'bottom' } } }]
    }
  });
}
function gf_chart_02(data) { 
  var p = [],
      oName = data.sDatas.split("~"),
      oValue = data.sDatasX.split("~"); 
  for(i=0; i<oName.length; i++) {
    p.push({
      "name": oName[i].split(",")[0],
      "y": parseFloat(oValue[i]),
    })
  }  
  Highcharts.chart('chart2', {
    chart: { type: 'pie', options3d: {
            enabled: true,
            alpha: 45,
            beta: 0
        } },
    title: { text: 'Top 5 Distribution By Product Type Last 7 Days' },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    tooltip: { pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>' },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            depth: 35,
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %'
            }
        }
    },
    series: [{ name: 'Percentage Qty Order: ', colorByPoint: true, data: p }],
    credits: { enabled: false },
  });
}
function gf_chart_03(data) {  
  var q = [],
      oName = data.sDatas.split("~"),
      oValue = data.sDatasX.split("~"); 
  for(i=0; i<oName.length; i++) {
    q.push({
      "name": oName[i].split(",")[0],
      "data": oValue[i].split(",").map(Number),
    })
  }
  Highcharts.chart('chart3', {
    chart: { type: 'spline' },
    title: { text: 'Top 5 Distribution Product Order Last 7 Days' },
    subtitle: { text: null },
    xAxis: { categories: data.sFieldsX.split(",") },
    yAxis: { title: { text: 'Qty Orders' } },
    tooltip: { crosshairs: true, shared: true },
    plotOptions: { spline: { marker: { radius: 4, lineColor: '#666666', lineWidth: 1 } } },
    series: q,
    credits: { enabled: false },
    plotOptions: { series: { label: { connectorAllowed: false }, } },
    responsive: { rules: [{ condition: { maxWidth: 400 }, chartOptions: { legend: { layout: 'horizontal', align: 'center', verticalAlign: 'bottom' } } }]
    }
  });
}
</script>