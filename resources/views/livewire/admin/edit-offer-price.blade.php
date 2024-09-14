<div class="offerPrice" wire:poll.200ms>
    <div class="createOffer">
        <table class="table">
            <thead class="createOfferHead">
                <tr>
                    <th>{{__('translate.description')}}</th>
                    <th>{{__('translate.price')}}</th>
                    <th><span class="mark scarlet">{{__('translate.sale')}} % </span></th>
                    <th>{{__('translate.quantity')}}</th>
                    <th><span class="mark dodgerBlue">{{__('translate.totalPrice')}}</span></th>
                    <th>{{__('translate.delete')}}</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($cars as $car)
                <tr class="name lightGreen event-row">
                    <td data-title="{{__('translate.factory')}}" colspan="1"><span class=" "><span class="hiddenResponsive">{{__('translate.factory')}}-</span>{{ $car->factory }}</span></td>
                    <td data-title="{{__('translate.km')}}" colspan="1"><span class=" "></span>{{ $car->km }}-<span class="hiddenResponsive">{{__('translate.km')}}</span></td>
                    <td data-title="{{__('translate.place')}}" colspan="1"><span class=" "><span class="hiddenResponsive">{{__('translate.place')}}-</span>{{ $car->place }}</span></td>
                    <td data-title="{{__('translate.plate')}}" colspan="1"><span class=" "> <span class="hiddenResponsive">{{__('translate.plate')}}-</span>{{$car->plate}}</span></td>
                    <td data-title="{{__('translate.problem')}}" colspan="2"><span class=" "> <span class="hiddenResponsive">{{__('translate.problem')}}-</span>{{$car->problem}}</span></td>
                </tr>
                @foreach ($rows[$car->id] as $key => $row)
                <tr>
                    <td class="posaitionRelative" data-title="{{ __('translate.description') }}">
                        <input type="text" wire:model="rows.{{ $car->id }}.{{ $key }}.description" class="input inputs">
                        @error("rows.$car->id.$key.description")
                        <span class="alert-danger">{{ $message }}</span>
                        @enderror
                    </td>

                    <!-- Price -->
                    <td class="posaitionRelative" data-title="{{ __('translate.price') }}">
                        <input type="number" wire:model="rows.{{ $car->id }}.{{ $key }}.price" class="input inputs">
                        @error("rows.$car->id.$key.price")
                        <span class="alert-danger">{{ $message }}</span>
                        @enderror
                    </td>

                    <!-- Sale -->
                    <td class="posaitionRelative" data-title="{{ __('translate.sale') }}">
                        <input type="number" wire:model="rows.{{ $car->id }}.{{ $key }}.sale" class="input inputs">
                        @error("rows.$car->id.$key.sale")
                        <span class="alert-danger">{{ $message }}</span>
                        @enderror
                    </td>

                    <!-- Quantity -->
                    <td class="posaitionRelative" data-title="{{ __('translate.totalQuantity') }}">
                        <input type="number" wire:model="rows.{{ $car->id }}.{{ $key }}.quantity" class="input inputs">
                        @error("rows.$car->id.$key.quantity")
                        <span class="alert-danger">{{ $message }}</span>
                        @enderror
                    </td>

                    <td data-title="{{ __('translate.totalPrice') }}">
                        <span class="dodgerBlue transparent">
                            @if($row['price'] && $row['sale'] >= 0 && $row['quantity'])
                            {{ isset($row['price']) && isset($row['sale']) && isset($row['quantity']) ? $row['price'] * (1 - $row['sale'] / 100) * $row['quantity'] : '' }}
                            @else
                            0
                            @endif
                        </span>
                    </td>
                    <td data-title="{{ __('translate.delete') }}"><span wire:click="delete({{ $row['id'] }}, {{ $car->id }}, {{ $key }})" class="mark scarlet circle" id="deleteRow"><i class="bi bi-dash-circle"></i></span></td>
                </tr>
                @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="totalOffer">
        <div class="response">
            <form wire:submit.prevent="update">
                <button type="submit" class="submit">
                    <span>{{__('translate.update')}}</span>
                </button>
            </form>

            <form method="GET" action="{{ route('Offer-Prices', ['rid' => encrypt($rid)]) }}">
                @csrf
                <button type="submit" class="submit">
                    <i class="bi bi-receipt bt-icon"></i>
                    <span>{{ __('translate.offerPrice') }}</span>
                </button>
            </form>
        </div>

        <div class="totalLabels">
            <label class="dodgerBlue transparent bolder">{{__('translate.totalPrice')}} {{ $total_prices }} {{ __('translate.sar') }}</label>
            <label class="mintCream transparent bolder">{{__('translate.totalQuantity')}} {{ $total_quantity }}</label>
        </div>
    </div>
</div>