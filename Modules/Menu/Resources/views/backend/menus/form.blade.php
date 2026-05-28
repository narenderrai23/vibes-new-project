{{-- Basic Information --}}
<div class="row">
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            @php
                $field_name = 'name';
                $field_lable = label_case($field_name);
                $field_placeholder = 'e.g., Header Menu, Footer Menu';
                $required = 'required';
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
                $field_name = 'slug';
                $field_lable = label_case($field_name);
                $field_placeholder = 'e.g., header-menu, footer-menu';
                $required = '';
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
                $field_name = 'location';
                $field_lable = label_case($field_name);
                $required = 'required';

                $select_options = [
                    'frontend-header' => 'Frontend Header',
                    'frontend-footer' => 'Frontend Footer',
                    'admin-sidebar' => 'Admin Sidebar',
                ];
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
                <option value="">-- Select location --</option>

                @foreach($select_options as $key => $value)
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
    <div class="col-12 col-sm-6 mb-3">
        <div class="form-group">
            @php
                $field_name = 'description';
                $field_lable = label_case($field_name);
                $field_placeholder = 'Brief description of this menu';
                $required = '';
            @endphp

            <label for="{{ $field_name }}" class="form-label">
                {{ $field_lable }}
            </label>
            {!! field_required($required) !!}

            <textarea
                name="{{ $field_name }}"
                id="{{ $field_name }}"
                rows="3"
                class="form-control"
                placeholder="{{ $field_placeholder }}"
            >{{ old($field_name, $data->$field_name ?? '') }}</textarea>
        </div>
    </div>

    <div class="col-12 col-sm-6 mb-3">
        <div class="form-group">
            @php
                $field_name = 'note';
                $field_lable = 'Admin Notes';
                $field_placeholder = 'Internal notes for administrators';
                $required = '';
            @endphp

            <label for="{{ $field_name }}" class="form-label">
                {{ $field_lable }}
            </label>
            {!! field_required($required) !!}

            <textarea
                name="{{ $field_name }}"
                id="{{ $field_name }}"
                rows="3"
                class="form-control"
                placeholder="{{ $field_placeholder }}"
            >{{ old($field_name, $data->$field_name ?? '') }}</textarea>
        </div>
    </div>
</div>

{{-- Display & Theme --}}
<div class="row">
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            @php
                $field_name = 'theme';
                $field_lable = label_case($field_name);
                $required = '';

                $select_options = [
                    'default' => 'Default',
                    'bootstrap' => 'Bootstrap',
                    'minimal' => 'Minimal',
                    'dark' => 'Dark Theme',
                    'custom' => 'Custom'
                ];
            @endphp

            <label for="{{ $field_name }}" class="form-label">
                {{ $field_lable }}
            </label>
            {!! field_required($required) !!}

            <select
                name="{{ $field_name }}"
                id="{{ $field_name }}"
                class="form-select"
            >
                <option value="">-- Select theme --</option>

                @foreach($select_options as $key => $value)
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

    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            @php
                $field_name = 'css_classes';
                $field_lable = 'CSS Classes';
                $field_placeholder = 'e.g., navbar navbar-expand-lg';
                $required = '';
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
                $field_name = 'locale';
                $field_lable = label_case($field_name);
                $required = '';

                $select_options = [
                    'en' => 'English',
                    'es' => 'Spanish',
                    'fr' => 'French',
                    'de' => 'German',
                    'ar' => 'Arabic',
                    'hi' => 'Hindi'
                ];
            @endphp

            <label for="{{ $field_name }}" class="form-label">
                {{ $field_lable }}
            </label>
            {!! field_required($required) !!}

            <select
                name="{{ $field_name }}"
                id="{{ $field_name }}"
                class="form-select"
            >
                <option value="">-- Select language --</option>

                @foreach($select_options as $key => $value)
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

