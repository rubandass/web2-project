@extends('layouts.app')
@section('title','Fitness')
@section('workouts','active')
@section('content')
<div class="container">
    <div class="row">
        <form class="col-md-4 mt-1" action="{{url('/workouts/storeSnack')}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <h5>Enter Snack details</h5>
            <div class="form-group">
                <label>Date</label>
                <input type="date" class="form-control" name="date">
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label>Item</label>
                    <div class="input-group ml-1">
                        <select class="form-control" name="item_name" id="selectItem">
                            @foreach ($items as $item){
                            <option value="{{$item->id}}" id="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addItemModal">
                            <span class="glyphicon glyphicon-plus"></span> Add
                        </button>
                        <button type="button" class="btn btn-warning btn-sm ml-1 editItem">
                            <span class="glyphicon glyphicon-pencil"></span> Edit
                        </button>
                        <button type="button" class="btn btn-danger btn-sm ml-1 deleteItem" data-url="{{url('/checkItems')}}">
                            <span class="glyphicon glyphicon-trash"></span> Delete
                        </button>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Calories</label>
                <div class="form-row">
                    <input type="text" class="form-control col-md-6 ml-2" name="calorie" placeholder="Enter drink's calorie">
                    <select class="form-control col-md-5 ml-3" name="calorie_type" id="selectItem">
                        <option value="kj">kj</option>
                        <option value="cal">calories</option>
                    </select>
                </div>
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
                        <th>Item</th>
                        <th>Calories</th>
                        <th>Kj</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $slNo = 1;
                    @endphp
                    @foreach($items as $item)
                    @foreach($item->snacks as $snack)
                    <tr>
                        <td>{{$slNo++}}</td>
                        <td>{{$item->name}}</td>
                        <td>{{number_format($snack->calories, 2)}}</td>
                        <td>{{number_format($snack->kj, 2)}}</td>
                        <td>{{$snack->date}}</td>
                    </tr>
                    @endforeach
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" class="text-center"><b>Total</b></td>
                        <td><b>{{number_format($totalCalories, 2)}}</b></td>
                        <td><b>{{number_format($totalKj, 2)}}</b></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<!-- Add Item Modal -->
<div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="addItemModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{url('/addItem')}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input class="form-control" type="hidden" name="item" value="snack" />
                        <label>Name</label>
                        <input type="text" class="form-control" name="add_item_name" placeholder="Enter Item name">
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

<!-- Edit Item Modal -->
<div class="modal fade" id="editItemModal" tabindex="-1" role="dialog" aria-labelledby="editItemModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{url('/updateItem')}}" method="post" enctype="multipart/form-data" id="editItemForm">
                {{csrf_field()}}
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input class="form-control" type="hidden" name="item" value="snack" />
                        <input class="form-control" type="hidden" name="item_id" />
                        <label>Name</label>
                        <input type="text" class="form-control" name="item_name">
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

<!-- Delete Item Modal -->
<div class="modal fade" data-backdrop="static" id="deleteItemModal" tabindex="-1" role="dialog" aria-labelledby="itemDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{url('/deleteItem')}}" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="modal-header">
                    <h5 class="modal-title" id="itemDeleteModalLabel">Delete Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input class="form-control" type="hidden" name="item" value="snack" />
                    <input class="form-control" type="hidden" name="item_id" />
                    <div>
                        <h6 id="noDelete">You can't delete this item <b><span class="spanItemName"></span></b>. It has reference in snack table</h6>
                        <h6 id="delete">Are you sure you want to delete this item: <b><span class="spanItemName"></span></b> ?</h6>
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
<script src="{{asset('/js/item.js')}}"></script>
@endsection