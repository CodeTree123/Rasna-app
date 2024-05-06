@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-around">
        <div class="col-md-6">
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
                                <td><a href="{{url('admin/report/price/report')}}/{{$w->id}}" class="btn btn-primary">View</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($report->hasPages())
                <div class="card-footer py-4">
                    <p class="text-italic">Click below to see next page</p> @php echo paginateLinks($report) @endphp
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@push('breadcrumb-plugins')
<div class="container mt-2">
    <div class="row align-items-center">
        <div class="col">
            <p class="text-success" style="font-size: 20px;">Search by Mobile Number :</p>
        </div>
        <div class="col">
            <x-search-form dateSearch="no" />
        </div>
    </div>
</div>
@endpush