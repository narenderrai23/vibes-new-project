<?php

namespace Modules\Trainer\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Backend\BackendBaseController;

class TrainersController extends BackendBaseController
{
    use Authorizable;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'Trainers';

        // module name
        $this->module_name = 'trainers';

        // directory path of the module
        $this->module_path = 'trainer::backend';

        // module icon
        $this->module_icon = 'fa-regular fa-sun';

        // module model name, path
        $this->module_model = "Modules\Trainer\Models\Trainer";
    }

}
