<div class="row">

    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">

            @php
                $field_name = 'name';
                $field_lable = label_case($field_name);
                $field_placeholder = $field_lable;
                $required = 'required';
            @endphp

            <label
                for="{{ $field_name }}"
                class="form-label"
            >
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
                $field_name = 'slug';
                $field_lable = label_case($field_name);
                $field_placeholder = $field_lable;
                $required = '';
            @endphp

            <label
                for="{{ $field_name }}"
                class="form-label"
            >
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
                $field_name = 'status';
                $field_lable = label_case($field_name);
                $required = 'required';

                $select_options = [
                    '1' => 'Published',
                    '0' => 'Unpublished',
                    '2' => 'Draft',
                ];
            @endphp

            <label
                for="{{ $field_name }}"
                class="form-label"
            >
                {{ $field_lable }}
            </label>

            {!! field_required($required) !!}

            <select
                name="{{ $field_name }}"
                id="{{ $field_name }}"
                class="form-select"
                {{ $required }}
            >

                <option value="">
                    -- Select an option --
                </option>

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

<div class="row">

    <div class="col-12 mb-3">
        <div class="form-group">

            @php
                $field_name = 'note';
                $field_lable = label_case($field_name);
                $field_placeholder = $field_lable;
                $required = '';
            @endphp

            <label
                for="{{ $field_name }}"
                class="form-label"
            >
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

<x-library.select2 />