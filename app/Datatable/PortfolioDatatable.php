<?php

namespace App\Datatable;

use App\Models\Portfolio;
use Illuminate\Database\Eloquent\Builder;

class PortfolioDatatable  extends BaseDatatable
{

    public function __construct()
    {
        parent::__construct(Portfolio::class, [
            'id' => 'ID',
            'title' => 'Basliq',
        ], [
            'actions' => [
                'title' => 'Actions',
                'view' => 'admin.pages.portfolio.table_actions'
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