{{-- Access Control --}}
<div class="row">
    <div class="col-12 mb-3">
        <h5>Access Control</h5>
    </div>

    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            @php
                $field_name = 'is_public';
                $field_lable = 'Public Menu';
                $required = '';

                $select_options = [
                    '1' => 'Yes - Allow guests to see this menu',
                    '0' => 'No - Require authentication'
                ];
            @endphp

            <label for="{{ $field_name }}" class="form-label">
                {{ $field_lable }}
            </label>
            {!! field_required($required) !!}

            <select
                name="{{ $field_name }}"
                id="{{ $field_name }}"
                class="form-select"
            >
                <option value="">-- Select visibility --</option>

                @foreach($select_options as $key => $value)
                    <option
                        value="{{ $key }}"
                        {{ old($field_name, $data->$field_name ?? '') == $key ? 'selected' : '' }}
                    >
                        {{ $value }}
                    </option>
                @endforeach
            </select>

            <small class="form-text text-muted">
                Control guest access to this menu
            </small>
        </div>
    </div>

    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            @php
                $field_name = 'permissions';
                $field_lable = 'Required Permissions';
                $required = '';

                $select_options = [
                    'view_backend' => 'View Backend',
                    'edit_content' => 'Edit Content',
                    'manage_users' => 'Manage Users',
                    'manage_settings' => 'Manage Settings'
                ];

                $selected_permissions = old(
                    $field_name,
                    $data->$field_name ?? []
                );
            @endphp

            <label for="{{ $field_name }}" class="form-label">
                {{ $field_lable }}
            </label>
            {!! field_required($required) !!}

            <select
                name="{{ $field_name }}[]"
                id="{{ $field_name }}"
                class="form-select select2-permissions"
                multiple
            >
                @foreach($select_options as $key => $value)
                    <option
                        value="{{ $key }}"
                        {{ in_array($key, (array) $selected_permissions) ? 'selected' : '' }}
                    >
                        {{ $value }}
                    </option>
                @endforeach
            </select>

            <small class="form-text text-muted">
                Users must have these permissions to see the menu
            </small>
        </div>
    </div>

    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            @php
                $field_name = 'roles';
                $field_lable = 'Required Roles';
                $required = '';

                $select_options = [
                    'super admin' => 'Super Admin',
                    'admin' => 'Admin',
                    'editor' => 'Editor',
                    'user' => 'User'
                ];

                $selected_roles = old(
                    $field_name,
                    $data->$field_name ?? []
                );
            @endphp

            <label for="{{ $field_name }}" class="form-label">
                {{ $field_lable }}
            </label>
            {!! field_required($required) !!}

            <select
                name="{{ $field_name }}[]"
                id="{{ $field_name }}"
                class="form-select select2-roles"
                multiple
            >
                @foreach($select_options as $key => $value)
                    <option
                        value="{{ $key }}"
                        {{ in_array($key, (array) $selected_roles) ? 'selected' : '' }}
                    >
                        {{ $value }}
                    </option>
                @endforeach
            </select>

            <small class="form-text text-muted">
                Users must have one of these roles to see the menu
            </small>
        </div>
    </div>
</div>

{{-- Status & Visibility --}}
<div class="row">
    <div class="col-12 mb-3">
        <h5>Status & Visibility</h5>
    </div>

    <div class="col-12 col-sm-3 mb-3">
        <div class="form-group">
            @php
                $field_name = 'status';
                $field_lable = label_case($field_name);
                $required = 'required';

                $select_options = [
                    '1' => 'Published',
                    '0' => 'Disabled',
                    '2' => 'Draft'
                ];
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
                <option value="">-- Select status --</option>

                @foreach($select_options as $key => $value)
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

    <div class="col-12 col-sm-3 mb-3">
        <div class="form-group">
            @php
                $field_name = 'is_active';
                $field_lable = 'Active Status';
                $required = '';

                $select_options = [
                    '1' => 'Yes - Menu is active',
                    '0' => 'No - Menu is inactive'
                ];
            @endphp

            <label for="{{ $field_name }}" class="form-label">
                {{ $field_lable }}
            </label>
            {!! field_required($required) !!}

            <select
                name="{{ $field_name }}"
                id="{{ $field_name }}"
                class="form-select"
            >
                <option value="">-- Select status --</option>

                @foreach($select_options as $key => $value)
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

    <div class="col-12 col-sm-3 mb-3">
        <div class="form-group">
            @php
                $field_name = 'is_visible';
                $field_lable = 'Visibility';
                $required = '';

                $select_options = [
                    '1' => 'Yes - Menu is visible',
                    '0' => 'No - Menu is hidden'
                ];
            @endphp

            <label for="{{ $field_name }}" class="form-label">
                {{ $field_lable }}
            </label>
            {!! field_required($required) !!}

            <select
                name="{{ $field_name }}"
                id="{{ $field_name }}"
                class="form-select"
            >
                <option value="">-- Select visibility --</option>

                @foreach($select_options as $key => $value)
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

{{-- Menu Settings (JSON) --}}
<div class="row">
    <div class="col-12 mb-3">
        <h5>Advanced Settings</h5>
    </div>

    <div class="col-12 col-sm-6 mb-3">
        <div class="form-group">
            @php
                $field_name = 'settings[max_depth]';
                $field_lable = 'Maximum Depth';
                $field_placeholder = '3';
                $required = '';
            @endphp

            <label for="settings_max_depth" class="form-label">
                {{ $field_lable }}
            </label>
            {!! field_required($required) !!}

            <input
                type="number"
                name="{{ $field_name }}"
                id="settings_max_depth"
                class="form-control"
                placeholder="{{ $field_placeholder }}"
                min="1"
                max="10"
                value="{{ old('settings.max_depth', $data->settings['max_depth'] ?? '') }}"
            >

            <small class="form-text text-muted">
                Maximum nesting level for menu items
            </small>
        </div>
    </div>

    <div class="col-12 col-sm-6 mb-3">
        <div class="form-group">
            @php
                $field_name = 'settings[cache_duration]';
                $field_lable = 'Cache Duration (minutes)';
                $field_placeholder = '60';
                $required = '';
            @endphp

            <label for="settings_cache_duration" class="form-label">
                {{ $field_lable }}
            </label>
            {!! field_required($required) !!}

            <input
                type="number"
                name="{{ $field_name }}"
                id="settings_cache_duration"
                class="form-control"
                placeholder="{{ $field_placeholder }}"
                min="0"
                value="{{ old('settings.cache_duration', $data->settings['cache_duration'] ?? '') }}"
            >

            <small class="form-text text-muted">
                How long to cache this menu (0 = no cache)
            </small>
        </div>
    </div>
</div>

<x-library.select2 />