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
                @foreach ($rows as $carIndex => $car)
                <tr class="name lightGreen event-row">
                    <td data-title="{{__('translate.factory')}}" colspan="1"><span class=" "><span class="hiddenResponsive">{{__('translate.factory')}}-</span>{{ $car['carDetails']->factory }}</span></td>
                    <td data-title="{{__('translate.km')}}" colspan="1"><span class=" "></span>{{ $car['carDetails']->km }}-<span class="hiddenResponsive">{{__('translate.km')}}</span></td>
                    <td data-title="{{__('translate.place')}}" colspan="1"><span class=" "><span class="hiddenResponsive">{{__('translate.place')}}-</span>{{ $car['carDetails']->place }}</span></td>
                    <td data-title="{{__('translate.plate')}}" colspan="1"><span class=" "> <span class="hiddenResponsive">{{__('translate.plate')}}-</span>{{$car['carDetails']->plate}}</span></td>
                    <td data-title="{{__('translate.problem')}}" colspan="2"><span class=" "> <span class="hiddenResponsive">{{__('translate.problem')}}-</span>{{$car['carDetails']->problem}}</span></td>
                </tr>
                @foreach ($car['inputs'] as $key => $row)
                <tr>
                    <!-- Description -->
                    <td class="posaitionRelative" data-title="{{ __('translate.description') }}">
                        <textarea cols="30" name="description" rows="10" wire:model="rows.{{ $carIndex }}.inputs.{{ $key }}.description" class="input inputs" placeholder="{{__('translate.typeHere')}}" wire:ignore></textarea>
                        @error("rows.{$carIndex}.inputs.{$key}.description")
                        <span class="alert-danger">{{ $message }}</span>
                        @enderror
                    </td>

                    <!-- Price -->
                    <td class="posaitionRelative" data-title="{{ __('translate.price') }}">
                        <input type="number" wire:model="rows.{{ $carIndex }}.inputs.{{ $key }}.price" class="input inputs">
                        @error("rows.{$carIndex}.inputs.{$key}.price")
                        <span class="alert-danger">{{ $message }}</span>
                        @enderror
                    </td>

                    <!-- Sale -->
                    <td class="posaitionRelative" data-title="{{ __('translate.sale') }}">
                        <input type="number" wire:model="rows.{{ $carIndex  }}.inputs.{{ $key }}.sale" class="input inputs">
                        @error("rows.{$carIndex}.inputs.{$key}.sale")
                        <span class="alert-danger">{{ $message }}</span>
                        @enderror
                    </td>

                    <!-- Quantity -->
                    <td class="posaitionRelative" data-title="{{ __('translate.totalQuantity') }}">
                        <input type="number" wire:model="rows.{{ $carIndex }}.inputs.{{ $key }}.quantity" class="input inputs">
                        @error("rows.{$carIndex}.inputs.{$key}.quantity")
                        <span class="alert-danger">{{ $message }}</span>
                        @enderror
                    </td>
                    <!-- Total Price -->
                    <td class="" data-title="{{ __('translate.totalPrice') }}">
                        <span class="dodgerBlue transparent">
                            @if($row['price'] && $row['sale'] >= 0 && $row['quantity'])
                            {{ isset($row['price']) && isset($row['sale']) && isset($row['quantity']) ? $row['price'] * (1 - $row['sale'] / 100) * $row['quantity'] : '' }}
                            @else
                            0
                        </span>
                        @endif
                    </td>
                    <td data-title="{{ __('translate.delete') }}"><span wire:click="deleteRow({{ $carIndex }}, {{ $key }})" class="mark scarlet circle" id="deleteRow"><i class="bi bi-dash-circle"></i></span></td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="6" data-title="{{ __('translate.addRow') }}">
                        <span wire:click="addRow({{ $carIndex }})" class="mark mintCream circle" id="addrow"><i class="bi bi-plus-circle"></i></span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="totalOffer">
        <div class="response">
            <form wire:submit.prevent="intializeOffer">
                <button type="submit b" class="submit">
                    <i class="bi bi-check2-square bt-icon"></i>
                    <span>{{__('translate.save')}}</span>
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
            <label class="dodgerBlue transparent">{{__('translate.totalPrice')}} {{ $totalPrices }} {{ __('translate.sar') }}</label>
            <label class="mintCream transparent">{{__('translate.totalQuantity')}} {{ $totalQuantity }}</label>
        </div>
    </div>
</div>