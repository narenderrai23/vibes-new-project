<?php

namespace Modules\Center\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Modules\Center\Models\Country;
use Yajra\DataTables\DataTables;

class CountriesController extends Controller
{
    use Authorizable;

    public string $module_title = 'Countries';
    public string $module_name  = 'countries';
    public string $module_path  = 'center::backend';
    public string $module_icon  = 'ph-light ph-globe';
    public string $module_model = Country::class;

    protected function moduleContext(): array
    {
        return [
            'module_title'        => $this->module_title,
            'module_name'         => $this->module_name,
            'module_path'         => $this->module_path,
            'module_icon'         => $this->module_icon,
            'module_model'        => $this->module_model,
            'module_name_singular' => Str::singular($this->module_name),
        ];
    }

    public function index(): View
    {
        extract($this->moduleContext());
        $module_action = 'List';
        logUserAccess("{$module_title} {$module_action}");

        return view("{$module_path}.{$module_name}.index_datatable",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_name_singular', 'module_action'));
    }

    public function index_data(): JsonResponse
    {
        extract($this->moduleContext());

        $data = Country::select('id', 'name', 'iso2', 'iso3', 'phonecode', 'currency', 'updated_at');

        return DataTables::of($data)
            ->addColumn('action', function ($row) {
                $module_name = $this->module_name;
                return view('backend.includes.action_column', compact('module_name', 'row'))
                    ->with('data', $row);
            })
            ->editColumn('name', '<strong>{{$name}}</strong>')
            ->editColumn('updated_at', function ($row) {
                $diff = Carbon::now()->diffInHours($row->updated_at);
                return $diff < 25 ? $row->updated_at->diffForHumans() : $row->updated_at->isoFormat('llll');
            })
            ->rawColumns(['name', 'action'])
            ->orderColumns(['id'], '-:column $1')
            ->make(true);
    }

    public function index_list(Request $request): JsonResponse
    {
        $term = trim($request->q);
        if (empty($term)) {
            return response()->json([]);
        }
        $results = Country::where('name', 'LIKE', "%{$term}%")->limit(10)->get(['id', 'name'])
            ->map(fn ($c) => ['id' => $c->id, 'text' => $c->name]);

        return response()->json($results);
    }

    public function create(): View
    {
        extract($this->moduleContext());
        $module_action = 'Create';
        logUserAccess("{$module_title} {$module_action}");

        return view("{$module_path}.{$module_name}.create",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_name_singular', 'module_action'));
    }

    public function store(Request $request): RedirectResponse
    {
        extract($this->moduleContext());

        $validated = $request->validate([
            'name'      => 'required|string|max:191|unique:countries,name',
            'iso2'      => 'nullable|string|max:2',
            'iso3'      => 'nullable|string|max:3',
            'phonecode' => 'nullable|string|max:20',
            'currency'  => 'nullable|string|max:10',
        ]);

        $country = Country::create($validated);

        flash("New Country '{$country->name}' added.")->success()->important();
        logUserAccess("{$module_title} Store | Id: {$country->id}");

        return redirect("admin/{$module_name}");
    }

    public function show(int $id): View
    {
        extract($this->moduleContext());
        $module_action = 'Show';

        $country = Country::with('states')->findOrFail($id);
        logUserAccess("{$module_title} {$module_action} | Id: {$id}");

        return view("{$module_path}.{$module_name}.show",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_name_singular', 'module_action')
            + ["{$module_name_singular}" => $country]);
    }

    public function edit(int $id): View
    {
        extract($this->moduleContext());
        $module_action = 'Edit';

        $country = Country::findOrFail($id);
        logUserAccess("{$module_title} {$module_action} | Id: {$id}");

        return view("{$module_path}.{$module_name}.edit",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_action', 'module_name_singular')
            + ["{$module_name_singular}" => $country]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        extract($this->moduleContext());

        $validated = $request->validate([
            'name'      => "required|string|max:191|unique:countries,name,{$id}",
            'iso2'      => 'nullable|string|max:2',
            'iso3'      => 'nullable|string|max:3',
            'phonecode' => 'nullable|string|max:20',
            'currency'  => 'nullable|string|max:10',
        ]);

        $country = Country::findOrFail($id);
        $country->update($validated);

        flash("Country '{$country->name}' updated.")->success()->important();
        logUserAccess("{$module_title} Update | Id: {$id}");

        return redirect()->route("backend.{$module_name}.show", $id);
    }

    public function destroy(int $id): RedirectResponse
    {
        extract($this->moduleContext());

        $country = Country::findOrFail($id);
        $name = $country->name;
        $country->delete();

        flash("Country '{$name}' deleted.")->success()->important();
        logUserAccess("{$module_title} Destroy | Id: {$id}");

        return redirect("admin/{$module_name}");
    }

    public function trashed(): View
    {
        extract($this->moduleContext());
        $module_action = 'Trashed';

        // If model uses SoftDeletes, show trashed records; otherwise, return empty collection
        $usesSoftDeletes = in_array(\Illuminate\Database\Eloquent\SoftDeletes::class, class_uses($this->module_model));
        $data = $usesSoftDeletes ? ($this->module_model)::onlyTrashed()->get() : collect();

        logUserAccess("{$module_title} {$module_action}");

        return view("{$module_path}.{$module_name}.trash",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_name_singular', 'module_action')
            + ['data' => $data]
        );
    }

    public function restore(int $id): RedirectResponse
    {
        extract($this->moduleContext());

        $usesSoftDeletes = in_array(\Illuminate\Database\Eloquent\SoftDeletes::class, class_uses($this->module_model));
        if (! $usesSoftDeletes) {
            flash('Restore not supported for this model.')->warning()->important();
            return redirect("admin/{$module_name}");
        }

        $item = ($this->module_model)::onlyTrashed()->find($id);
        if (! $item) {
            flash('Item not found.')->warning()->important();
            return redirect("admin/{$module_name}");
        }

        $item->restore();
        flash("{$module_title} restored.")->success()->important();
        logUserAccess("{$module_title} Restore | Id: {$id}");

        return redirect("admin/{$module_name}");
    }
}
