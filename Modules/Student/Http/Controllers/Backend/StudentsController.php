<?php

namespace Modules\Student\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Backend\BackendBaseController;

class StudentsController extends BackendBaseController
{
    use Authorizable;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'Students';

        // module name
        $this->module_name = 'students';

        // directory path of the module
        $this->module_path = 'student::backend';

        // module icon
        $this->module_icon = 'fa-regular fa-sun';

        // module model name, path
        $this->module_model = "Modules\Student\Models\Student";
    }

}
