<?php

/* This is the last class in the chain */

class core {

        public function new_mysql($sql) {
                $result = $this->linkID->query($sql) or die(
                        print "
                        <div class=\"alert alert-danger\">
                        <i class=\"fa fa-exclamation-triangle\" aria-hidden=\"true\"></i>&nbsp;

                        <b>There was a MySQL error.</b><br>The following query failed to load:<br><br>
                        $sql<br><br>" .
                        $this->linkID->error.__LINE__
                        . "</div>"
                        );
                return $result;
        }

        // converts an StdObject to an Array
        public function objectToArray($d) {
                if (is_object($d)) {
                        // Gets the properties of the given object
                        // with get_object_vars function
                        $d = get_object_vars($d);
                }

                if (is_array($d)) {
                        /*
                        * Return array converted to object
                        * Using __FUNCTION__ (Magic constant)
                        * for recursive call
                        */
                        //return array_map(__FUNCTION__, $d);
                        return array_map(array($this, 'objectToArray'), $d);
                } else {
                        // Return array
                        return $d;
                }
        } // public function objectToArray($d)

        public function pie_chart_drill($id,$data1,$data2,$title,$title2,$label) {

            $pie_chart = "

            <script>
            var chart1; // globally available
            $(function() {
                chart1 =

                Highcharts.chart('$id', {
                    chart: {
                        type: 'pie'
                    },
                    title: {
                        text: '$title'
                    },
                    subtitle: {
                        text: '$title2'
                    },
                    plotOptions: {
                        series: {
                            dataLabels: {
                                enabled: true,
                                format: '{point.name}: {point.y:.1f}%'
                            }
                        }
                    },

                    tooltip: {
                        headerFormat: '<span style=\"font-size:11px\">{series.name}</span><br>',
                        pointFormat: '<span style=\"color:{point.color}\">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
                    },
                    series: [{
                        name: '$label',
                        colorByPoint: true,
                        data: [
                        $data1
                        ]
                    }],
                    drilldown: {
                        series: [
                        $data2
                        ]
                    }
                });
        });
            </script>

            ";
            return($pie_chart);
        }


