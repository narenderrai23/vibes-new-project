{{--
    Reusable Country → State dependent dropdown component.

    Props:
      $selectedCountryId  — currently selected country id (for edit mode)
      $selectedStateId    — currently selected state id (for edit mode)
      $countryRequired    — whether country is required (default false)
      $stateRequired      — whether state is required (default false)
      $colCountry         — Bootstrap col class for country (default 'col-12 col-sm-6')
      $colState           — Bootstrap col class for state   (default 'col-12 col-sm-6')
--}}

@props([
    'selectedCountryId' => null,
    'selectedStateId'   => null,
    'countryRequired'   => false,
    'stateRequired'     => false,
    'colCountry'        => 'col-12 col-sm-6',
    'colState'          => 'col-12 col-sm-6',
    'submitCountryId'   => true,
])

@php
    $countries = \Modules\Center\Models\Country::orderBy('name')->pluck('name', 'id')->toArray();

    // Pre-load states for the selected country (edit mode)
    $preloadedStates = $selectedCountryId
        ? \Modules\Center\Models\State::where('country_id', $selectedCountryId)
              ->orderBy('name')->pluck('name', 'id')->toArray()
        : [];
@endphp

<div class="{{ $colCountry }} mb-3">
    <div class="form-group">
        <label for="country_id" class="form-label">
            {{ __('center::text.country') }}
            @if($countryRequired) <span class="text-danger">*</span> @endif
        </label>
        <select
            {{ $submitCountryId ? 'name="country_id"' : '' }}
            id="country_id"
            class="form-select select2"
            {{ $countryRequired ? 'required' : '' }}
        >
            <option value="">-- Select Country --</option>
            @foreach($countries as $id => $name)
                <option value="{{ $id }}" {{ (string)$selectedCountryId === (string)$id ? 'selected' : '' }}>
                    {{ $name }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="{{ $colState }} mb-3">
    <div class="form-group">
        <label for="state_id" class="form-label">
            {{ __('center::text.state') }}
            @if($stateRequired) <span class="text-danger">*</span> @endif
        </label>
        <select
            name="state_id"
            id="state_id"
            class="form-select select2"
            {{ $stateRequired ? 'required' : '' }}
            {{ empty($preloadedStates) ? 'disabled' : '' }}
        >
            <option value="">-- Select State --</option>
            @foreach($preloadedStates as $id => $name)
                <option value="{{ $id }}" {{ (string)$selectedStateId === (string)$id ? 'selected' : '' }}>
                    {{ $name }}
                </option>
            @endforeach
        </select>
        <small class="text-muted" id="state_hint">
            @if(empty($preloadedStates) && !$selectedCountryId) Select a country first @endif
        </small>
    </div>
</div>

@push('after-scripts')
<script>
(function () {
    // Guard: only init once even if component is included multiple times
    if (window._countryStateInitialized) return;
    window._countryStateInitialized = true;

    const STATES_URL = '{{ rtrim(route("backend.ajax.states_by_country", ["country_id" => 0]), "0") }}';

    function loadStates(countryId, selectedStateId) {
        const $state     = $('#state_id');
        const $stateHint = $('#state_hint');

        if (!countryId) {
            $state.empty()
                  .append('<option value="">-- Select State --</option>')
                  .prop('disabled', true)
                  .trigger('change.select2');
            $stateHint.text('Select a country first');
            return;
        }

        $state.prop('disabled', true);
        $stateHint.html('<i class="ti ti-loader-2"></i> Loading...');

        $.getJSON(STATES_URL + countryId, function (data) {
            $state.empty().append('<option value="">-- Select State --</option>');

            if (data.length === 0) {
                $stateHint.text('No states available for this country');
                $state.prop('disabled', true);
            } else {
                $.each(data, function (i, item) {
                    const sel = (selectedStateId && String(item.id) === String(selectedStateId)) ? ' selected' : '';
                    $state.append('<option value="' + item.id + '"' + sel + '>' + item.name + '</option>');
                });
                $state.prop('disabled', false);
                $stateHint.text('');
            }

            $state.trigger('change.select2');
        }).fail(function () {
            $stateHint.text('Failed to load states. Please try again.');
            $state.prop('disabled', true);
        });
    }

    $(document).ready(function () {
        // When country changes, reload states
        $(document).on('change', '#country_id', function () {
            loadStates($(this).val(), null);
        });

        // On page load: if a country is already selected (edit mode), load its states
        const initialCountry = $('#country_id').val();
        const initialState   = $('#state_id').val();
        if (initialCountry && $('#state_id option').length <= 1) {
            // States not pre-loaded (e.g. JS-only render) — fetch them
            loadStates(initialCountry, initialState);
        }
    });
}());
</script>
@endpush
