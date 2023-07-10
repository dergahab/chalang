<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Session;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function canOrAbort($permission, $defaultCode = 401) {
        if (!auth()->user()->can($permission)) abort($defaultCode);
    }

    public function flashAlert($message, $status= 'success'){
        Session::flash($status, $message);
    }
}