        public function combo_chart($dotID) {
            $year = date("Y");
            $sql = "
            SELECT
                `r`.`reviewID`,
                `s`.`Description`

            FROM
                `projects` p,
                `review` r,
                `SubmittalTypes` s

            WHERE
                `p`.`dotID` = '$dotID'
                AND `p`.`id` = `r`.`projectID`
                AND DATE_FORMAT(`r`.`date_received`,'%Y') = '$year'
                AND `r`.`project_phase` = `s`.`id`

            ORDER BY `s`.`Description` ASC
            ";
            $category = "";
            $Description = array();
            $result = $this->new_mysql($sql);
            while ($row = $result->fetch_assoc()) {
                if ($category != $row['Description']) {
                    $cat .= "'".$row['Description']."',";
                    $Description[] = $row['Description'];
                    $category = $row['Description'];
                }
                $review[] = $row['reviewID'];
            }
            $cat = substr($cat,0,-1);
            $total_cats = count($Description);

            $combo = "
            <script>
            var chart1; // globally available
            $(function() {
                chart1 =
                Highcharts.chart('container3', {
                    title: {
                        text: 'Total Number of Comments by Project Phase'
                    },
                    xAxis: {
                        categories: [".$cat."]
                    },
                    yAxis: {
                        title: {
                            text: 'Number of Comments'
                        }
                    },
                    labels: {
                        items: [{
                            html: 'Total Comments by Region/District',
                            style: {
                                left: '50px',
                                top: '18px',
                                color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'
                            }
                        }]
                    },
                    series: [
                    ";
                    $y = "0";
                    $sql2 = "
                    SELECT
                        `r`.`name` AS 'region_name'
                    FROM
                        `region` r,
                        `state` s,
                        `dots` d
                    
                    WHERE
                        `r`.`category` = `s`.`state`
                        AND `s`.`state_id` = `d`.`stateID`
                        AND `d`.`id` = '$dotID'

                    ORDER BY `region_name` ASC
                    ";
                    //$avg1 = "0";
                    //$avg2 = "0";
                    $result2 = $this->new_mysql($sql2);
                    while ($row2 = $result2->fetch_assoc()) {
                        $avg1 = "0";
                        $avg2 = "0";
                        $data1 .= "{type: 'column',name: '$row2[region_name]',";
                        // look up each cat...
                        $r = ""; // init
                        foreach ($Description as $key=>$value) {
                            $total = "0";
                            $sql3 = "
                            SELECT
                                COUNT(`x`.`Comments`) AS 'total',
                                `s`.`Description`

                            FROM
                                `xml_data` x,
                                `review` r,
                                `SubmittalTypes` s,
                                `projects` p,
                                `region` rg

                            WHERE
                                `x`.`reviewID` = `r`.`reviewID`
                                AND `r`.`project_phase` = `s`.`id`
                                AND `s`.`Description` = '$value'
                                AND DATE_FORMAT(`r`.`date_received`, '%Y') = '$year'
                                AND `x`.`projectID` = `p`.`id`
                                AND `p`.`regionID` = `rg`.`id`
                                AND `rg`.`name` = '$row2[region_name]'

                            GROUP BY `s`.`Description`
                            ";

                            $result3 = $this->new_mysql($sql3);
                            while ($row3 = $result3->fetch_assoc()) {
                                $total = $row3['total'];
                            }
                            $r .= $total . ",";

                            $region_name = $row2['region_name'];
                            $region_array[$region_name][] = $total;
                        }

                        $r = substr($r,0,-1);
                        $data1 .= "data: [".$r."]},";
                    }

                    $combo .= $data1;

                    foreach ($region_array as $key=>$value) {
                        foreach ($value as $key2=>$value2) {
                            switch ($key2) {
                                case "0":
                                if ($value2 > 0) {
                                    $avg_1 = $avg_1 + $value2;
                                    $avg_1_c++;
                                }
                                break;

                                case "1":
                                if ($value2 > 0) {
                                    $avg_2 = $avg_2 + $value2;
                                    $avg_2_c++;
                                }
                                break;

                                case "2":
                                if ($value2 > 0) {
                                    $avg_3 = $avg_3 + $value2;
                                    $avg_3_c++;
                                }
                                break;

                                case "3":
                                if ($value2 > 0) {
                                    $avg_4 = $avg_4 + $value2;
                                    $avg_4_c++;
                                }
                                break;

                                case "4":
                                if ($value2 > 0) {
                                    $avg_5 = $avg_5 + $value2;
                                    $avg_5_c++;
                                }
                                break;

                                case "5":
                                if ($value2 > 0) {
                                    $avg_6 = $avg_6 + $value2;
                                    $avg_6_c++;
                                }
                                break; 

                                case "6":
                                if ($value2 > 0) {
                                    $avg_7 = $avg_7 + $value2;
                                    $avg_7_c++;
                                }
                                break;                                                                

                                case "7":
                                if ($value2 > 0) {
                                    $avg_8 = $avg_8 + $value2;
                                    $avg_8_c++;
                                }
                                break;                                                                

                                case "8":
                                if ($value2 > 0) {
                                    $avg_9 = $avg_9 + $value9;
                                    $avg_9_c++;
                                }
                                break; 

                                case "9":
                                if ($value2 > 0) {
                                    $avg_10 = $avg_10 + $value2;
                                    $avg_10_c++;
                                }
                                break;
                            }

                        }
                    }

                    $average_data = ""; // init
                    if ($avg_1 > 0) {
                        $avg_1_v = $avg_1 / $avg_1_c;
                        $average_data .= "$avg_1_v,";
                    }
                    if ($avg_2 > 0) {
                        $avg_2_v = $avg_2 / $avg_2_c;
                        $average_data .= "$avg_2_v,";
                    }
                    if ($avg_3 > 0) {
                        $avg_3_v = $avg_3 / $avg_3_c;
                        $average_data .= "$avg_3_v,";
                    }
                    if ($avg_4 > 0) {
                        $avg_4_v = $avg_4 / $avg_4_c;
                        $average_data .= "$avg_4_v,";
                    }
                    if ($avg_5 > 0) {
                        $avg_5_v = $avg_5 / $avg_5_c;
                        $average_data .= "$avg_5_v,";
                    }
                    if ($avg_6 > 0) {
                        $avg_6_v = $avg_6 / $avg_6_c;
                        $average_data .= "$avg_6_v,";
                    }
                    if ($avg_7 > 0) {
                        $avg_7_v = $avg_7 / $avg_7_c;
                        $average_data .= "$avg_7_v,";
                    }
                    if ($avg_8 > 0) {
                        $avg_8_v = $avg_8 / $avg_8_c;
                        $average_data .= "$avg_8_v,";
                    }
                    if ($avg_9 > 0) {
                        $avg_9_v = $avg_9 / $avg_9_c;
                        $average_data .= "$avg_9_v,";
                    }
                    if ($avg_10 > 0) {
                        $avg_10_v = $avg_10 / $avg_10_c;
                        $average_data .= "$avg_10_v,";
                    }
                    $average_data = substr($average_data,0,-1);


                    $combo .= "
                    {
                        type: 'spline',
                        name: 'Average',
                        data: [$average_data],
                        marker: {
                            lineWidth: 2,
                            lineColor: Highcharts.getOptions().colors[3],
                            fillColor: 'white'
                        }
                    }, 

                    {
                        type: 'pie',
                        name: 'Total Comments',
                        data: [
                        ";

                        foreach($region_array as $key=>$value) {
                            $t = $key;
                            $t2 = array_sum($region_array[$t]);
                            $data4 .= "{name: '$key',y:$t2},";
                        }
                        $data4 = substr($data4,0,-1);
                        $combo .= $data4;
                        $combo .= "

                        ],
                        center: [100, 80],
                        size: 100,
                        showInLegend: false,
                        dataLabels: {
                            enabled: false
                        }
                    }]
                });
        });
            </script>

            ";
            return($combo);

        }

