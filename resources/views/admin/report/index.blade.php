@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-around">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h3>Seller Order Report</h3>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Seller</th>
                                <th scope="col">Report</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($report as $w)
                            <tr>
                                <td>{{$w->mobile}}</td>
                                <td><a href="{{url('admin/report/price/report')}}/{{$w->id}}" class="btn btn-primary">View</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection