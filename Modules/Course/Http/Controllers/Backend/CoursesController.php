<?php

namespace Modules\Course\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Backend\BackendBaseController;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\DataTables;

class CoursesController extends BackendBaseController
{
    use Authorizable;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'Courses';

        // module name
        $this->module_name = 'courses';

        // directory path of the module
        $this->module_path = 'course::backend';

        // module icon
        $this->module_icon = 'ti ti-sun';

        // module model name, path
        $this->module_model = "Modules\Course\Models\Course";
    }

    /**
     * Retrieves the data for the index page of the module.
     *
     * The courses table uses `title` instead of the base controller's
     * default `name` column, so we alias it to keep the datatable view working.
     */
    public function index_data(): JsonResponse
    {
        extract($this->moduleContext());

        $module_action = 'List';

        $page_heading = label_case($module_title);
        $title = $page_heading.' '.label_case($module_action);

        $$module_name = $module_model::select('id', 'title as name', 'updated_at');

        return DataTables::of($$module_name)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;

                return view(view: 'backend.includes.action_column', data: compact('module_name', 'data'));
            })
            ->editColumn('name', '<strong>{{$name}}</strong>')
            ->editColumn('updated_at', function ($data) {
                $diff = Carbon::now()->diffInHours($data->updated_at);

                if ($diff < 25) {
                    return $data->updated_at->diffForHumans();
                }

                return $data->updated_at->isoFormat('llll');
            })
            ->rawColumns(['name', 'action'])
            ->orderColumns(['id'], '-:column $1')
            ->make(true);
    }

    /**
     * Show a course with its modules and content (managed inline on this page).
     *
     * Overrides the base show() only to eager-load modules.contents so the
     * "Modules & Content" panel can render without N+1 queries.
     */
    public function show($id): View
    {
        extract($this->moduleContext());

        $module_action = 'Show';

        $$module_name_singular = $module_model::with(['modules.contents'])->findOrFail($id);

        logUserAccess($module_title.' '.$module_action.' | Id: '.$$module_name_singular->id);

        return view(
            view: "{$module_path}.{$module_name}.show",
            data: compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_name_singular', 'module_action', "{$module_name_singular}")
        );
    }
}
