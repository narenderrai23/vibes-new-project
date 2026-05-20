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
                   value="{{ old('name', $regional->name ?? '') }}">
        </div>
    </div>

    <div class="col-12 col-sm-3 mb-3">
        <div class="form-group">
            <label for="slug" class="form-label">
                {{ label_case('slug') }}
            </label>

            <input type="text"
                   name="slug"
                   id="slug"
                   placeholder="{{ label_case('slug') }}"
                   class="form-control"
                   value="{{ old('slug', $regional->slug ?? '') }}">
        </div>
    </div>

    <div class="col-12 col-sm-2 mb-3">
        <div class="form-group">
            <label for="code" class="form-label">
                {{ __('center::text.code') }}
            </label>

            <input type="text"
                   name="code"
                   id="code"
                   placeholder="e.g. NORTH"
                   class="form-control"
                   value="{{ old('code', $regional->code ?? '') }}">
        </div>
    </div>

    <div class="col-12 col-sm-2 mb-3">
        <div class="form-group">
            <label for="status" class="form-label">
                {{ label_case('status') }}
            </label>
            {!! field_required('required') !!}

            <select name="status"
                    id="status"
                    class="form-select select2"
                    required>
                <option value="">-- Select --</option>

                <option value="1"
                    {{ old('status', $regional->status ?? '') == '1' ? 'selected' : '' }}>
                    Active
                </option>

                <option value="0"
                    {{ old('status', $regional->status ?? '') == '0' ? 'selected' : '' }}>
                    Inactive
                </option>

                <option value="2"
                    {{ old('status', $regional->status ?? '') == '2' ? 'selected' : '' }}>
                    Pending
                </option>
            </select>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-sm-6 mb-3">
        <div class="form-group">
            <label for="center_id" class="form-label">
                {{ __('center::text.head_center') }}
            </label>

            <select name="center_id"
                    id="center_id"
                    class="form-select select2">
                <option value="">-- Select Head Center --</option>

                @foreach(\Modules\Center\Models\Center::orderBy('name')->get() as $centerOption)
                    <option value="{{ $centerOption->id }}"
                        {{ old('center_id', $regional->center_id ?? '') == $centerOption->id ? 'selected' : '' }}>
                        {{ $centerOption->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-12 col-sm-6 mb-3">
        <div class="form-group">
            <label for="description" class="form-label">
                {{ label_case('description') }}
            </label>

            <textarea name="description"
                      id="description"
                      rows="2"
                      placeholder="{{ label_case('description') }}"
                      class="form-control">{{ old('description', $regional->description ?? '') }}</textarea>
        </div>
    </div>
</div>

<x-library.select2 />