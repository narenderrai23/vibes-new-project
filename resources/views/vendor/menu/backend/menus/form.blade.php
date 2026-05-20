{{-- ── Row 1: Name / Slug / Location ───────────────────────────── --}}
<div class="row">
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <label for="name" class="form-label">{{ label_case('name') }}</label>
            {!! field_required('required') !!}
            <input type="text"
                   name="name"
                   id="name"
                   placeholder="e.g., Header Menu, Footer Menu"
                   class="form-control"
                   required
                   value="{{ old('name', $menu->name ?? '') }}">
        </div>
    </div>

    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <label for="slug" class="form-label">{{ label_case('slug') }}</label>
            <input type="text"
                   name="slug"
                   id="slug"
                   placeholder="e.g., header-menu, footer-menu"
                   class="form-control"
                   value="{{ old('slug', $menu->slug ?? '') }}">
        </div>
    </div>

    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <label for="location" class="form-label">{{ label_case('location') }}</label>
            {!! field_required('required') !!}
            <select name="location" id="location" class="form-select" required>
                <option value="">-- Select location --</option>
                @foreach(['frontend-header' => 'Frontend Header', 'frontend-footer' => 'Frontend Footer', 'admin-sidebar' => 'Admin Sidebar'] as $val => $label)
                    <option value="{{ $val }}" {{ old('location', $menu->location ?? '') === $val ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>

{{-- ── Row 2: Description / Note ───────────────────────────────── --}}
<div class="row">
    <div class="col-12 col-sm-6 mb-3">
        <div class="form-group">
            <label for="description" class="form-label">{{ label_case('description') }}</label>
            <textarea name="description"
                      id="description"
                      rows="3"
                      placeholder="Brief description of this menu"
                      class="form-control">{{ old('description', $menu->description ?? '') }}</textarea>
        </div>
    </div>

    <div class="col-12 col-sm-6 mb-3">
        <div class="form-group">
            <label for="note" class="form-label">Admin Notes</label>
            <textarea name="note"
                      id="note"
                      rows="3"
                      placeholder="Internal notes for administrators"
                      class="form-control">{{ old('note', $menu->note ?? '') }}</textarea>
        </div>
    </div>
</div>

{{-- ── Row 3: Theme / CSS Classes / Locale ─────────────────────── --}}
<div class="row">
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <label for="theme" class="form-label">{{ label_case('theme') }}</label>
            <select name="theme" id="theme" class="form-select">
                <option value="">-- Select theme --</option>
                @foreach(['default' => 'Default', 'bootstrap' => 'Bootstrap', 'minimal' => 'Minimal', 'dark' => 'Dark Theme', 'custom' => 'Custom'] as $val => $label)
                    <option value="{{ $val }}" {{ old('theme', $menu->theme ?? '') === $val ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <label for="css_classes" class="form-label">CSS Classes</label>
            <input type="text"
                   name="css_classes"
                   id="css_classes"
                   placeholder="e.g., navbar navbar-expand-lg"
                   class="form-control"
                   value="{{ old('css_classes', $menu->css_classes ?? '') }}">
        </div>
    </div>

    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <label for="locale" class="form-label">{{ label_case('locale') }}</label>
            <select name="locale" id="locale" class="form-select">
                <option value="">-- Select language --</option>
                @foreach(['en' => 'English', 'es' => 'Spanish', 'fr' => 'French', 'de' => 'German', 'ar' => 'Arabic', 'hi' => 'Hindi'] as $val => $label)
                    <option value="{{ $val }}" {{ old('locale', $menu->locale ?? '') === $val ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>

{{-- ── Access Control ───────────────────────────────────────────── --}}
<div class="row">
    <div class="col-12 mb-3">
        <h5>Access Control</h5>
    </div>

    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <label for="is_public" class="form-label">Public Menu</label>
            <select name="is_public" id="is_public" class="form-select">
                <option value="">-- Select visibility --</option>
                <option value="1" {{ old('is_public', $menu->is_public ?? '') == '1' ? 'selected' : '' }}>Yes - Allow guests to see this menu</option>
                <option value="0" {{ old('is_public', $menu->is_public ?? '') === '0' ? 'selected' : '' }}>No - Require authentication</option>
            </select>
            <small class="form-text text-muted">Control guest access to this menu</small>
        </div>
    </div>

    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <label for="permissions" class="form-label">Required Permissions</label>
            <select name="permissions[]" id="permissions" class="form-select select2-permissions" multiple>
                @foreach(['view_backend' => 'View Backend', 'edit_content' => 'Edit Content', 'manage_users' => 'Manage Users', 'manage_settings' => 'Manage Settings'] as $val => $label)
                    <option value="{{ $val }}"
                        {{ in_array($val, old('permissions', is_array($menu->permissions ?? null) ? $menu->permissions : [])) ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            <small class="form-text text-muted">Users must have these permissions to see the menu</small>
        </div>
    </div>

    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <label for="roles" class="form-label">Required Roles</label>
            <select name="roles[]" id="roles" class="form-select select2-roles" multiple>
                @foreach(['super admin' => 'Super Admin', 'admin' => 'Admin', 'editor' => 'Editor', 'user' => 'User'] as $val => $label)
                    <option value="{{ $val }}"
                        {{ in_array($val, old('roles', is_array($menu->roles ?? null) ? $menu->roles : [])) ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            <small class="form-text text-muted">Users must have one of these roles to see the menu</small>
        </div>
    </div>
</div>

{{-- ── Status & Visibility ──────────────────────────────────────── --}}
<div class="row">
    <div class="col-12 mb-3">
        <h5>Status &amp; Visibility</h5>
    </div>

    <div class="col-12 col-sm-3 mb-3">
        <div class="form-group">
            <label for="status" class="form-label">{{ label_case('status') }}</label>
            {!! field_required('required') !!}
            <select name="status" id="status" class="form-select" required>
                <option value="">-- Select status --</option>
                <option value="1" {{ old('status', $menu->status ?? '') == '1' ? 'selected' : '' }}>Published</option>
                <option value="0" {{ old('status', $menu->status ?? '') === '0' ? 'selected' : '' }}>Disabled</option>
                <option value="2" {{ old('status', $menu->status ?? '') == '2' ? 'selected' : '' }}>Draft</option>
            </select>
        </div>
    </div>

    <div class="col-12 col-sm-3 mb-3">
        <div class="form-group">
            <label for="is_active" class="form-label">Active Status</label>
            <select name="is_active" id="is_active" class="form-select">
                <option value="">-- Select status --</option>
                <option value="1" {{ old('is_active', $menu->is_active ?? '') == '1' ? 'selected' : '' }}>Yes - Menu is active</option>
                <option value="0" {{ old('is_active', $menu->is_active ?? '') === '0' ? 'selected' : '' }}>No - Menu is inactive</option>
            </select>
        </div>
    </div>

    <div class="col-12 col-sm-3 mb-3">
        <div class="form-group">
            <label for="is_visible" class="form-label">Visibility</label>
            <select name="is_visible" id="is_visible" class="form-select">
                <option value="">-- Select visibility --</option>
                <option value="1" {{ old('is_visible', $menu->is_visible ?? '') == '1' ? 'selected' : '' }}>Yes - Menu is visible</option>
                <option value="0" {{ old('is_visible', $menu->is_visible ?? '') === '0' ? 'selected' : '' }}>No - Menu is hidden</option>
            </select>
        </div>
    </div>
</div>

{{-- ── Advanced Settings ────────────────────────────────────────── --}}
<div class="row">
    <div class="col-12 mb-3">
        <h5>Advanced Settings</h5>
    </div>

    <div class="col-12 col-sm-6 mb-3">
        <div class="form-group">
            <label for="settings_max_depth" class="form-label">Maximum Depth</label>
            <input type="number"
                   name="settings[max_depth]"
                   id="settings_max_depth"
                   placeholder="3"
                   class="form-control"
                   min="1"
                   max="10"
                   value="{{ old('settings.max_depth', $menu->settings['max_depth'] ?? '') }}">
            <small class="form-text text-muted">Maximum nesting level for menu items</small>
        </div>
    </div>

    <div class="col-12 col-sm-6 mb-3">
        <div class="form-group">
            <label for="settings_cache_duration" class="form-label">Cache Duration (minutes)</label>
            <input type="number"
                   name="settings[cache_duration]"
                   id="settings_cache_duration"
                   placeholder="60"
                   class="form-control"
                   min="0"
                   value="{{ old('settings.cache_duration', $menu->settings['cache_duration'] ?? '') }}">
            <small class="form-text text-muted">How long to cache this menu (0 = no cache)</small>
        </div>
    </div>
</div>

<x-library.select2 />
