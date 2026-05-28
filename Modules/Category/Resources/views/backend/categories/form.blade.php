<div class="row mb-3">
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            @php
                $field_name = "name";
                $field_lable = label_case($field_name);
                $field_placeholder = $field_lable;
                $required = "required";
            @endphp

            <label for="{{ $field_name }}" class="form-label">
                {{ $field_lable }}
            </label>
            {!! field_required($required) !!}

            <input
                type="text"
                name="{{ $field_name }}"
                id="{{ $field_name }}"
                class="form-control"
                placeholder="{{ $field_placeholder }}"
                value="{{ old($field_name, $data->$field_name ?? '') }}"
                {{ $required }}
            >
        </div>
    </div>

    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            @php
                $field_name = "slug";
                $field_lable = label_case($field_name);
                $field_placeholder = $field_lable;
                $required = "";
            @endphp

            <label for="{{ $field_name }}" class="form-label">
                {{ $field_lable }}
            </label>
            {!! field_required($required) !!}

            <input
                type="text"
                name="{{ $field_name }}"
                id="{{ $field_name }}"
                class="form-control"
                placeholder="{{ $field_placeholder }}"
                value="{{ old($field_name, $data->$field_name ?? '') }}"
            >
        </div>
    </div>

    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            @php
                $field_name = "group_name";
                $field_lable = label_case($field_name);
                $field_placeholder = $field_lable;
                $required = "";
            @endphp

            <label for="{{ $field_name }}" class="form-label">
                {{ $field_lable }}
            </label>
            {!! field_required($required) !!}

            <input
                type="text"
                name="{{ $field_name }}"
                id="{{ $field_name }}"
                class="form-control"
                placeholder="{{ $field_placeholder }}"
                value="{{ old($field_name, $data->$field_name ?? '') }}"
            >
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-8">
        <div class="form-group">
            @php
                $field_name = "image";
                $field_lable = label_case($field_name);
                $required = "";
            @endphp

            <label for="{{ $field_name }}" class="form-label">
                {{ $field_lable }}
            </label>
            {!! field_required($required) !!}

            <input
                type="file"
                name="{{ $field_name }}"
                id="{{ $field_name }}"
                class="form-control"
            >
        </div>
    </div>

    @if ($data && $data->getMedia($module_name)->first())
        <div class="col-4">
            <div class="float-end">
                <figure class="figure">
                    <a
                        href="{{ asset($data->$field_name) }}"
                        data-lightbox="image-set"
                        data-title="Path: {{ asset($data->$field_name) }}"
                    >
                        <img
                            src="{{ asset($data->getMedia($module_name)->first()->getUrl('thumb300')) }}"
                            class="figure-img img-fluid img-thumbnail rounded"
                            alt=""
                        >
                    </a>
                </figure>

                <div class="form-check">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        value="image_remove"
                        id="image_remove"
                        name="image_remove"
                    >

                    <label class="form-check-label" for="image_remove">
                        Remove this image
                    </label>
                </div>
            </div>
        </div>

        <x-library.lightbox />
    @endif
</div>

<div class="row">
    <div class="col-12 mb-3">
        <div class="form-group">
            @php
                $field_name = "description";
                $field_lable = label_case($field_name);
                $field_placeholder = $field_lable;
                $required = "";
            @endphp

            <label for="{{ $field_name }}" class="form-label">
                {{ $field_lable }}
            </label>
            {!! field_required($required) !!}

            <textarea
                name="{{ $field_name }}"
                id="{{ $field_name }}"
                class="form-control"
                placeholder="{{ $field_placeholder }}"
            >{{ old($field_name, $data->$field_name ?? '') }}</textarea>
        </div>
    </div>
</div>

<hr />

<div class="row">
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            @php
                $field_name = "meta_title";
                $field_lable = label_case($field_name);
                $field_placeholder = $field_lable;
                $required = "";
            @endphp

            <label for="{{ $field_name }}" class="form-label">
                {{ $field_lable }}
            </label>
            {!! field_required($required) !!}

            <input
                type="text"
                name="{{ $field_name }}"
                id="{{ $field_name }}"
                class="form-control"
                placeholder="{{ $field_placeholder }}"
                value="{{ old($field_name, $data->$field_name ?? '') }}"
            >
        </div>
    </div>

    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            @php
                $field_name = "meta_keyword";
                $field_lable = label_case($field_name);
                $field_placeholder = $field_lable;
                $required = "";
            @endphp

            <label for="{{ $field_name }}" class="form-label">
                {{ $field_lable }}
            </label>
            {!! field_required($required) !!}

            <input
                type="text"
                name="{{ $field_name }}"
                id="{{ $field_name }}"
                class="form-control"
                placeholder="{{ $field_placeholder }}"
                value="{{ old($field_name, $data->$field_name ?? '') }}"
            >
        </div>
    </div>

    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            @php
                $field_name = "meta_description";
                $field_lable = label_case($field_name);
                $field_placeholder = $field_lable;
                $required = "";
            @endphp

            <label for="{{ $field_name }}" class="form-label">
                {{ $field_lable }}
            </label>
            {!! field_required($required) !!}

            <input
                type="text"
                name="{{ $field_name }}"
                id="{{ $field_name }}"
                class="form-control"
                placeholder="{{ $field_placeholder }}"
                value="{{ old($field_name, $data->$field_name ?? '') }}"
            >
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12 col-sm-4">
        <div class="form-group">
            @php
                $field_name = "status";
                $field_lable = label_case($field_name);
                $required = "required";
                $select_options = \Modules\Category\Enums\CategoryStatus::toArray();
            @endphp

            <label for="{{ $field_name }}" class="form-label">
                {{ $field_lable }}
            </label>
            {!! field_required($required) !!}

            <select
                name="{{ $field_name }}"
                id="{{ $field_name }}"
                class="form-select"
                {{ $required }}
            >
                <option value="">-- Select an option --</option>

                @foreach ($select_options as $key => $value)
                    <option
                        value="{{ $key }}"
                        {{ old($field_name, $data->$field_name ?? '') == $key ? 'selected' : '' }}
                    >
                        {{ $value }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>