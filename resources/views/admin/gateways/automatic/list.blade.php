@extends('admin.layouts.app')

@section('content')
@php 
Use App\Constants\Status;
@endphp
<div class="container-fluid">
    <div class="row justify-content-center">

    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">{{$pageTitle}}</h6>
                        </div>
    <div class="card-body">
                <div class="table-responsive">
                     <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>@lang('Gateway')</th>
                                <th>@lang('Supported Currency')</th>
                                <th>@lang('Enabled Currency')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($gateways->sortBy('alias') as $k=>$gateway)
                                <tr>
                                    <td>{{__($gateway->name)}}</td>

                                    <td>
                                        {{ collect($gateway->supported_currencies)->count() }}
                                    </td>
                                    <td>
                                        {{ $gateway->currencies->count() }}
                                    </td>


                                    <td>
                                        @php
                                            echo $gateway->statusBadge
                                        @endphp
                                    </td>
                                    <td>
                                        <div class="button-group">
                                            <a href="{{ route('admin.gateway.automatic.edit', $gateway->alias) }}" class="btn btn-sm btn-outline-primary editGatewayBtn">
                                                <i class="fa fa-pencil"></i> @lang('Edit')
                                            </a>


                                            @if($gateway->status == Status::DISABLE)
                                                <button class="btn btn-sm btn-outline-success ms-1 confirmationBtn" data-question="@lang('Are you sure to enable this gateway?')" data-action="{{ route('admin.gateway.automatic.status',$gateway->id) }}">
                                                    <i class="fa fa-eye"></i> @lang('Enable')
                                                </button>
                                            @else
                                                <button class="btn btn-sm btn-outline-danger ms-1 confirmationBtn" data-question="@lang('Are you sure to disable this gateway?')" data-action="{{ route('admin.gateway.automatic.status',$gateway->id) }}">
                                                    <i class="fa fa-eye-slash"></i> @lang('Disable')
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
            </div><!-- card end -->
        </div>
    </div>
</div>

    <x-confirmation-modal />
@endsection
@push('breadcrumb-plugins')
    <div class="d-inline">
        <div class="input-group justify-content-end">
            <input type="text" name="search_table" class="form-control bg-white" placeholder="@lang('Search')...">
            <button class="btn btn-primary input-group-text"><i class="fa fa-search"></i></button>
        </div>
    </div>
@endpush
