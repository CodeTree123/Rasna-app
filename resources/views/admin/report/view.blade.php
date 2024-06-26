@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-end">
        <div class="col-md-6">
            <h2>{{$pageTitle}}</h2>
        </div>
        <div class="col-md-6">
            @if($pageTitle == 'Dealer Order Details')
            <form action="{{url('admin/report/price/report/dealer')}}/{{$id}}" method="GET">
                @else
                <form action="{{url('admin/report/price/report/seller')}}/{{$id}}" method="GET">
                    @endif

                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="start_date">Start Date:</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date') }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="end_date">End Date:</label>
                            <input type="date" class="form-control" id="end_date" name="end_date">
                        </div>
                        <button type="submit" class="btn btn-primary p-2 m-3">Submit</button>
                    </div>
                </form>
        </div>
    </div>
    <div class="row justify-content-between">
        @if(isset($customDatePrice) && isset($customDateOrders))
        <div class="col-md-6">
            <div class="card mt-2">
                <div class="card-header bg-warning">
                    <h3>Custom Date Range</h3>
                </div>
                <div class="card-body bg-dark text-white">
                    <p>Total Amount: {{ $customDatePrice}}</p>
                    <p>Total Orders: {{ $customDateOrders }} BDT.</p>
                </div>
            </div>
        </div>
        @endif
        <div class="col-md-6">
            <div class="card mt-2">
                <div class="card-header bg-warning">
                    <h3>Todays Information</h3>
                </div>
                <div class="card-body bg-dark text-white">
                    <p>Total Orders: {{$currentDayOrders}} </p>
                    <p>Total Amount: {{$currentDayPrice}} BDT.</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mt-2">
                <div class="card-header bg-warning">
                    <h3>Current Month Information</h3>
                </div>
                <div class="card-body bg-dark text-white">
                    <p>Total Orders: {{$currentMonthOrders}} </p>
                    <p>Total Amount: {{$currentMonthPrice}} BDT.</p><br>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mt-2">
                <div class="card-header bg-warning">
                    <h3>Current Year Information</h3>
                </div>
                <div class="card-body bg-dark text-white">
                    <p>Total Orders: {{$currentYearOrders}} </p>
                    <p>Total Amount: {{$currentYearPrice}} BDT.</p><br>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection