{{-- ── Row 1: Name / Email / Status ───────────────────────────── --}}
<div class="row">
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <label for="name" class="form-label">@lang('student::text.name')</label>
            {!! field_required('required') !!}

            <input type="text"
                   name="name"
                   id="name"
                   class="form-control"
                   placeholder="@lang('student::text.name')"
                   required
                   value="{{ old('name', $data->name ?? '') }}">
        </div>
    </div>

    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <label for="email" class="form-label">@lang('student::text.email')</label>
            {!! field_required('required') !!}

            <input type="email"
                   name="email"
                   id="email"
                   class="form-control"
                   placeholder="@lang('student::text.email')"
                   required
                   value="{{ old('email', $data->email ?? '') }}">
        </div>
    </div>

    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <label for="status" class="form-label">@lang('student::text.status')</label>
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
            <label for="mobile" class="form-label">@lang('student::text.mobile')</label>

            <input type="text"
                   name="mobile"
                   id="mobile"
                   class="form-control"
                   maxlength="20"
                   placeholder="@lang('student::text.mobile')"
                   value="{{ old('mobile', $data->mobile ?? '') }}">
        </div>
    </div>

    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <label for="gender" class="form-label">@lang('student::text.gender')</label>

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
            <label for="date_of_birth" class="form-label">@lang('student::text.date_of_birth')</label>

            <input type="date"
                   name="date_of_birth"
                   id="date_of_birth"
                   class="form-control"
                   value="{{ old('date_of_birth', isset($data->date_of_birth) ? $data->date_of_birth?->format('Y-m-d') : '') }}">
        </div>
    </div>
</div>

{{-- ── Row 3: Enrollment No. / Course / Batch ─────────────────── --}}
<div class="row">
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <label for="enrollment_number" class="form-label">@lang('student::text.enrollment_number')</label>

            <input type="text"
                   name="enrollment_number"
                   id="enrollment_number"
                   class="form-control"
                   placeholder="@lang('student::text.enrollment_number')"
                   value="{{ old('enrollment_number', $data->enrollment_number ?? '') }}">
        </div>
    </div>

    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <label for="course" class="form-label">@lang('student::text.course')</label>

            <input type="text"
                   name="course"
                   id="course"
                   class="form-control"
                   placeholder="@lang('student::text.course')"
                   value="{{ old('course', $data->course ?? '') }}">
        </div>
    </div>

    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <label for="batch" class="form-label">@lang('student::text.batch')</label>

            <input type="text"
                   name="batch"
                   id="batch"
                   class="form-control"
                   placeholder="@lang('student::text.batch')"
                   value="{{ old('batch', $data->batch ?? '') }}">
        </div>
    </div>
</div>

{{-- ── Row 4: Address ─────────────────────────────────────────── --}}
<div class="row">
    <div class="col-12 mb-3">
        <div class="form-group">
            <label for="address" class="form-label">@lang('student::text.address')</label>

            <textarea name="address"
                      id="address"
                      rows="2"
                      class="form-control"
                      placeholder="@lang('student::text.address')">{{ old('address', $data->address ?? '') }}</textarea>
        </div>
    </div>
</div>

@empty($data)
    <div class="alert alert-info">
        <i class="ti ti-info-circle"></i>
        A random password is generated automatically. The student should use the password-reset flow to set their own.
    </div>
@endempty

<x-library.select2 />