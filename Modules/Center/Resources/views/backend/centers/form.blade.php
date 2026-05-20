{{-- ── Row 1: Center Code / Center Name / Status ───────────────── --}}
<div class="row">
    <div class="col-12 col-sm-3 mb-3">
        <div class="form-group">
            <label for="code" class="form-label">
                {{ __('center::text.code') }}
            </label>
            {!! field_required('required') !!}

            <input type="text"
                   name="code"
                   id="code"
                   placeholder="e.g. IDEWE"
                   class="form-control"
                   style="text-transform: uppercase"
                   required
                   value="{{ old('code', $center->code ?? '') }}">
        </div>
    </div>

    <div class="col-12 col-sm-6 mb-3">
        <div class="form-group">
            <label for="name" class="form-label">
                {{ __('center::text.name') }}
            </label>
            {!! field_required('required') !!}

            <input type="text"
                   name="name"
                   id="name"
                   placeholder="{{ __('center::text.name') }}"
                   class="form-control"
                   required
                   value="{{ old('name', $center->name ?? '') }}">
        </div>
    </div>

    <div class="col-12 col-sm-3 mb-3">
        <div class="form-group">
            <label for="status" class="form-label">
                {{ __('center::text.status') }}
            </label>
            {!! field_required('required') !!}

            <select name="status"
                    id="status"
                    class="form-select select2"
                    required>
                <option value="">-- Select --</option>
                <option value="1" {{ old('status', $center->status ?? '') == '1' ? 'selected' : '' }}>
                    Active
                </option>
                <option value="0" {{ old('status', $center->status ?? '') == '0' ? 'selected' : '' }}>
                    Inactive
                </option>
                <option value="2" {{ old('status', $center->status ?? '') == '2' ? 'selected' : '' }}>
                    Pending
                </option>
            </select>
        </div>
    </div>
</div>

{{-- ── Row 2: Mobile / Alt Mobile / Email / GST ───────────────── --}}
<div class="row">
    <div class="col-12 col-sm-3 mb-3">
        <div class="form-group">
            <label for="mobile" class="form-label">
                {{ __('center::text.mobile') }}
            </label>
            {!! field_required('required') !!}

            <input type="text"
                   name="mobile"
                   id="mobile"
                   placeholder="{{ __('center::text.mobile') }}"
                   class="form-control"
                   maxlength="15"
                   required
                   value="{{ old('mobile', $center->mobile ?? '') }}">
        </div>
    </div>

    <div class="col-12 col-sm-3 mb-3">
        <div class="form-group">
            <label for="mobile_alt" class="form-label">
                {{ __('center::text.mobile_alt') }}
            </label>

            <input type="text"
                   name="mobile_alt"
                   id="mobile_alt"
                   placeholder="{{ __('center::text.mobile_alt') }}"
                   class="form-control"
                   maxlength="15"
                   value="{{ old('mobile_alt', $center->mobile_alt ?? '') }}">
        </div>
    </div>

    <div class="col-12 col-sm-3 mb-3">
        <div class="form-group">
            <label for="email" class="form-label">
                {{ __('center::text.email') }}
            </label>

            <input type="email"
                   name="email"
                   id="email"
                   placeholder="{{ __('center::text.email') }}"
                   class="form-control"
                   value="{{ old('email', $center->email ?? '') }}">
        </div>
    </div>

    <div class="col-12 col-sm-3 mb-3">
        <div class="form-group">
            <label for="gst_no" class="form-label">
                {{ __('center::text.gst_no') }}
            </label>

            <input type="text"
                   name="gst_no"
                   id="gst_no"
                   placeholder="e.g. 22AAAAA0000A1Z5"
                   class="form-control"
                   maxlength="15"
                   style="text-transform: uppercase"
                   value="{{ old('gst_no', $center->gst_no ?? '') }}">
        </div>
    </div>
</div>

{{-- ── Row 3: Country / State / Regional ───────────────────────── --}}
<div class="row">
    <x-library.country-state
        :selectedCountryId="$center?->state?->country_id ?? old('country_id')"
        :selectedStateId="$center?->state_id ?? old('state_id')"
        :stateRequired="true"
        colCountry="col-12 col-sm-4"
        colState="col-12 col-sm-4"
        :submitCountryId="false"
    />

    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <label for="regional_id" class="form-label">
                {{ __('center::text.regional') }}
            </label>

            <select name="regional_id"
                    id="regional_id"
                    class="form-select select2">
                <option value="">-- Select Regional --</option>

                @foreach(\Modules\Center\Models\Regional::orderBy('name')->get() as $regional)
                    <option value="{{ $regional->id }}"
                        {{ old('regional_id', $center->regional_id ?? '') == $regional->id ? 'selected' : '' }}>
                        {{ $regional->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>

{{-- ── Row 4: City / Address / Google Maps Link ───────────────── --}}
<div class="row">
    <div class="col-12 col-sm-3 mb-3">
        <div class="form-group">
            <label for="city" class="form-label">
                {{ __('center::text.city') }}
            </label>

            <input type="text"
                   name="city"
                   id="city"
                   placeholder="{{ __('center::text.city') }}"
                   class="form-control"
                   value="{{ old('city', $center->city ?? '') }}">
        </div>
    </div>

    <div class="col-12 col-sm-5 mb-3">
        <div class="form-group">
            <label for="address" class="form-label">
                {{ __('center::text.address') }}
            </label>

            <textarea name="address"
                      id="address"
                      rows="2"
                      placeholder="{{ __('center::text.address') }}"
                      class="form-control">{{ old('address', $center->address ?? '') }}</textarea>
        </div>
    </div>

    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <label for="google_link" class="form-label">
                {{ __('center::text.google_link') }}
            </label>

            <div class="input-group">
                <input type="url"
                       name="google_link"
                       id="google_link"
                       placeholder="https://maps.google.com/..."
                       class="form-control"
                       value="{{ old('google_link', $center->google_link ?? '') }}">

                @if(isset($center) && $center->google_link)
                    <a href="{{ $center->google_link }}"
                       target="_blank"
                       class="btn btn-outline-secondary"
                       title="Open in Google Maps">
                        <i class="ti ti-map-pin"></i>
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

<x-library.select2 />