        public function gauge($container,$title,$value) {
            $chart = "

<script>
var chart1; // globally available
$(function() {
chart1 = Highcharts.chart('$container', {

    chart: {
        type: 'gauge',
        plotBackgroundColor: null,
        plotBackgroundImage: null,
        plotBorderWidth: 0,
        plotShadow: false
    },

    title: {
        text: '$title'
    },

    pane: {
        startAngle: -150,
        endAngle: 150,
        background: [{
            backgroundColor: {
                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                stops: [
                    [0, '#FFF'],
                    [1, '#333']
                ]
            },
            borderWidth: 0,
            outerRadius: '109%'
        }, {
            backgroundColor: {
                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                stops: [
                    [0, '#333'],
                    [1, '#FFF']
                ]
            },
            borderWidth: 1,
            outerRadius: '107%'
        }, {
            // default background
        }, {
            backgroundColor: '#DDD',
            borderWidth: 0,
            outerRadius: '105%',
            innerRadius: '103%'
        }]
    },

    // the value axis
    yAxis: {
        min: 0,
        max: 200,

        minorTickInterval: 'auto',
        minorTickWidth: 1,
        minorTickLength: 10,
        minorTickPosition: 'inside',
        minorTickColor: '#666',

        tickPixelInterval: 30,
        tickWidth: 2,
        tickPosition: 'inside',
        tickLength: 10,
        tickColor: '#666',
        labels: {
            step: 2,
            rotation: 'auto'
        },
        title: {
            text: 'Reviews'
        },
        plotBands: [{
            from: 0,
            to: 120,
            color: '#55BF3B' // green
        }, {
            from: 120,
            to: 160,
            color: '#DDDF0D' // yellow
        }, {
            from: 160,
            to: 200,
            color: '#DF5353' // red
        }]
    },

    series: [{
        name: 'Completed',
        data: [$value],
        tooltip: {
            valueSuffix: ' Reviews'
        }
    }]

});

});
</script>
";
            return($chart);
        }

        /*
        $id = distinct name for the chart no spaces
        $data = json data {name: value},{name2: $value2}
        $title = Chart Title
        */
        public function pie_chart($container,$title,$data) {
            $pie_chart = "
            <script>
            var chart1; // globally available
            $(function() {
                chart1 = Highcharts.chart('$container', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: '$title'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                            style: {
                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                            }
                        }
                    }
                },
                series: [{
                    name: '$name',
                    colorByPoint: true,
                    data: [
                    ";
                    $pie_chart .= $data;

                    $pie_chart .= "
                    ]
                }]
            });
        });
            </script>
            ";
            return($pie_chart);
        }

        public function guage($container) {
            $guage = "
            <script>
            var chart1; // globally available
            $(function() {
                chart1 = Highcharts.chart('$container', {
                chart: {
                    type: 'gauge',
                    plotBackgroundColor: null,
                    plotBackgroundImage: null,
                    plotBorderWidth: 0,
                    plotShadow: false
                },
                title: {
                    text: 'Speedometer'
                },

                pane: {
                    startAngle: -150,
                    endAngle: 150,
                    background: [{
                        backgroundColor: {
                            linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                            stops: [
                                [0, '#FFF'],
                                [1, '#333']
                            ]
                        },
                        borderWidth: 0,
                        outerRadius: '109%'
                    }, {
                        backgroundColor: {
                            linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                            stops: [
                                [0, '#333'],
                                [1, '#FFF']
                            ]
                        },
                        borderWidth: 1,
                        outerRadius: '107%'
                    }, {
                        // default background
                    }, {
                        backgroundColor: '#DDD',
                        borderWidth: 0,
                        outerRadius: '105%',
                        innerRadius: '103%'
                    }]
                },

                // the value axis
                yAxis: {
                    min: 0,
                    max: 200,

                    minorTickInterval: 'auto',
                    minorTickWidth: 1,
                    minorTickLength: 10,
                    minorTickPosition: 'inside',
                    minorTickColor: '#666',

                    tickPixelInterval: 30,
                    tickWidth: 2,
                    tickPosition: 'inside',
                    tickLength: 10,
                    tickColor: '#666',
                    labels: {
                        step: 2,
                        rotation: 'auto'
                    },
                    title: {
                        text: 'km/h'
                    },
                    plotBands: [{
                        from: 0,
                        to: 120,
                        color: '#55BF3B' // green
                    }, {
                        from: 120,
                        to: 160,
                        color: '#DDDF0D' // yellow
                    }, {
                        from: 160,
                        to: 200,
                        color: '#DF5353' // red
                    }]
                },

                series: [{
                    name: 'Speed',
                    data: [80],
                    tooltip: {
                        valueSuffix: ' km/h'
                    }
                }]

            });
        });
            </script>
            ";
            return($guage);
        }

        public function client_pie_chart($container) {
            $pie = "
            <script>
            var chart1; // globally available
            $(function() {
                chart1 = Highcharts.chart('".$container."', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: 'Browser market shares January, 2015 to May, 2015'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                            style: {
                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                            }
                        }
                    }
                },
                series: [{
                    name: 'Brands',
                    colorByPoint: true,
                    data: [{
                        name: 'Microsoft Internet Explorer',
                        y: 56.33
                    }, {
                        name: 'Chrome',
                        y: 24.03,
                        sliced: true,
                        selected: true
                    }, {
                        name: 'Firefox',
                        y: 10.38
                    }, {
                        name: 'Safari',
                        y: 4.77
                    }, {
                        name: 'Opera',
                        y: 0.91
                    }, {
                        name: 'Proprietary or Undetectable',
                        y: 0.2
                    }]
                }]
            });
        });
            </script>
            ";
            return($pie);
        }

        public function stacked_column($container,$category,$title,$title2,$chart_data) {
            $stacked = "
            <script>
            var chart1; // globally available
            $(function() {
                chart1 = Highcharts.chart('".$container."', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: '".$title."'
                },
                xAxis: {
                    categories: [".$category."]
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: '".$title2."'
                    },
                    stackLabels: {
                        enabled: true,
                        style: {
                            fontWeight: 'bold',
                            color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                        }
                    }
                },

                tooltip: {
                    headerFormat: '<b>{point.x}</b><br/>',
                    pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
                },
                plotOptions: {
                    column: {
                        stacking: 'normal',
                        dataLabels: {
                            enabled: true,
                            color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                        }
                    }
                },
                series: [

                ".$chart_data."

                ]
            });
        });
            </script>
            ";
            return($stacked);
        }

} // class core
?>
