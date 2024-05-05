@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-around">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h3>Add Product</h3>
                    <div class="col-md-6 d-flex">
                        <a href="{{route('admin.account.list.product')}}" class="btn btn-primary m-1">Product List</a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.account.add.product')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <div class="form-label">Product Name</div>
                            <input type="text" name="name" class="form-control" placeholder="Enter Product Name">
                        </div>
                        <div class="form-group">
                            <div class="form-label">Product Price</div>
                            <input type="text" name="price" class="form-control" placeholder="Enter Product Price">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection