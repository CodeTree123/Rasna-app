@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-around">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h3>Edit Product</h3>
                    <div class="col-md-6 d-flex">
                        <a href="{{route('admin.account.list.product')}}" class="btn btn-primary m-1">Product List</a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.account.update.product')}}" method="post">
                        @csrf
                        <input type="text" class="d-none" name="id" value="{{$product->id}}" id="">
                        <div class="form-group">
                            <div class="form-label">Product Name</div>
                            <input type="text" name="name" class="form-control" value="{{$product->name}}" placeholder="Enter Product Name">
                        </div>
                        <div class="form-group">
                            <div class="form-label">Product Price</div>
                            <input type="text" name="price" class="form-control" value="{{$product->price}}" placeholder="Enter Product Price">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection