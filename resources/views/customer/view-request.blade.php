@extends('layouts.customer')

@section('title')
{{ __('translate.viewRequest') }}
@endsection

@section('main')
<div class="main toggleActive">
    <div class="customer-viewRequest">
        <div class="request-navbar viewRequestNav">
            <div class="request-info">
                <i class="bi bi-send"> <span class="details">{{ __('translate.requestID') }} <strong>SS{{ $rid }}</strong></span></i>
            </div>
            <form method="GET" action="{{ route('Offer-Price') }}">
                @csrf
                <input type="hidden" name="rid" value="{{ encrypt($rid) }}">
                <button type="submit" class="submit">
                    <i class="bi bi-receipt bt-icon"></i>
                    <span>{{ __('translate.offerPrice') }}</span>
                </button>
            </form>
        </div>

        <div class="requestDetails">
            <div class="header tableHead hiddenDesktop">
                <i class="bi bi-table"> {{ __('translate.requestDetails') }}</i>
            </div>
            <table class="table">
                <thead class="transparent">
                    <th>{{__('translate.factory')}}</th>
                    <th>{{__('translate.modelYear')}}</th>
                    <th>{{__('translate.plate')}}</th>
                    <th>{{__('translate.vin')}}</th>
                    <th>{{__('translate.km')}}</th>
                    <th>{{__('translate.place')}}</th>
                    <th>{{__('translate.problem')}}</th>
                    @if (Auth::user()->can('adminGovernmental') || Auth::user()->can('employeeGovernmental'))
                    <th>{{__('translate.electronicAppNumber')}}</th>
                    @endif
                </thead>
                <tbody>
                    @foreach ($requestDetails as $details )
                    <tr>
                        <td data-title="{{__('translate.factory')}}">{{ $details->factory }}</td>
                        <td data-title="{{__('translate.modelYear')}}">{{ $details->model_year }}</td>
                        <td data-title="{{__('translate.plate')}}">{{ $details->plate }}</td>
                        <td data-title="{{__('translate.vin')}}"><span class="mark mintCream">{{ $details->vin }}</span></td>
                        <td data-title="{{__('translate.km')}}">{{ $details->km }}</td>
                        <td data-title="{{__('translate.place')}}"><span class="mark dodgerBlue">{{ $details->place }}</span></td>
                        <td data-title="{{__('translate.problem')}}">{{ $details->problem }}</td>
                        @if (Auth::user()->can('adminGovernmental') || Auth::user()->can('employeeGovernmental'))
                        <td data-title="{{__('translate.problem')}}">{{ $details->electronic_application_number }}</td>
                        @endif

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection