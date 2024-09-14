<div class="viewRequest" wire:poll>
    <div class="requestDetails">
        <div class="header tableHead hiddenDesktop">
            <i class="bi bi-table"> {{ __('translate.requestDetails') }}</i>
        </div>
        <table class="table">
            <thead>
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
                <th>{{__('translate.delete')}}</th>
            </thead>
            <tbody>
                @foreach ($rows as $key => $row)
                <tr>
                    <!-- Factory -->
                    <td class="posaitionRelative" data-title="Factory">
                        <input type="text" wire:model="rows.{{ $key }}.factory" class="input tableInputs" placeholder="EX- Toyota, Honda, Ford">
                        @error("rows.$key.factory")
                        <span class="alert-danger">{{ $message }}</span>
                        @enderror
                    </td>
                    <!-- Year Model -->
                    <td class="posaitionRelative" data-title="Model Year">
                        <input type="text" wire:model="rows.{{ $key }}.model_year" class="input tableInputs" placeholder="EX- 2022, 2019, 2015">
                        @error("rows.$key.model_year")
                        <span class="alert-danger">{{ $message }}</span>
                        @enderror
                    </td>
                    <!-- Plate -->
                    <td class="posaitionRelative" data-title="Plate">
                        <input type="text" wire:model="rows.{{ $key }}.plate" class="input tableInputs" placeholder="EX- ABC-123, XYZ-456">
                        @error("rows.$key.plate")
                        <span class="alert-danger">{{ $message }}</span>
                        @enderror
                    </td>
                    <!-- Vin -->
                    <td class="posaitionRelative" data-title="VIN">
                        <input type="text" wire:model="rows.{{ $key }}.vin" class="input tableInputs" placeholder="EX- 1HGCM82633A004352">
                        @error("rows.$key.vin")
                        <span class="alert-danger">{{ $message }}</span>
                        @enderror
                    </td>
                    <!-- KM -->
                    <td class="posaitionRelative" data-title="Kilometers">
                        <input type="text" wire:model="rows.{{ $key }}.km" class="input tableInputs" placeholder="EX- 50000, 75000">
                        @error("rows.$key.km")
                        <span class="alert-danger">{{ $message }}</span>
                        @enderror
                    </td>
                    <!-- Place -->
                    <td class="posaitionRelative" data-title="Place">
                        <input type="text" wire:model="rows.{{ $key }}.place" class="input tableInputs" placeholder="EX- City, Country">
                        @error("rows.$key.place")
                        <span class="alert-danger">{{ $message }}</span>
                        @enderror
                    </td>
                    <!-- Problem -->
                    <td class="posaitionRelative" data-title="Problem">
                        <input type="text" wire:model="rows.{{ $key }}.problem" class="input tableInputs" placeholder="EX- Engine overheating, Brake issue">
                        @error("rows.$key.problem")
                        <span class="alert-danger">{{ $message }}</span>
                        @enderror
                    </td>
                    <!-- Electronic Application Number -->
                    @if (Auth::user()->can('adminGovernmental') || Auth::user()->can('employeeGovernmental'))
                    <td class="posaitionRelative" data-title="Problem">
                        <input type="text" wire:model="rows.{{ $key }}.electronic_application_number" class="input tableInputs" placeholder="EX- Engine overheating, Brake issue">
                        @error("rows.$key.electronic_application_number")
                        <span class="alert-danger">{{ $message }}</span>
                        @enderror
                    </td>
                    @endif
                    <td data-title="{{ __('translate.delete') }}"><span wire:click="deleteRow({{ $key }})" class="mark scarlet circle" id="deleteRow"><i class="bi bi-dash-circle"></i></span></td>
                </tr>
                @endforeach
                <tr class="transparent">
                    <td colspan="8" data-title="{{ __('translate.addRow') }}">
                        <span wire:click="addRow()" class="mark mintCream circle" id="addrow"><i class="bi bi-plus-circle"></i></span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="createFooter">
        <button class="submit hoverButton" wire:click="saveRequest()"> @if($rid) {{__('translate.update')}} @else {{__('translate.create')}} @endif</button>
    </div>
</div>