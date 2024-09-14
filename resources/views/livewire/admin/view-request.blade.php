<div class="viewRequest viewRequest-Admin" wire:poll>
    <div class="view-container">
        <div class="aboutRequest">
            <div class="requestInfo">
                <x-header-status icon="bi bi-send" text="{{ __('translate.request') }}" status="{{ $request->status }}" />
                <div class="cardHeader cardCol">
                    <img src="https://ui-avatars.com/api/?uppercase=true&size=60&font-size=0.35&rounded=true&background=random&color=radnom&name={{ $request->user->name }}" alt="">
                    <strong class="name">{{ $request->user->name }}</strong>
                </div>
                <div class="body">
                    <div class="cardLeft cardCol">
                        <span>{{ __('translate.usertype') }}</span>
                        <span>{{ __('translate.requestID') }}</span>
                        <span>{{ __('translate.email') }}</span>
                        <span>{{ __('translate.phone') }}</span>
                        <span>{{ __('translate.response') }}</span>
                    </div>
                    <div class="cardRight cardCol">
                        <strong class="mark @switch($request->user?->type) @case('Customer') scarlet @break @case('Company') goldenYellow @break @case('Governmental') electricPurple @break @endswitch">
                            {{ optional($request->user)->type }}
                        </strong>
                        <strong>SS{{ $request->id }}</strong>
                        <strong>{{ $request->user->email }}</strong>
                        <strong>{{ $request->user->phone }}</strong>
                        <!-- ============================================================================================== -->
                        <div class="response">
                            <form wire:submit.prevent="updateStatus" class="response">
                                @csrf
                                @switch($request->status)
                                @case(0)
                                <x-tooltip-button type="submit" class="req-button accept" name="status" click="setStatus('{{ $statusButton['accept'] }}')" icon="bi bi-check-circle" text="{{ __('translate.accept') }}" />
                                <x-tooltip-button type="submit" class="req-button decline" name="status" click="setStatus('{{ $statusButton['decline'] }}')" icon="bi bi-x-circle" text="{{ __('translate.decline') }}" />
                                @break
                                @case(3)
                                <x-tooltip-button type="submit" class="req-button" name="status" click="setStatus('{{ $statusButton['finish'] }}')" icon="bi bi-check-lg" text="{{ __('translate.finish') }}" />
                                @break
                                @case(4)
                                <x-tooltip-button type="submit" class="req-button" name="status" click="setStatus('{{ $statusButton['complete'] }}')" icon="bi bi-calendar2-check" text="{{ __('translate.completed') }}" confirm='{{ __("translate.completed_confirmation") }}' />
                                @break
                                @endswitch
                                @unless($request->status == 0)
                                <x-tooltip-button type="submit" class="req-button" name="status" click="setStatus('{{ $statusButton['undo'] }}')" icon="bi bi-arrow-clockwise" text="{{ __('translate.undo') }}" />
                                @endunless
                            </form>
                            <x-tooltip-form :route="'Contact'" name="uid" class="req-button" :uid="encrypt($request->user_id)" :rid=null icon="bi bi-person-lines-fill" text="{{ __('translate.contact') }}" />
                            <x-tooltip-form :route="'Create-Offer'" name="rid" class="req-button" :rid="encrypt($request->id)" :uid=null icon="bi bi-receipt" text="{{ __('translate.createOffer') }}" />
                        </div>
                        <!-- ============================================================================================== -->
                    </div>
                </div>
                <div class="cardFooter">
                    <div class="date">
                        <span><i class="bi bi-calendar"></i>{{ $request->created_at->format('D - d/m/y') }}</span>
                        <span><i class="bi bi-clock"></i>{{ $request->created_at->format('h:i A') }}</span>
                    </div>
                </div>
            </div>
            <div class="remark">
                <div class="headSticky">
                    <div class="header">
                        <i class="bi bi-bookmark-check"> {{ (__('translate.remark')) }}</i>
                    </div>
                    <form wire:submit.prevent="{{ $edit ? 'updateRemark' : 'addRemark' }}" class="remarkInput">
                        @csrf
                        <textarea name="content" cols="10" rows="10" class="input" wire:model="remark" placeholder="{{__('translate.remark')}}"></textarea>
                        <button type="submit" class="submit">
                            <i class="bi bi-check2-square bt-icon"></i>
                            <span>{{ __('translate.save') }}</span>
                        </button>
                    </form>
                </div>
                <div class="remarkTable">
                    @forelse($request->remarks as $remark)
                    <div class="request-remark">
                        <input type="checkbox" @checked($remark->checked) value="{{$edit ? 'True' : 'False'}}" class="check" wire:click="toggleRemark({{$remark->id}})">
                        <p>
                            {{$remark->remark}}
                        </p>
                    </div>
                    @if(isset($remark->checked) && $remark->checked)
                    <div class="date transparent bolder">
                        <span></span><i class="bi bi-calendar-check "></i>{{ $remark->checked_at->format('D - d/m/y') }}</span>
                        <span><i class="bi bi-clock-fill"></i>{{ $remark->checked_at->format('h:i A') }}</span>
                    </div>
                    @endif
                    <div class="remarkFooter">
                        <div class="date transparent">
                            <span></span><i class="bi bi-calendar"></i>{{ $remark->created_at->format('D - d/m/y') }}</span>
                            <span><i class="bi bi-clock"></i>{{ $remark->created_at->format('h:i A') }}</span>
                        </div>

                        <div class="response">
                            <button type="submit" class="button edit transparent" wire:click="editRemark('{{ $remark->id }}')" style="border: none;">
                                <i class="bi bi-pencil-square bt-icon"></i>
                                <span>{{ __('translate.edit') }}</span>
                            </button>
                            <button class="button scarlet transparent" wire:click="deleteRemark('{{ $remark->id }}')" wire:confirm="{{ __('translate.sureBlockU') }}" style="border: none;">
                                <i class="bi bi-trash bt-icon"></i>
                                <span>{{ __('translate.delete') }}</span>
                            </button>
                        </div>
                    </div>
                    @empty
                    <div class="empty emptyCenter emptyText">
                        <i class="bi bi-bookmark-x icon"></i>
                        &nbsp;
                        <span>{{ __('translate.noRemarks') }}</span>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="requestDetails">
            <div class="header tableHead hiddenDesktop">
                <i class="bi bi-table"> {{__('translate.requestDetails')}} </i>
            </div>

            <table class="table tableRequest-Admin">
                <thead>
                    <th>{{__('translate.factory')}}</th>
                    <th>{{__('translate.modelYear')}}</th>
                    <th>{{__('translate.plate')}}</th>
                    <th>{{__('translate.vin')}}</th>
                    <th>{{__('translate.km')}}</th>
                    <th>{{__('translate.place')}}</th>
                    <th>{{__('translate.problem')}}</th>
                    @if ($request->user->type == in_array($request->user->type, ['AdminGovernmental', 'EmployeeGovernmental']))
                    <th>{{__('translate.electronicAppNumber')}}</th>
                    @endif
                </thead>

                <tbody>
                    @foreach ($request->request_details as $details )
                    <tr>
                        <td data-title="{{__('translate.factory')}}">{{ $details->factory }}</td>
                        <td data-title="{{__('translate.modelYear')}}">{{ $details->model_year }}</td>
                        <td data-title="{{__('translate.plate')}}">{{ $details->plate }}</td>
                        <td data-title="{{__('translate.vin')}}"><span class="mark scarlet">{{ $details->vin }}</span></td>
                        <td data-title="{{__('translate.km')}}">{{ $details->km }}</td>
                        <td data-title="{{__('translate.place')}}"><span class="mark dodgerBlue">{{ $details->place }}</span></td>
                        <td data-title="{{__('translate.problem')}}">{{ $details->problem }}</td>
                        @if ($request->user->type == in_array($request->user->type, ['AdminGovernmental', 'EmployeeGovernmental']))
                        <td data-title="{{__('translate.problem')}}">{{ $details->electronic_application_number }}</td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>