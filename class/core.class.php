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

        public function Tpie_chart($container) {
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
