<div class="row">
    <div class="col-12 col-sm-6 mb-3">
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
                   value="{{ old('name', $country->name ?? '') }}">
        </div>
    </div>

    <div class="col-12 col-sm-3 mb-3">
        <div class="form-group">
            <label for="iso2" class="form-label">
                ISO2 Code
            </label>

            <input type="text"
                   name="iso2"
                   id="iso2"
                   placeholder="e.g. IN"
                   class="form-control"
                   maxlength="2"
                   value="{{ old('iso2', $country->iso2 ?? '') }}">
        </div>
    </div>

    <div class="col-12 col-sm-3 mb-3">
        <div class="form-group">
            <label for="iso3" class="form-label">
                ISO3 Code
            </label>

            <input type="text"
                   name="iso3"
                   id="iso3"
                   placeholder="e.g. IND"
                   class="form-control"
                   maxlength="3"
                   value="{{ old('iso3', $country->iso3 ?? '') }}">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <label for="phonecode" class="form-label">
                Phone Code
            </label>

            <input type="text"
                   name="phonecode"
                   id="phonecode"
                   placeholder="e.g. 91"
                   class="form-control"
                   value="{{ old('phonecode', $country->phonecode ?? '') }}">
        </div>
    </div>

    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <label for="currency" class="form-label">
                Currency
            </label>

            <input type="text"
                   name="currency"
                   id="currency"
                   placeholder="e.g. INR"
                   class="form-control"
                   value="{{ old('currency', $country->currency ?? '') }}">
        </div>
    </div>
</div>