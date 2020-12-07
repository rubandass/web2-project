@extends('layouts.app')
@section('title','Workouts')
@section('workouts','active')
@section('content')
<div class="container">
    <div class="row">
        <form class="col-md-4 mt-3" action="{{url('/workouts/storeAcitivy')}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form-group row col-md-12">
                <label for="selectActivity">Activity</label>
                <div class="input-group">
                    <select class="form-control" name="activity" id="selectActivity">
                        @foreach ($activities as $activity){
                        <option value="{{$activity->id}}" id="{{$activity->id}}">{{$activity->name}}</option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-success btn-sm ml-1" data-toggle="modal" data-target="#addActivityModal">
                        <span class="glyphicon glyphicon-plus"></span> Add
                    </button>
                    <button type="button" class="btn btn-warning btn-sm ml-1 editActivity">
                        <span class="glyphicon glyphicon-pencil"></span> Edit
                    </button>
                    <button type="button" class="btn btn-danger btn-sm ml-1 deleteActivity" data-url="{{url('/checkActivities')}}">
                        <span class="glyphicon glyphicon-trash"></span> Delete
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label>Distance</label>
                <input type="text" class="form-control" name="distance" placeholder="Enter distance in km">
            </div>

            <div class="form-group">
                <label>Workout Time</label>
                <div class="form-row">
                    <input class="form-control col-md-5 ml-1" type="text" name="time_hr" placeholder="Hr" />
                    <span class="ml-2 mr-2">:</span>
                    <input class="form-control col-md-6" type="text" name="time_min" placeholder="Min" />
                </div>
            </div>

            <div class="form-group">
                <label>Workout date</label>
                <input type="date" class="form-control" name="date">
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
                        <th>Activity</th>
                        <th>Distance</th>
                        <th>Time</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $slNo = 1;
                    @endphp
                    @foreach($activities as $activity)
                    @foreach($activity->workouts as $workout)
                    <tr>
                        <td>{{$slNo++}}</td>
                        <td>{{$activity->name}}</td>
                        @if($workout->distance != null)
                        <td>{{$workout->distance}}</td>
                        @else
                        <td>0</td>
                        @endif
                        <td>{{(int)($workout->time/60)}} Hrs {{(int)($workout->time%60)}} mins</td>
                        <td>{{$workout->date}}</td>
                    </tr>
                    @endforeach
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" class="text-center"><b>Total</b></td>
                        <td><b>{{$totalWorkoutDistance}} km</b></td>
                        <td><b>{{(int)($totalTimeInMin/60)}} Hr {{(int)($totalTimeInMin%60)}} mins</b></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
</div>

<!-- Add Activity Modal -->
<div class="modal fade" id="addActivityModal" tabindex="-1" role="dialog" aria-labelledby="addActivityModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{url('/addActivity')}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Activity</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="activityName" placeholder="Enter activity name">
                    </div>
                    <div class="form-group ">

                        <label>Activity color</label>
                        <input type="color" class="ml-2" style="width30px; height:30px" name="activityColor" placeholder="Choose activity color">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Activity Modal -->
<div class="modal fade" id="editActivityModal" tabindex="-1" role="dialog" aria-labelledby="editActivityModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{url('/updateActivity')}}" method="post" enctype="multipart/form-data" id="editActivityForm">
                {{csrf_field()}}
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Activity</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input class="form-control" type="hidden" name="activity_id" />
                        <label>Name</label>
                        <input type="text" class="form-control" name="activity_name">
                    </div>
                    <div class="form-group ">

                        <label>Activity color</label>
                        <input type="color" class="ml-2" style="width30px; height:30px" name="activity_color" placeholder="Choose activity color">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Activity Modal -->
<div class="modal fade" data-backdrop="static" id="deleteActivityModal" tabindex="-1" role="dialog" aria-labelledby="activityDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{url('/deleteActivity')}}" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="modal-header">
                    <h5 class="modal-title" id="activityDeleteModalLabel">Delete Activity</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input class="form-control" type="hidden" name="activity_id" />
                    <div>
                        <h6 id="noDelete">You can't delete, This activity has reference in workouts table</h6>
                        <h6 id="delete">Are you sure you want to delete this activity: <b><span id="spanActivityName"></span></b> ?</h6>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnCancel" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" id="btnYes" name="submit" class="btn btn-primary">Yes</button>
                    <button type="button" id="btnOk" class="btn btn-secondary" data-dismiss="modal">OK</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('jsScript')
<script src="{{asset('/js/activity.js')}}"></script>
@endsection