<?php

namespace App\Datatable;

use App\Models\Compound;
use Illuminate\Database\Eloquent\Builder;

class SpcontentDatatable extends BaseDatatable
{
    public function __construct()
    {
        parent::__construct(Compound::class, [
            'id' => 'ID',
            'title' => 'Basliq',
        ], [
            'actions' => [
                'title' => 'Actions',
                'view' => 'admin.pages.portfolio.table_actions',
            ],
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
