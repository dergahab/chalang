<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;

class DatatableController extends Controller
{
    private $namespace = 'App\\Datatable';

    public function handle($datasource)
    {
        $class = $this->namespace.'\\'.Str::studly($datasource).'Datatable';

        try {
            return (new $class)->datatable();
        } catch (QueryException $exception) {
            \Illuminate\Support\Facades\Log::error($exception);
            if (config('app.debug')) {
                throw $exception;
            }
            return response()->json(['message' => 'Server Error'], 500);
        } catch (\Exception $exception) {
            \Illuminate\Support\Facades\Log::error($exception);
            if (config('app.debug')) {
                throw $exception;
            }
            return response()->json(['message' => 'Server Error'], 500);
        }
    }
}
