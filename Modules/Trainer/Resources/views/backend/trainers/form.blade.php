{{-- ── Row 1: Name / Email / Status ───────────────────────────── --}}
<div class="row">
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <label for="name" class="form-label">@lang('trainer::text.name')</label>
            {!! field_required('required') !!}

            <input type="text"
                   name="name"
                   id="name"
                   class="form-control"
                   placeholder="@lang('trainer::text.name')"
                   required
                   value="{{ old('name', $data->name ?? '') }}">
        </div>
    </div>

    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <label for="email" class="form-label">@lang('trainer::text.email')</label>
            {!! field_required('required') !!}

            <input type="email"
                   name="email"
                   id="email"
                   class="form-control"
                   placeholder="@lang('trainer::text.email')"
                   required
                   value="{{ old('email', $data->email ?? '') }}">
        </div>
    </div>

    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <label for="status" class="form-label">@lang('trainer::text.status')</label>
            {!! field_required('required') !!}

            <select name="status" id="status" class="form-select select2" required>
                <option value="">-- Select --</option>
                <option value="1" {{ old('status', $data->status ?? '1') == '1' ? 'selected' : '' }}>Active</option>
                <option value="0" {{ old('status', $data->status ?? '') == '0' ? 'selected' : '' }}>Inactive</option>
                <option value="2" {{ old('status', $data->status ?? '') == '2' ? 'selected' : '' }}>Pending</option>
            </select>
        </div>
    </div>
</div>

{{-- ── Row 2: Mobile / Gender / Date of Birth ─────────────────── --}}
<div class="row">
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <label for="mobile" class="form-label">@lang('trainer::text.mobile')</label>

            <input type="text"
                   name="mobile"
                   id="mobile"
                   class="form-control"
                   maxlength="20"
                   placeholder="@lang('trainer::text.mobile')"
                   value="{{ old('mobile', $data->mobile ?? '') }}">
        </div>
    </div>

    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <label for="gender" class="form-label">@lang('trainer::text.gender')</label>

            <select name="gender" id="gender" class="form-select select2">
                <option value="">-- Select --</option>
                <option value="male" {{ old('gender', $data->gender ?? '') == 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ old('gender', $data->gender ?? '') == 'female' ? 'selected' : '' }}>Female</option>
                <option value="other" {{ old('gender', $data->gender ?? '') == 'other' ? 'selected' : '' }}>Other</option>
            </select>
        </div>
    </div>

    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <label for="date_of_birth" class="form-label">@lang('trainer::text.date_of_birth')</label>

            <input type="date"
                   name="date_of_birth"
                   id="date_of_birth"
                   class="form-control"
                   value="{{ old('date_of_birth', isset($data->date_of_birth) ? $data->date_of_birth?->format('Y-m-d') : '') }}">
        </div>
    </div>
</div>

{{-- ── Row 3: Specialization / Qualification / Experience ─────── --}}
<div class="row">
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <label for="specialization" class="form-label">@lang('trainer::text.specialization')</label>

            <input type="text"
                   name="specialization"
                   id="specialization"
                   class="form-control"
                   placeholder="@lang('trainer::text.specialization')"
                   value="{{ old('specialization', $data->specialization ?? '') }}">
        </div>
    </div>

    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <label for="qualification" class="form-label">@lang('trainer::text.qualification')</label>

            <input type="text"
                   name="qualification"
                   id="qualification"
                   class="form-control"
                   placeholder="@lang('trainer::text.qualification')"
                   value="{{ old('qualification', $data->qualification ?? '') }}">
        </div>
    </div>

    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <label for="experience_years" class="form-label">@lang('trainer::text.experience_years')</label>

            <input type="number"
                   name="experience_years"
                   id="experience_years"
                   class="form-control"
                   min="0"
                   max="80"
                   placeholder="0"
                   value="{{ old('experience_years', $data->experience_years ?? '') }}">
        </div>
    </div>
</div>

{{-- ── Row 4: Address / Bio ───────────────────────────────────── --}}
<div class="row">
    <div class="col-12 col-sm-6 mb-3">
        <div class="form-group">
            <label for="address" class="form-label">@lang('trainer::text.address')</label>

            <textarea name="address"
                      id="address"
                      rows="3"
                      class="form-control"
                      placeholder="@lang('trainer::text.address')">{{ old('address', $data->address ?? '') }}</textarea>
        </div>
    </div>

    <div class="col-12 col-sm-6 mb-3">
        <div class="form-group">
            <label for="bio" class="form-label">@lang('trainer::text.bio')</label>

            <textarea name="bio"
                      id="bio"
                      rows="3"
                      class="form-control"
                      placeholder="@lang('trainer::text.bio')">{{ old('bio', $data->bio ?? '') }}</textarea>
        </div>
    </div>
</div>

@empty($data)
    <div class="alert alert-info">
        <i class="ti ti-info-circle"></i>
        A random password is generated automatically. The trainer should use the password-reset flow to set their own.
    </div>
@endempty

<x-library.select2 />
