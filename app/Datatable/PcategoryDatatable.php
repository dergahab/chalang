<?php

namespace App\Datatable;

use App\Models\Pcategory;
use Illuminate\Database\Eloquent\Builder;

class PcategoryDatatable extends BaseDatatable
{

    public function __construct()
    {
        parent::__construct(Pcategory::class, [
            'id' => 'ID',
            'name' => 'Kateqoriya',
        ], [
            'actions' => [
                'title' => 'Actions',
                'view' => 'admin.pages.pcategory.table_actions'
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
