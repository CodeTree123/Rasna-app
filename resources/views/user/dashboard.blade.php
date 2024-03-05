@extends('layouts.app')
@section('content')
<style>
   
</style>
<div class="container">
  <div class="row justify-content-center p-3 p-md-5 m-2 m-lg-5">
    <div class="col-md-8">
       @if(auth()->user()->kv == 0)
                <div class="alert alert-info" role="alert">
                  <h4 class="alert-heading">@lang('KYC Verification required')</h4>
                  <hr>
                  <p class="mb-0">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Hic officia quod natus, non dicta perspiciatis, quae repellendus ea illum aut debitis sint amet? Ratione voluptates beatae numquam.  <a href="{{ route('user.kyc.form') }}">@lang('Click Here to Verify')</a></p>
                </div>
                @elseif(auth()->user()->kv == 2)
                <div class="alert alert-warning" role="alert">
                    <h4 class="alert-heading">@lang('KYC Verification pending')</h4>
                    <hr>
                    <p class="mb-0">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Hic officia quod natus, non dicta perspiciatis, quae repellendus ea illum aut debitis sint amet? Ratione voluptates beatae numquam.  <a href="{{ route('user.kyc.data') }}">@lang('See KYC Data')</a></p>
                  </div>
       @endif

      <div class="card bg-dark text-dark">
         <img class="card-img" src="{{asset('assets/images/logoIcon/logo.png')}}" alt="Card image">
           <div class="card-img-overlay">
               <h5 class="card-title text-center">Dashboard</h5>
               <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
               <p class="card-text">Last updated 3 mins ago</p>
           </div>
    </div>
  </div>
</div>
@endsection