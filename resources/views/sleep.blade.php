@extends('layouts.app')
@section('title','Fitness')
@section('workouts','active')
@section('content')
<div class="container">
    <div class="row">
        <form class="col-md-4 mt-1" action="{{url('/workouts/storeSleep')}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <h5>Enter Sleep hours</h5>
            <div class="form-group">
                <label>Date</label>
                <input type="date" class="form-control" name="date">
            </div>

            <div class="form-group">
                <label>Hours</label>
                <input type="text" class="form-control" name="sleep_hours" placeholder="Enter sleep hours">
            </div>

            <div class="form-group offset-md-4">
                <a href="/home" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
        <div class="col-md-7 mt-5 offset-md-1">
            <table class="table table-bordered">
                <thead class="table-info">
                    <tr class="text-center">
                        <th>Sl.No</th>
                        <th>Date</th>
                        <th>Hours sleep</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sleeps as $sleep)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$sleep->date}}</td>
                        <td>{{$sleep->time}}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" class="text-center"><b>Average Sleep Hours</b></td>
                        <td><b>{{number_format($avgSleepHours, 2)}} Hrs</b></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

@endsection