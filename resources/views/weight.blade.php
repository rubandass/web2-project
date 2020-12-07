@extends('layouts.app')
@section('title','Fitness')
@section('workouts','active')
@section('content')
<div class="container">
    <div class="row">
        <form class="col-md-4 mt-1" action="{{url('/workouts/storeWeight')}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <h5>Enter Weight</h5>
            <div class="form-group">
                <label>Date</label>
                <input type="date" class="form-control" name="date">
            </div>

            <div class="form-group">
                <label>Weight</label>
                <input type="text" class="form-control" name="weight" placeholder="Enter weight in kg">
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
                        <th>Weight</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($weights as $weight)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$weight->date}}</td>
                        <td>{{$weight->weight}}</td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</div>

@endsection