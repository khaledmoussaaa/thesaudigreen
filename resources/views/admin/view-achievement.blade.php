@extends('layouts.admin')

@section('title')
View Achievement
@endsection

@section('main')
<div class="main toggleActive">
    <div class="view-achievement">

        <!-- Header -->
        <div class="achievement-header">
            <div class="profileRequest">
                <img src="https://ui-avatars.com/api/?uppercase=true&size=60&font-size=0.35&rounded=true&background=random&color=radnom&name={{ $user->name }}" alt="">
                <strong class="name">{{$user->name}}<br> {{$user->email}}</strong>
            </div>

            <form method="GET" action="{{ route('Achivement-PDF') }}" class="requestButtons">
                @csrf
                <input type="hidden" name="uid" value="{{ encrypt($user->id) }}">
                <div class="tooltip">
                    <button type="submit" class="req-button">
                        <i class="bi bi-printer"></i>
                        <span>{{ __('translate.print') }}</span>
                        <div class="tooltiptext">{{ __('translate.print') }}</div>
                    </button>
                </div>
                <div class="tooltip">
                    <button type="submit" class="req-button" name="download" value="download">
                        <i class="bi bi-cloud-arrow-down"></i>
                        <span>{{ __('translate.download') }}</span>
                        <div class="tooltiptext">{{ __('translate.download') }}</div>
                    </button>
                </div>
            </form>
        </div>

        <!-- Details -->
        <div class="achievement-details">
            <table class="table achievement-table">
                <thead>
                    <th>{{__('translate.factory')}}</th>
                    <th>{{__('translate.modelYear')}}</th>
                    <th>{{__('translate.plate')}}</th>
                    <th>{{__('translate.vin')}}</th>
                    <th>{{__('translate.km')}}</th>
                    <th>{{__('translate.place')}}</th>
                </thead>
                <tbody>
                    @foreach($requests as $request)
                    <tr class="lightGreen event-row">
                        <td colspan="1" data-title="{{__('translate.requestID')}}"><span class="hiddenMobile details">{{__('translate.requestID')}} </span>{{ $request->id }}</td>
                        <td colspan="2" data-title="{{__('translate.numberOfCars')}}"><span class="hiddenMobile details">{{__('translate.numberOfCars')}} </span>{{ count($request->request_details) }}</td>
                        <td colspan="2" data-title="{{__('translate.date')}}">{{ $request->created_at->format('D - d/m/y') }}</td>
                        <td colspan="1" data-title="{{__('translate.totalPrice')}}"><span class="hiddenMobile details">{{__('translate.totalPrice')}} </span>{{ $request->total_price->total_price ?? 'x'}}</td>
                    </tr>

                    @foreach($request->request_details as $details)
                    <tr>
                        <td data-title="{{__('translate.factory')}}">{{ $details->factory }}</td>
                        <td data-title="{{__('translate.modelYear')}}">{{ $details->model_year }}</td>
                        <td data-title="{{__('translate.plate')}}">{{ $details->plate }}</td>
                        <td data-title="{{__('translate.vin')}}"><span class="mark scarlet">{{ $details->vin }}</span></td>
                        <td data-title="{{__('translate.km')}}">{{ $details->km }}</td>
                        <td data-title="{{__('translate.place')}}"><span class="mark dodgerBlue">{{ $details->place }}</span></td>
                    </tr>
                    @endforeach
                    @endforeach

                </tbody>
            </table>
        </div>
        <div class="achievement-footer">
            <table class="table">
                <thead class="transparent">
                    <th>{{__('translate.totalPrice')}}</th>
                    <th>{{__('translate.numberOfCars')}}</th>
                </thead>
                <tbody>
                    <tr>
                        <td data-title="{{__('translate.price')}}">{{$totalPrice}}</td>
                        <td data-title="{{__('translate.price')}}">{{$cars}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection