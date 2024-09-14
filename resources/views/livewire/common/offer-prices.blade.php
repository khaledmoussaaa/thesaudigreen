<div class="all-requests overFlowUnset" wire:poll>
    <div class="request-navbar nav" wire:ignore>
        <div wire:ignore>
            @if(Session('success') || Session('error') )
            <div class="alert {{session('success') ? 'success' : 'danger'}}" wire:ignore>
                {{ session('success') ?? session('error') }}
            </div>
            @endif
        </div>

        @if($offers->isNotEmpty() || $search)
        <div class="search-navbar half-width">
            <div class="group">
                <svg viewBox="0 0 24 24" aria-hidden="true" class="iconSearch">
                    <g>
                        <path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path>
                    </g>
                </svg>
                <input class="input" type="search" placeholder="{{ __('translate.search') }}" wire:model.debounce.300ms="search" name="search" />
            </div>
        </div>
        @endif

        @can('admin')
        <form method="GET" action="{{route('Create-Offer')}}">
            @csrf
            <button type="submit" class="submit" name="rid" value="{{ encrypt($rid) }}">
                <i class="bi bi-plus-lg bt-icon"></i>
                <span>{{ __('translate.create') }}</span>
            </button>
        </form>
        @endcan
    </div>

    <div class="offerPrice-container">
        <div class="requests">
            @foreach($offers as $offer)
            <div class="request">
                <div class="header transparent">
                    <i class="bi bi-receipt-cutoff">
                        {{ $offer->offer_number }}
                    </i>
                    <div class="status @switch($offer->status) @case(0) orange @break @case(1) || @case(3) green @break @case(2) || @case(4) red @break @endswitch">
                        {{ __('translate.' . ['pending', 'accept', 'declined', 'firstApproval', 'firstReject'][$offer->status] ) }}
                        @can('employeeGovernmental')
                        {{ $offer->approval == 1 ? '(Waiting Admin)' : ''}}
                        @endcan
                    </div>
                </div>
                <div class="offerPrice-body">
                    <table class="table">
                        <thead class="transparent">
                            <th>{{__('translate.price')}}</th>
                            <th class="scarlet transparent">{{__('translate.sale')}}%</th>
                            <th>{{__('translate.price')}}</th>
                            <th class="scarlet transparent">VAT(15%)</th>
                            <th class="dodgerBlue transparent">{{__('translate.totalPrice')}}</th>
                            <th>{{__('translate.totalQuantity')}}</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td data-title="{{__('translate.price')}}">{{ $offer->price_before_sale }}</td>
                                <td data-title="{{__('translate.sale')}}"><span class="mark scarlet">{{ $offer->sale }}</span></td>
                                <td data-title="VAT(15%)">{{ $offer->price_after_sale }} {{ __('translate.sar') }}</td>
                                <td data-title="{{__('translate.price')}}"><span class="mark scarlet">{{ $offer->vat }} {{ __('translate.sar') }}</span></td>
                                <td data-title="{{__('translate.totalPrice')}}"><span class="mark dodgerBlue">{{ $offer->total_price}} {{ __('translate.sar') }}</span></td>
                                <td data-title="{{__('translate.totalQuantity')}}">{{ $offer->total_quantity }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="footer">

                    <div class="date">
                        <span><i class="bi bi-calendar"></i>{{ $offer->created_at->format('D - d/m/y') }}</span>
                        <span><i class="bi bi-clock"></i>{{ $offer->created_at->format('h:i A') }}</span>
                    </div>

                    <div class="requestButtons">
                        @can('admin')
                        <x-deleted-button click="$dispatch('alert', '{{ encrypt($offer->id) }}')" />

                        <form method="GET" action="{{ route('Edit-OfferPrice') }}">
                            @csrf
                            <input type="hidden" name="rid" value="{{ encrypt($offer->request_id) }}">
                            <input type="hidden" name="ofd" value="{{ encrypt($offer->id) }}">
                            <button type="submit" class="button edit hoverButton">
                                <i class="bi bi-pencil-square bt-icon"></i>
                                <span>{{ __('translate.edit') }}</span>
                            </button>
                        </form>
                        @endcan

                        @if(Auth()->user()->usertype == 'Customer' && ($offer->status == 0) || ($offer->status != 0 && $offer->approval == 1))
                        <form enctype="multipart/form-data">
                            @csrf
                            @can('adminGovernmental')
                            @if($offer->approval == 1)
                            <button type="button" class="button success" wire:click="setStatus('{{ encrypt($offer->id) }}', '{{ encrypt(1) }}','adminApproval')">
                                <i class="bi bi-check-circle bt-icon"></i>
                                <span>{{ __('translate.finalApproval') }}</span>
                            </button>
                            <button type="button" class="button danger" wire:click="$dispatch('reason', [ '{{ encrypt($offer->id) }}', '{{ encrypt(2) }}', 'adminApproval'] )">
                                <i class="bi bi-x-circle bt-icon"></i>
                                <span>{{ __('translate.finalReject') }}</span>
                            </button>
                            @endif
                            @elsecan('employeeGovernmental')
                            @if($offer->approval == 0)
                            <button type="button" class="button success" wire:click="setStatus('{{ encrypt($offer->id) }}', '{{ encrypt(1) }}', 'employeeApproval')">
                                <i class="bi bi-check-circle bt-icon"></i>
                                <span>{{ __('translate.firstApproval') }}</span>
                            </button>
                            <button type="button" class="button danger" wire:click="$dispatch('reason', [ '{{ encrypt($offer->id) }}', '{{ encrypt(2) }}', 'employeeApproval'] )">
                                <i class="bi bi-x-circle bt-icon"></i>
                                <span>{{ __('translate.firstReject') }}</span>
                            </button>
                            @endif
                            @elsecan('customer')
                            <button type="button" class="button success" wire:click="setStatus('{{ encrypt($offer->id) }}', '{{ encrypt(1) }}', null)">
                                <i class="bi bi-check-circle bt-icon"></i>
                                <span>{{ __('translate.accept') }}</span>
                            </button>
                            <button type="button" class="button danger" wire:click="$dispatch('reason', [ '{{ encrypt($offer->id) }}', '{{ encrypt(2) }}'] )">
                                <i class="bi bi-x-circle bt-icon"></i>
                                <span>{{ __('translate.decline') }}</span>
                            </button>
                            @endcan
                        </form>
                        @endif

                        <form method="GET" action="{{ route('View-OfferPrice') }}">
                            @csrf
                            <input type="hidden" name="rid" value="{{ encrypt($offer->request_id) }}">
                            <input type="hidden" name="ofd" value="{{ encrypt($offer->id) }}">
                            <button type="submit" class="button hoverButton" wire:ignore>
                                <i class="bi bi-eye bt-icon"></i>
                                <span>{{ __('translate.view') }}</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @if($offers->isEmpty())
    <div class="empty emptyCenter emptyText">
        <i class="bi bi-receipt-cutoff icon"></i>
        &nbsp;
        <span>{{ __('translate.offerPircesEmpty') }}</span>
    </div>
    @endif
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
                    type: reason[2] ?? null,
                    description: text,
                });
            }
        });
    });
</script>
<script src="{{ asset('JS/alert.js') }}"></script>