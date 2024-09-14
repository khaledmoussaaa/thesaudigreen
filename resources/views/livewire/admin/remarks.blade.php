<div class="all-requests" wire:poll>
    <div class="all-remarks">
        @forelse($tasks as $task)
        <div class="remarkBox scrolled">
            <div class="header headSticky">
                <strong><i class="bi bi-send"> SS{{ $task->id }}</i></strong>
                <label class="ui-bookmark" wire:click.prevent="pinToTop('{{ $task->id }}')">
                    <input type="checkbox" {{ $task->pinned == 1 ? 'checked' : '' }}>
                    <div class="bookmark">
                        <svg viewBox="0 0 32 32">
                            <g>
                                <path d="M27 4v27a1 1 0 0 1-1.625.781L16 24.281l-9.375 7.5A1 1 0 0 1 5 31V4a4 4 0 0 1 4-4h14a4 4 0 0 1 4 4z"></path>
                            </g>
                        </svg>
                    </div>
                </label>
            </div>
            <div class="remark-check scroll">
                @foreach($task->remarks as $remark)
                <div class="checklist">
                    <input {{ $remark->checked == 1 ? 'checked' : '' }} class="check" type="checkbox" wire:click="checkBoxRemark({{$remark->id}})">
                    <p for="{{ $remark->id }}">{{ $remark->remark }}</p>
                </div>
                @endforeach
            </div>
            <div class="view-remark" wire:ignore>
                @if(app()->getLocale() == 'en')
                <i class="bi bi-chevron-right pointer icons" wire:click="viewRid({{$task->id}})" onclick="openPopup()"></i>
                @else
                <i class="bi bi-chevron-left pointer icons" wire:click="viewRid({{$task->id}})" onclick="openPopup()"></i>
                @endif
            </div>
        </div>
        @empty
        <div class="empty emptyCenter emptyText">
            <i class="bi bi-bookmark-x icon"></i>
            &nbsp;
            <span>{{ __('translate.noRemarks') }}</span>
        </div>
        @endforelse
        <div class="popup" wire:ignore.self>
            <div class="headSticky">
                <div class="response">
                    <header class="semibold headers">{{ __('translate.tasks') }}</header>
                    <i class="bi bi-x-circle closePopup pointer" onclick="closePopup()"></i>
                </div>

            </div>
            <table class="table achievement-table">
                <thead>
                    <th>{{__('translate.action')}}</th>
                    <th>{{__('translate.factory')}}</th>
                    <th>{{__('translate.modelYear')}}</th>
                    <th>{{__('translate.plate')}}</th>
                    <th>{{__('translate.vin')}}</th>
                </thead>
                <tbody>
                    @foreach($requests as $car)
                    <tr class="name lightGreen event-row">
                        <td data-title="{{__('translate.factory')}}" colspan="1"><span class=" "><span class="hiddenResponsive">{{__('translate.factory')}}-</span>{{ $car->factory }}</span></td>
                        <td data-title="{{__('translate.km')}}" colspan="1"><span class=" "></span>{{ $car->km }}-<span class="hiddenResponsive">{{__('translate.km')}}</span></td>
                        <td data-title="{{__('translate.place')}}" colspan="1"><span class=" "><span class="hiddenResponsive">{{__('translate.place')}}-</span>{{ $car->place }}</span></td>
                        <td data-title="{{__('translate.plate')}}" colspan="1"><span class=" "> <span class="hiddenResponsive">{{__('translate.plate')}}-</span>{{$car->plate}}</span></td>
                        <td data-title="{{__('translate.problem')}}" colspan="2"><span class=" "> <span class="hiddenResponsive">{{__('translate.problem')}}-</span>{{$car->problem}}</span></td>
                    </tr>
                    @foreach($car->offer_details as $details)
                    <tr>
                        <td data-title="{{__('translate.action')}}"><input {{ $details->checked == 1 ? 'checked' : '' }} class="check" type="checkbox" wire:click="checkBoxDescription({{$details->id}})"></td>
                        <td data-title="{{__('translate.description')}}" colspan="4" class="inLeft">{{$details->description}}</td>
                    </tr>
                    @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function openPopup() {
        $popup = document.querySelector('.popup');
        $popup.classList.add('popupActive');
    }

    function closePopup() {
        $popup = document.querySelector('.popup');
        $popup.classList.remove('popupActive');
    }
</script>