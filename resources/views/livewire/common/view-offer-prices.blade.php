<div class="viewOfferPrice" wire:poll>
    <div class="view-container">
        <div class="view-offerinfo">
            <div class="requestInfo offerInfo">
                <div class="header">
                    <i class="bi bi-person-vcard"> {{ __('translate.userInfo') }}</i>
                    <div class="status @switch($offer->status) @case(0) orange @break @case(1) || @case(3) green @break @case(2) || @case(4) red @break @endswitch">
                        {{ __('translate.' . ['pending', 'accept', 'declined', 'firstApproval', 'firstReject'][$offer->status] ) }}
                        @can('employeeGovernmental')
                        {{ $offer->approval == 1 ? '(Waiting Admin)' : ''}}
                        @endcan
                    </div>
                </div>
                <div class="cardHeader cardCol">
                    <img src="https://ui-avatars.com/api/?uppercase=true&size=60&font-size=0.35&rounded=true&background=random&color=radnom&name={{ $user->name }}" alt="">
                    <strong class="name details">{{ $user->name }}</strong>
                </div>
                <div class="viewOfferCard scroll">

                    <div class="body">
                        <div class="cardLeft cardCol">
                            <span>{{ __('translate.usertype') }}</span>
                            <span>{{ __('translate.email') }}</span>
                            <span>{{ __('translate.phone') }}</span>
                            <span>{{ __('translate.requestID') }}</span>
                            <span>{{ __('translate.offerNumber') }}</span>
                            <span>{{ __('translate.totalQuantity') }}</span>
                            <span>{{ __('translate.sale') }}</span>
                            <span>Vat</span>
                            <span>{{ __('translate.totalPrice') }}</span>
                            <span>{{ __('translate.response') }}</span>
                        </div>
                        <div class="cardRight cardCol ">
                            <strong class="mark @switch($user->type) @case('Customer') scarlet @break @case('Company') goldenYellow @break @case('Governmental') electricPurple @break @endswitch">
                                {{ $user->type }}
                            </strong>
                            <strong>{{ $user->email }}</strong>
                            <strong>{{ $user->phone }}</strong>
                            @can('employee')
                            <a href="{{ route('View-Request',['rid' => encrypt($offer->request_id )]) }}" class="dodgerBlue transparent">{{ __('translate.view') }} <strong>SS{{ $offer->request_id }}</strong></a>
                            @elsecan('customer')
                            <a href="{{ route('Customer-View-Request',['rid' => encrypt($offer->request_id )]) }}" class="dodgerBlue transparent">{{ __('translate.view') }} <strong>SS{{ $offer->request_id }}</strong></a>
                            @endcan
                            <strong>{{ $offer->offer_number }}</strong>
                            <strong>{{ $offer->total_quantity }}</strong>
                            <strong class="scarlet transparent">{{ $offer->sale }} {{ __('translate.sar') }}</strong>
                            <strong class="scarlet transparent">{{ $offer->vat }} {{ __('translate.sar') }}</strong>
                            <strong class="dodgerBlue transparent">{{ $offer->total_price }} {{ __('translate.sar') }}</strong>

                            <div class="response">
                                @if(Auth()->user()->usertype == 'Customer' && ($offer->status == 0) || ($offer->status != 0 && $offer->approval == 1))
                                @can('adminGovernmental')
                                    @if($offer->approval == 1)
                                    <x-tooltip-button type="submit" class="req-button accept" name="status" click="setStatus('{{ encrypt($offer->id) }}', '{{ encrypt(1) }}','adminApproval')" icon="bi bi-check-circle bt-icon" text="{{ __('translate.finalApproval') }}" />
                                    <x-tooltip-button type="submit" class="req-button decline" name="status" click="$dispatch('reason', [ '{{ encrypt($offer->id) }}', '{{ encrypt(2) }}', 'adminApproval'] )" icon="bi bi-x-circle bt-icon" text="{{ __('translate.finalReject') }}" />
                                    @endif
                                @elsecan('employeeGovernmental')
                                    @if($offer->approval == 0)
                                    <x-tooltip-button type="submit" class="req-button accept" name="status" click="setStatus('{{ encrypt($offer->id) }}', '{{ encrypt(1) }}','employeeApproval')" icon="bi bi-check-circle bt-icon" text="{{ __('translate.firstApproval') }}" />
                                    <x-tooltip-button type="submit" class="req-button decline" name="status" click="$dispatch('reason', [ '{{ encrypt($offer->id) }}', '{{ encrypt(2) }}', 'employeeApproval'] )" icon="bi bi-x-circle bt-icon" text="{{ __('translate.firstReject') }}" />
                                    @endif
                                @elsecan('customer')
                                    <x-tooltip-button type="submit" class="req-button accept" name="status" click="setStatus('{{ encrypt($offer->id) }}', '{{ encrypt(1) }}', null)" icon="bi bi-check-circle bt-icon" text="{{ __('translate.accept') }}" />
                                    <x-tooltip-button type="submit" class="req-button decline" name="status" click="$dispatch('reason', [ '{{ encrypt($offer->id) }}', '{{ encrypt(2) }}'] )" icon="bi bi-x-circle bt-icon" text="{{ __('translate.decline') }}" />
                                @endcan
                                @endif
                                <form method="GET" action="{{ route('Print-PDF') }}" class="response">
                                    @csrf
                                    <input type="hidden" name="rid" value="{{ $offer->request_id }}">
                                    <input type="hidden" name="ofd" value="{{ $offer->id }}">
                                    <x-tooltip-button type="submit" class="req-button" name="" click="" icon="bi bi-printer" text="{{ __('translate.print') }}" />
                                    <x-tooltip-button type="submit" class="req-button" name="download" click="" icon="bi bi-cloud-arrow-down" text="{{ __('translate.download') }}" />
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cardFooter cardOffer">
                    <div class="date">
                        <span><i class="bi bi-calendar"></i>{{ $offer->created_at->format('D - d/m/y') }}</span>
                        <span><i class="bi bi-clock"></i>{{ $offer->created_at->format('h:i A') }}</span>
                    </div>
                </div>

            </div>
            <div class="reasones">
                <div class="header headSticky">
                    <i class="bi bi-exclamation-circle-fill"> Decline Reason</i>
                </div>
                <div class="body">
                    @if(!$offer->description)
                    <div class="empty emptyCenter emptyText">
                        <i class="bi bi-exclamation-circle-fill icon"></i>
                        &nbsp;
                        <span>{{ __('translate.noDeclines') }}</span>
                    </div>
                    @else
                    <p>
                        {{$offer->description}}
                    </p>
                    @endif

                </div>
            </div>
        </div>
        <div class="requestDetails viewOffer">
            <div class="headSticky">
                <div class="header">
                    <i class="bi bi-table"> {{__('translate.offerPrice')}} </i>
                </div>
            </div>
            <table class="table">
                <thead>
                    <th>{{__('translate.description')}}</th>
                    <th>{{__('translate.price')}}</th>
                    <th class="scarlet transparent">{{__('translate.sale')}}%</th>
                    <th>{{__('translate.quantity')}}</th>
                    <th class="dodgerBlue transparent">{{__('translate.total')}}</th>
                </thead>
                <tbody>
                    @foreach ($requests as $car)
                    <tr class="name lightGreen event-row">
                        <td data-title="{{__('translate.factory')}}" colspan="1"><span><span class="hiddenResponsive bolder">{{__('translate.factory')}}-</span>{{$car->factory }}</span></td>
                        <td data-title="{{__('translate.km')}}" colspan="1"><span>{{ $car->km }}<span class="hiddenResponsive bolder">--{{__('translate.km')}}</span></span></td>
                        <td data-title="{{__('translate.place')}}" colspan="1"><span><span class="hiddenResponsive bolder">{{__('translate.place')}}-</span>{{ $car->place }}</span></td>
                        <td data-title="{{__('translate.plate')}}" colspan="1"><span> <span class="hiddenResponsive bolder">{{__('translate.plate')}}-</span>{{$car->plate }}</span></td>
                        <td data-title="{{__('translate.vin')}}" colspan="1"><span> <span class="hiddenResponsive bolder">{{__('translate.vin')}}-</span>{{$car->vin }}</span></td>
                    </tr>
                    @foreach ($car->offer_details as $details )
                    <tr>
                        <td data-title="{{__('translate.description')}}">{{ $details->description }}</td>
                        <td data-title="{{__('translate.price')}}">{{ $details->price }}</td>
                        <td data-title="{{__('translate.sale')}}"><span class="mark scarlet">{{ $details->sale }}</span></td>
                        <td data-title="{{__('translate.quantity')}}">{{ $details->quantity }}</td>
                        <td data-title="{{__('translate.total')}}"> <span class="mark dodgerBlue">{{ ($details->price * $details->quantity) * (1 - $details->sale / 100) }} {{ __('translate.sar') }}</span></td>
                    </tr>
                    @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on("reason", async (reason) => {
            const {
                value: text
            } = await Swal.fire({
                input: "textarea",
                inputLabel: "{{__('translate.reasonTitle')}}",
                inputPlaceholder: "{{__('translate.reasonTyping')}}",
                inputRequired: true,
                heightAuto: false,
                confirmButtonText: "{{ __('translate.confirm') }}",
                confirmButtonColor: "#006bb3",
                cancelButtonColor: "#000",
                cancelButtonText: "{{ __('translate.cancel') }}",
                showCancelButton: true,
                inputValidator: (text) => {
                    return new Promise((resolve) => {
                        if (text.trim().length !== 0) {
                            resolve();
                        } else {
                            resolve("{{__('translate.emptyReason')}}");
                        }
                    });
                }
            });

            if (text.trim().length !== 0) {
                Livewire.dispatch('setStatus', {
                    id: reason[0],
                    status: reason[1],
                    description: text,
                });
            }
        });
    });
</script>