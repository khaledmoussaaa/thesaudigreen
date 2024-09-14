@extends(Auth()->user()->usertype=='Admin' ? 'layouts.admin' : 'layouts.customer')

@section('title')
{{ __('translate.offerPrice') }}
@endsection

@section('main')
<div class="main toggleActive">
    <livewire:common.view-offer-prices :rid="$rid" :ofd="$ofd" />
</div>
@endsection