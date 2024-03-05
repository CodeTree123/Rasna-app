@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-7 col-xl-5">
            <div class="card ">
                <div class="card-header bg-primary">
                    <h5 class="card-title text-white">{{ __($pageTitle) }}</h5>
                </div>
                @if(Session::has('success'))
                <small class="text-danger d-block text-center">{{Session::get('success')}}</small>
                @endif
                <div class="card-body bg-light">
                    <form method="POST" action="{{ route('user.login') }}">
                        @csrf
                        <div class="row justify-content-center p-3">
                            
                            <div class="form-group">
                                <label class="form-label">@lang('User Name/Email')</label>
                                <input type="text" class="form-control" name="username" value="{{ old('username') }}">
                            </div>

                            <div class="form-group">
                                <label class="form-label">@lang('Password')</label>
                                <input type="password" class="form-control " name="password">
                            </div>
                        </div>
                        <br>
                        <div class="form-group form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                @lang('Remember Me')
                           </label>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary w-100">
                                @lang('Login')
                            </button>
                        </div>
                    </form>
                    <hr>
                    <div class="text-center">
                        <a class="small" href="{{ route('user.password.request') }}">Forgot Password?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
