<?php

namespace Modules\Auth\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Backend\BackendBaseController;

class AuthsController extends BackendBaseController
{
    use Authorizable;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'Auths';

        // module name
        $this->module_name = 'auths';

        // directory path of the module
        $this->module_path = 'auth::backend';

        // module icon
        $this->module_icon = 'fa-regular fa-sun';

        // module model name, path
        $this->module_model = "Modules\Auth\Models\Auth";
    }

}
