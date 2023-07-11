<?php

namespace App\Services;

interface BaseService
{
    public function store($data);

    public function update(array $array, $model);

    public function saveTranslatable($data, $id);
}
