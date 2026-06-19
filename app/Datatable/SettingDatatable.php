<?php

namespace App\Datatable;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Builder;

class SettingDatatable extends BaseDatatable
{
    public function __construct()
    {
        parent::__construct(Setting::class, [
            'id' => 'ID',
            'key' => 'Açar',
            'value' => 'Dəyər',
        ], [
            'actions' => [
                'title' => 'Əməliyyatlar',
                'view' => 'admin.pages.setting.table_actions',
            ],
        ]);
    }

    protected function query(): Builder
    {
        $query = $this->baseQueryScope();

        if ($this->getSearchInput()) {
            $query->where('key', 'LIKE', '%'.$this->getSearchInput().'%')
                 ->orWhere('value', 'LIKE', '%'.$this->getSearchInput().'%');
        }

        return $query;
    }
}