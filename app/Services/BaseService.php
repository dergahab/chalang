<?php

namespace App\Services;

use Illuminate\Http\Request;

interface BaseService
{
    public function store( ForFormRequest  $request);

    public function update(array $array, $model);

    public function saveTranslatable($data, $id);
}
