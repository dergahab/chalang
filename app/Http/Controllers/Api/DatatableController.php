<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;

class DatatableController extends Controller {
    private $namespace = 'App\\Datatable';

    public function handle($datasource) {
        $class = $this->namespace . '\\' .Str::ucfirst($datasource) . 'Datatable';

        try {
            return (new $class)->datatable();
        } catch (QueryException $exception) {
            dd($exception);
        } catch (\Exception $exception) {
            dd($exception);
            throw new \Exception('Datatable class `' . $class . '` not found!');
        }
    }
}
