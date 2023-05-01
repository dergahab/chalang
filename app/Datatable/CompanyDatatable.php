<?php

namespace App\Datatable;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class CompanyDatatable extends BaseDatatable
{

    public function __construct()
    {
        parent::__construct(Company::class, [
            'id' => 'ID',
            'name' => 'Şirkət',
        ], [
            'actions' => [
                'title' => 'Actions',
                'view' => 'admin.pages.company.table_actions'
            ]
        ]);
    }

    protected function query(): Builder
    {
        $query = $this->baseQueryScope();

        if ($this->getSearchInput()) {
            $query->where('name', 'LIKE', '%' . $this->getSearchInput() . '%');
        }

        return $query;
    }
}
