<?php

use app\assets\ChartAsset;
use yii\helpers\Html;

ChartAsset::register($this);

$this->title = Html::encode('Áttekintés');

?>

<div class="dashboard-wrapper">
    <div class="row">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">Projektek állapota</div>
                <div id="chart-status"></div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">Top 5 projekt büdzsé (HUF)</div>
                <div id="chart-budget"></div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">Aktív feladatok száma munkatársonként</div>
                <div id="chart-workers"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">Projekt prioritások eloszlása</div>
                <div id="chart-priority"></div>
            </div>
        </div>
    </div>
</div>

<?php
$statusLabelsJs = json_encode($statusLabels);
$statusCountsJs = json_encode($statusCounts);
$budgetLabelsJs = json_encode($budgetLabels);
$budgetValuesJs = json_encode($budgetValues);
$workerLabelsJs = json_encode($workerLabels);
$workerCountsJs = json_encode($workerCounts);
$priorityLabelsJs = json_encode($priorityLabels);
$priorityCountsJs = json_encode($priorityCounts);

$this->registerJs("
    // Projektstátusz
    new ApexCharts(document.querySelector('#chart-status'), {
        chart: { type: 'donut', height: 350, },
        labels: $statusLabelsJs,
        series: $statusCountsJs,
        legend: { position: 'bottom' }
    }).render();

    // Költségvetés
    new ApexCharts(document.querySelector('#chart-budget'), {
        chart: { type: 'bar', height: 350 },
        series: [{ name: 'Keret', data: $budgetValuesJs }],
        xaxis: { 
            categories: $budgetLabelsJs,
            labels: {
                formatter: function (value) {
                    return new Intl.NumberFormat('hu-HU').format(value) + ' Ft';
                }
            }
        },
        dataLabels: {
            enabled: true,
            formatter: function (val) {
                return new Intl.NumberFormat('hu-HU').format(val) + ' Ft';
            }
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return new Intl.NumberFormat('hu-HU').format(val) + ' Ft';
                }
            }
        },
        plotOptions: { bar: { borderRadius: 4, horizontal: true } }
    }).render();

    // Munkatárs
    new ApexCharts(document.querySelector('#chart-workers'), {
        chart: { type: 'bar', height: 300 },
        series: [{ name: 'Feladatok', data: $workerCountsJs }],
        xaxis: { categories: $workerLabelsJs },
        colors: ['#26A69A']
    }).render();

    new ApexCharts(document.querySelector('#chart-priority'), {
        chart: { type: 'donut', height: 350 },
        labels: $priorityLabelsJs,
        series: $priorityCountsJs,
        colors: ['#00E396', '#FEB019', '#FF4560', '#775DD0'],
        legend: { position: 'bottom' }
    }).render();
");
?>