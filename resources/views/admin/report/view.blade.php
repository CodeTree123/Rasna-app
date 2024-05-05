@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-around">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h3>Today Orders: {{$currentDayOrders}} BDT.</h3>
                    <h3>Today Amount: {{$currentDayPrice}}</h3><br>
                    <h3>Current Month Orders: {{$currentMonthOrders}} BDT.</h3>
                    <h3>Current Month Amount: {{$currentMonthPrice}}</h3><br>
                    <h3>Current Year Orders: {{$currentYearOrders}} BDT.</h3>
                    <h3>Current Year Amount: {{$currentYearPrice}}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection