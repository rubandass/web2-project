@extends('layouts.app')
@section('title','Calendar')
@section('calendar','active')
@section('content')
<div class="container">
    {!! $calendar->calendar() !!}
</div>
@endsection
@section('scripts')
{!! $calendar->script() !!}
@endsection