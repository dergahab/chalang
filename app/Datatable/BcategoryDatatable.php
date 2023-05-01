<?php

namespace App\Datatable;

use App\Models\Bcategory;
use Illuminate\Database\Eloquent\Builder;

class BcategoryDatatable extends BaseDatatable
{

    public function __construct()
    {
        parent::__construct(Bcategory::class, [
            'id' => 'ID',
            'name' => 'Kateqoriya',
        ], [
            'actions' => [
                'title' => 'Actions',
                'view' => 'admin.pages.bcategory.table_actions'
            ]
        ]);
    }

    protected function query(): Builder
    {
        $query = $this->baseQueryScope();

        // if ($this->getSearchInput()) {
        //     $query->where('name', 'LIKE', '%' . $this->getSearchInput() . '%');
        // }

        return $query;
    }
}
