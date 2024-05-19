@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-around">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-warning">
                    <h3>Create User Account</h3>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.account.create.code')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <div class="form-label">User Under Ram/Dealer</div>
                            <select name="ref_by" class="form-control" id="ref_by">
                                <option value="">Select</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="form-label">User Name</div>
                            <input type="text" name="username" class="form-control" placeholder="type username">
                        </div>
                        <div class="form-group">
                            <div class="form-label">User Type</div>
                            <select name="account_type" class="form-control" id="">
                                <option value="3">Seller</option>
                                <option value="2">Dealer</option>
                                <option value="1">Ram</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="form-label">User Mobile Number</div>
                            <input type="text" name="mobile" class="form-control" placeholder="type mobile number">
                        </div>
                        <div class="input-group">
                            <input type="password" name="password" class="form-control" id="passwordInput" placeholder="Type password">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mt-2">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function($) {
        $('#ref_by').select2({
            ajax: {
                url: '{{ route("admin.account.get.user.data") }}',
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.mobile + " " + item.username,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            },
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.getElementById('passwordInput');
        const togglePassword = document.getElementById('togglePassword');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    });
</script>
@endsection