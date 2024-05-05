@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-around">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header" style="background-color: #55aa29;">

                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="text-white">Table of Products</h3>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Product Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($product as $w)
                            <tr>
                                <td>{{$w->name}}</td>
                                <td>{{$w->price}}</td>
                                <td><a href="{{url('admin/account/product/edit')}}/{{$w->id}}" class="btn btn-primary">Edit</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($product->hasPages())
                <div class="card-footer py-4">
                    <p class="text-italic">Click below to see next page</p> @php echo paginateLinks($product) @endphp
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
            <p class="text-success" style="font-size: 20px;">Search by product name or price :</p>
        </div>
        <div class="col">
            <x-search-form dateSearch="no" />
        </div>
    </div>
</div>
@endpush