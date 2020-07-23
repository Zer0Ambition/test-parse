<?php

use yii\widgets\DetailView;
use common\models\User;

$this->registerJsFile('/amcharts/core.js', ['position' => \yii\web\View::POS_END]);
$this->registerJsFile('/amcharts/charts.js', ['position' => \yii\web\View::POS_END]);
$this->registerJsFile('/amcharts/themes/animated.js', ['position' => \yii\web\View::POS_END]);
$this->registerJsFile('/amcharts/lang/en.js', ['position' => \yii\web\View::POS_END]);

$result = json_encode($result);

$script = <<< JS
am4core.ready(function() {
    am4core.useTheme(am4themes_animated);
    am4core.options.onlyShowOnViewport = true;

    /*---------------------------------------*/
    /*  Create chart for the parsed table    */
    /*---------------------------------------*/
    var chart = am4core.create("chartdiv", am4charts.XYChart);
    chart.language.locale = am4lang_en;
    chart.paddingRight = 20;

    chart.dateFormatter.inputDateFormat = "yyyy.MM.dd HH:ii";
    var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
    dateAxis.zoom({start:0.99, end:1}, false, true);
    dateAxis.baseInterval = {
      "timeUnit": "minute",
      "count": 1
    };
    dateAxis.tooltipDateFormat = "d MMM yyyy HH:mm";

    var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
    valueAxis.tooltip.disabled = true;
    valueAxis.title.text = "Total Profit";

    var data = $result;
    chart.data = data;

    var series = chart.series.push(new am4charts.LineSeries());

    series.dataFields.dateX = "date";
    series.dataFields.valueY = "profit";
    series.tooltipText = "[bold]{valueY}[/]";
    series.fillOpacity = 0.3;
    series.bullets.push(new am4charts.CircleBullet());
    series.connect = true;

    chart.cursor = new am4charts.XYCursor();
    chart.cursor.behavior = "panXY";
    chart.cursor.xAxis = dateAxis;
    chart.cursor.lineY.opacity = 0;
    chart.scrollbarX = new am4charts.XYChartScrollbar();
    chart.scrollbarX.series.push(series);
    chart.cursor.fullWidthLineX = true;
    chart.cursor.lineX.strokeOpacity = 0;
    chart.cursor.lineX.fill = am4core.color("#000");
    chart.cursor.lineX.fillOpacity = 0.1;
});
JS;
$this->registerJs($script);
?>

<div class="box-body">
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        [
            'attribute' => 'created_at',
            'value' => function ($model) {
                $date = new DateTime($model->created_at);
                return $date->format('d.m.Y H:i');
            },
        ],
        'name',
        [
            'attribute' => 'user_id',
            'value' => function($model){
                if ($model->user_id) {
                    $user = User::findOne($model->user_id);
                    if ($user) {
                        return $user->username;
                    }
                }
            },
        ],
        [
            'attribute' => 'status',
            'value' => function($model){return \common\models\TableFile::getStatusArray()[$model->status];},
        ],
    ]
]);
?>

    <div id="chartdiv" class="chartdiv" style="height:700px">
        <div class="chartdiv__loading"></div>
    </div>
</div>