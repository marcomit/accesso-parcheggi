<?php 
class Chart{
    public static function pie(string $target, string $query, string $label, string $data){
        $result = Database::query($query);
        $values = array();
        while($item = $result->fetch_assoc()){
            $values[$item[$label]] = $item[$data];
        }
        ?>
        <script>
            new Chart(document.getElementById("<?= $target ?>"), {
                type: 'doughnut',
                data: {
                    labels: [<?php foreach ($values as $key => $value): ?>'<?= $key ?>',<?php endforeach ?>],
                    datasets: [{
                    data: [<?php foreach ($values as $key => $value): ?><?= $value == 0 ? 1 : $value ?>,<?php endforeach ?>],
                    backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
                    hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                    },
                    legend: {
                    display: false
                    },
                    cutoutPercentage: 80,
                },
            });
        </script>
    <?php }
    public static function bar(string $target, string $query, string $label, string $data, string $point_label, ?callable $formatKey = null, ?callable $formatValue = null){
        $result = Database::query($query);
        $values = array();
        while($item = $result->fetch_assoc()){
            $values[$item[$label]] = $item[$data];
        }
        ?>
        <script>
            new Chart(document.getElementById("<?= $target ?>"), {
            type: 'bar',
            data: {
                labels: [<?php foreach($values as $key => $value): ?>"<?= $formatKey === null ? $key : $formatKey($key) ?>",<?php endforeach ?>],
                datasets: [{
                    label: "<?= $point_label ?>",
                    backgroundColor: "#4e73df",
                    hoverBackgroundColor: "#2e59d9",
                    borderColor: "#4e73df",
                    data: [<?php foreach($values as $key => $value): ?><?= $formatValue === null ? $value : $formatValue($value) ?>,<?php endforeach ?>],
                    maxBarThickness: 40,
                }],
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
                },
                scales: {
                xAxes: [{
                    time: {
                    unit: 'month'
                    },
                    gridLines: {
                    display: false,
                    drawBorder: false
                    },
                    ticks: {
                    maxTicksLimit: 6
                    },
                }],
                yAxes: [{
                    ticks: {
                    min: 0,
                    //max: 15000,
                    maxTicksLimit: 5,
                    padding: 10,
                    // Include a dollar sign in the ticks
                    callback: function(value, index, values) {
                        return parseInt(value);
                    }
                    },
                    gridLines: {
                    color: "rgb(234, 236, 244)",
                    zeroLineColor: "rgb(234, 236, 244)",
                    drawBorder: false,
                    borderDash: [2],
                    zeroLineBorderDash: [2]
                    }
                }],
                },
                legend: {
                display: false
                },
                tooltips: {
                titleMarginBottom: 10,
                titleFontColor: '#6e707e',
                titleFontSize: 14,
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
                callbacks: {
                    label: function(tooltipItem, chart) {
                    var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                    return datasetLabel + ': ' + tooltipItem.yLabel;
                    }
                }
                },
            }
            });
        </script>
    <?php }
    public static function area(string $target, string $query, string $label, string $data, string $point_label, ?callable $formatKey = null, ?callable $formatValue = null){
        $result = Database::query($query);
        $values = array();
        while($item = $result->fetch_assoc()){
            $values[$item[$label]] = $item[$data];
        }
        ?>
        <script>
            new Chart(document.getElementById("<?= $target ?>"), {
                type: 'line',
                data: {
                    labels: [<?php foreach($values as $key => $value): ?>"<?= $formatKey === null ? $key : $formatKey($key) ?>",<?php endforeach ?>],
                    datasets: [{
                        label: "<?= $point_label ?>",
                        lineTension: 0.3,
                        backgroundColor: "rgba(78, 115, 223, 0.05)",
                        borderColor: "rgba(78, 115, 223, 1)",
                        pointRadius: 3,
                        pointBackgroundColor: "rgba(78, 115, 223, 1)",
                        pointBorderColor: "rgba(78, 115, 223, 1)",
                        pointHoverRadius: 3,
                        pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                        pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                        pointHitRadius: 10,
                        pointBorderWidth: 2,
                        data: [<?php foreach($values as $key => $value): ?><?= $formatValue === null ? $value : $formatValue($value) ?>,<?php endforeach ?>],
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                    },
                    scales: {
                    xAxes: [{
                        time: {
                        unit: 'hour'
                        },
                        gridLines: {
                        display: false,
                        drawBorder: false
                        },
                        ticks: {
                        maxTicksLimit: 7
                        }
                    }],
                    yAxes: [{
                        ticks: {
                        maxTicksLimit: 5,
                        padding: 10,
                        // Include a dollar sign in the ticks
                        callback: function(value, index, values) {
                            return value;
                        }
                        },
                        gridLines: {
                        color: "rgb(234, 236, 244)",
                        zeroLineColor: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2]
                        }
                    }],
                    },
                    legend: {
                    display: false
                    },
                    tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    titleMarginBottom: 10,
                    titleFontColor: '#6e707e',
                    titleFontSize: 14,
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    intersect: false,
                    mode: 'index',
                    caretPadding: 10,
                    callbacks: {
                        label: function(tooltipItem, chart) {
                        var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                        return datasetLabel + ': ' + tooltipItem.yLabel;
                        }
                    }
                    }
                }
            });
    </script>
    <?php }
}