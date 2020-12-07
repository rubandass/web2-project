@extends('layouts.app')
@section('title','Fitness')
@section('fitness','active')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-white">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="row">
                        <h3 class="col-md-10">Targets</h3>
                        <button type="button" class=" btn btn-primary col-md-2" data-toggle="modal" data-target="#addTargetModal">
                            New Target
                        </button>
                    </div>
                    <div>
                        @if(sizeof($targetData) == 0)
                        <p class="alert alert-info mt-2 col-md-3">No targets set. Add targets.</p>
                        @else
                        @foreach($targetData as $data)
                        <div class="mt-2">
                            <form class="form-row" action="{{url('/deleteTarget')}}" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <input class="form-control" type="hidden" name="target_id" value="{{$data->id}}" />
                                <button type="submit" class="btn btn-success col-md-1 btn-sm" style="height:30px">Done</button>
                                <p class="ml-2 mt-1">{{$data->description}}</p>
                            </form>
                        </div>
                        @endforeach
                        @endif
                    </div>
                    <hr>
                    <div class="row">
                        <h3 class="col-md-10">My Best</h3>
                        <div class="col-md-6">
                            <p class="alert alert-success">Your longest workout : <b>{{$longestWorkoutName}}</b> | {{(int)($longestWorkoutTime/60)}} Hr {{(int)($longestWorkoutTime%60)}} mins</p>
                        </div>
                        <div class="col-md-6">
                            <p class="alert alert-success">Your furthest distance : <b>{{$furthestDistanceName}}</b> | {{$furthestDistanceKm}} kms</p>
                        </div>
                    </div>

                    <hr />
                    <div class="row">
                        <div class="col-xs-12 col-md-4">
                            <div style="margin-left: 10px; margin-right: auto; margin-top: 20px; width: 200px;z-index: 1; position: relative;" id="pie_chart">
                            </div>
                            <h5 class="text-center" style="z-index: 100; position: relative;margin-top: -80px;">Activities</h5>
                        </div>
                        <div class="col-xs-12 col-md-4">
                            <div class="text-center" style="margin-left: auto; margin-right: auto; margin-top: 90px; width: 200px;z-index: 100; position: relative;" id="gauge_chart"></div>
                            <h5 class="text-center">Mood index</h5>
                        </div>
                        <div class="col-xs-12 col-md-4 text-center">
                            <div class="text-center" style="margin-left: auto; margin-right: auto; margin-top: 90px; width: 200px;" id="sleep_gauge_chart"></div>
                            <h5>Sleep index</h5>
                        </div>
                    </div>
                    <hr style="z-index: 100; position: relative;"/>
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <div id="bar_chart">
                            </div>
                            <h5 class="text-center">Calories consumption</h5>
                        </div>

                        <div class="col-xs-12 col-md-6">
                            <div id="line_chart">
                            </div>
                            <h5 class="text-center">Weight per week</h5>
                        </div>

                    </div>
                    <hr />
                    <div class="col-xs-12  col-md-12">
                        <div id="bar_compare_chart">
                        </div>
                        <h5 class="text-center">Workout comparison</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('chartScript')
