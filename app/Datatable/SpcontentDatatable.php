<?php

namespace App\Datatable;

use App\Models\ServisContent;
use Illuminate\Database\Eloquent\Builder;

class SpcontentDatatable extends BaseDatatable
{
    public function __construct()
    {
        parent::__construct(ServisContent::class, [
            'id' => 'ID',
            'title' => 'Basliq',
        ], [
            'actions' => [
                'title' => 'Actions',
                'view' => 'admin.pages.sp_contnet.table_actions',
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
