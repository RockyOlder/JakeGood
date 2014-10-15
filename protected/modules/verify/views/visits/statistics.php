<?php 
    $charts_path = '/assets/plugins/charts/';
?>
<script type="text/javascript" src="<?php echo $charts_path ?>FusionCharts.js"></script>
<script>

    var callData = function (day) {
        
        url = '<?php echo $this->createAbsoluteUrl("Visits/getData"); ?>';   
        $.getJSON(url, {day:day}, function(json) {
             $.each(json, function(i, item) {

                var chart = new FusionCharts("<?php echo $charts_path ?>"+item.chartsType+".swf", "ChartId_flash", "100%", "500", "0", "1" );
                chart.setJSONData( item.data );
                chart.render('chartsbox');
            })
        })
    };

    $(document).ready(function(){
      callData(7);
    }); 
</script>
<h3 style="background:#eee;padding:5px;">数据中心</h3>
<div>
    <div style="background:#fff;line-height:28px;">
        <button onclick="callData(7)">最近7天</button>
        <button onclick="callData(30)">最近30天</button>
    </div>
    <div id="chartsbox">
    
    </div>

<style>
    .datatable td {padding: 8px;border: 1px solid #efefef;}
    .datatable .header td{background: #eee;}
</style>
    <div>
        <table width="100%" class="datatable">
            <tr class="header">
                <td></td>
                <td>PV</td>
                <td>UV</td>
                <td>成交金额</td>
                <td>成交件数</td>
            </tr>
            <tr>
                <td>昨日</td>
                <td><?php echo $yesterday['pv']; ?></td>
                <td><?php echo $yesterday['uv']; ?></td>
                <td><?php echo $yesterday['total']; ?></td>
                <td><?php echo $yesterday['num']; ?></td>
            </tr>
            <tr>
                <td>最近7天</td>
                <td><?php echo $week['pv']; ?></td>
                <td><?php echo $week['uv']; ?></td>
                <td><?php echo $week['total']; ?></td>
                <td><?php echo $week['num']; ?></td>
            </tr>
            <tr>
                <td>最近30天</td>
                <td><?php echo $month['pv']; ?></td>
                <td><?php echo $month['uv']; ?></td>
                <td><?php echo $month['total']; ?></td>
                <td><?php echo $month['num']; ?></td>
            </tr>
        </table>
    </div>
</div>
        