<script type="text/javascript">
    var analyticsPie = <?php echo $name; ?>;
    var analyticsBar = <?php echo $date; ?>;
    var analyticsSleepGauge = <?php echo $sleep; ?>;
    var analyticsGauge = <?php echo $mood; ?>;
    console.log(analyticsGauge);
    var analyticsLine = <?php echo $weight; ?>;
    // Load the Visualization API and the corechart package.
    google.charts.load('current', {
        'packages': ['corechart', 'gauge']
    });

    // Set a callback to run when the Google Visualization API is loaded.
    google.charts.setOnLoadCallback(drawChart);

    // Callback that creates and populates a data table, instantiates the pie chart, passes in the data and draws it.
    function drawChart() {

        // Create the data table.
        var dataPie = new google.visualization.arrayToDataTable(analyticsPie);
        var optionsPie = {
            // title: 'Activities',
            width: 450,
            height: 350,
            //is3D: true,
            pieHole: 0.3
        };

        var dataBar = new google.visualization.arrayToDataTable(analyticsBar);
        var optionsBar = {
            title: 'Calories',
            hAxis: {
                title: 'Date'
            },
            vAxis: {
                title: 'Calories'
            },
            width: '100%',
            height: 350
        };

        var dataSleepGauge = new google.visualization.arrayToDataTable(analyticsSleepGauge);
        var optionsSleepGauge = {
            title: 'Average sleep hrs',
            max: 10,
            min: 0,
            width: '100%',
            height: 200,
            redFrom: 0,
            redTo: 4,
            yellowFrom: 4,
            yellowTo: 7,
            greenFrom: 7,
            greenTo: 10,
            minorTicks: 5
        };

        var dataGauge = new google.visualization.arrayToDataTable(analyticsGauge);
        var optionsGauge = {
            title: 'Current mood',
            max: 10,
            min: 0,
            width: '100%',
            height: 200,
            redFrom: 0,
            redTo: 2,
            yellowFrom: 2,
            yellowTo: 6,
            greenFrom: 6,
            greenTo: 10,
            minorTicks: 5
        };

        var dataLine = new google.visualization.arrayToDataTable(analyticsLine);
        var optionsLine = {
            title: 'Weight in kg (Weekly)',
            curveType: 'function',
            hAxis: {
                title: 'Date',
                slantedText: true,
                slantedTextAngle: 30
            },
            vAxis: {
                title: 'Weight in kg'
            },
            legend: {
                position: 'right'
            },
            width: '100%',
            height: 350
        };

        var maxMinWorkoutTime = <?php echo $maxMinWorkoutTime; ?>;
        var userWorkoutTime = <?php echo $userWorkoutTime; ?>;
        let dates = []
        let mapdata = [
            ['Date', 'Min', 'Yours', 'Max']
        ];
        maxMinWorkoutTime.forEach(function(item) {
            if (!dates.includes(item["date"])) {
                dates.push(item["date"])
            }
        });
        userWorkoutTime.forEach(function(item) {
            if (!dates.includes(item["date"])) {
                dates.push(item["date"])
            }
        });
        dates.forEach(function(date) {
            let mapdataEntry = [new Date(date), 0, 0, 0]
            maxMinWorkoutTime.forEach(function(item) {
                if (item["date"] === date) {
                    mapdataEntry[3] = parseInt(item["max"])
                    mapdataEntry[1] = parseInt(item["min"])
                }
            });
            userWorkoutTime.forEach(function(item) {
                if (item["date"] === date) {
                    mapdataEntry[2] = parseInt(item["time"])
                }
            });
            mapdata.push(mapdataEntry)
        });
        console.log(mapdata);
        var dataBarCompare = new google.visualization.arrayToDataTable(mapdata);
        var optionsBarCompare = {
            title: 'Compare',
            hAxis: {
                title: 'Date',
                format: 'dd MMM'
            },
            vAxis: {
                title: 'Time'
            },
            seriesType: 'bars',
            series: {
                3: {
                    type: 'line'
                }
            },
            'width': '100%',
            'height': 300
        };

        var chartPie = new google.visualization.PieChart(document.getElementById('pie_chart'));
        chartPie.draw(dataPie, optionsPie);


        var chartBar = new google.visualization.ColumnChart(document.getElementById('bar_chart'));
        chartBar.draw(dataBar, optionsBar);

        var chartSleepGauge = new google.visualization.Gauge(document.getElementById('sleep_gauge_chart'));
        chartSleepGauge.draw(dataSleepGauge, optionsSleepGauge);

        var chartGauge = new google.visualization.Gauge(document.getElementById('gauge_chart'));
        chartGauge.draw(dataGauge, optionsGauge);

        var chartLine = new google.visualization.LineChart(document.getElementById('line_chart'));
        chartLine.draw(dataLine, optionsLine);

        var chartBarCompare = new google.visualization.ComboChart(document.getElementById('bar_compare_chart'));
        chartBarCompare.draw(dataBarCompare, optionsBarCompare);
    }
</script>

<!-- Add Target Modal -->
<div class="modal fade" id="addTargetModal" tabindex="-1" role="dialog" aria-labelledby="addTargetModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{url('/addTarget')}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Target</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Desription</label>
                        <input type="text" class="form-control" name="add_target_name" placeholder="Enter Desription">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection