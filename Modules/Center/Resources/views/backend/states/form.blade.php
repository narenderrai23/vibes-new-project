<div class="row">
    <div class="col-12 col-sm-5 mb-3">
        <div class="form-group">
            <label for="name" class="form-label">
                {{ label_case('name') }}
            </label>
            {!! field_required('required') !!}

            <input type="text"
                   name="name"
                   id="name"
                   placeholder="{{ label_case('name') }}"
                   class="form-control"
                   required
                   value="{{ old('name', $state->name ?? '') }}">
        </div>
    </div>

    <div class="col-12 col-sm-3 mb-3">
        <div class="form-group">
            <label for="state_code" class="form-label">
                {{ __('center::text.state_code') }}
            </label>

            <input type="text"
                   name="state_code"
                   id="state_code"
                   placeholder="e.g. MH"
                   class="form-control"
                   value="{{ old('state_code', $state->state_code ?? '') }}">
        </div>
    </div>

    {{-- Country dropdown --}}
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <label for="country_id" class="form-label">
                {{ __('center::text.country') }}
            </label>
            {!! field_required('required') !!}

            <select name="country_id"
                    id="country_id"
                    class="form-select select2"
                    required>

                <option value="">-- Select Country --</option>

                @foreach(\Modules\Center\Models\Country::orderBy('name')->get() as $country)
                    <option value="{{ $country->id }}"
                        {{ old('country_id', $state->country_id ?? '') == $country->id ? 'selected' : '' }}>
                        {{ $country->name }}
                    </option>
                @endforeach

            </select>
        </div>
    </div>
</div>

<x-library.select2 />