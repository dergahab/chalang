<?php

namespace App\Datatable;

use App\Models\Banner;
use Illuminate\Database\Eloquent\Builder;

class BannerDatatable extends BaseDatatable
{
    public function __construct()
    {
        parent::__construct(Banner::class, [
            'id' => 'ID',
            'title' => 'Basliq',
        ], [
            'actions' => [
                'title' => 'Actions',
                'view' => 'admin.pages.banner.table_actions',
            ],
        ]);
    }

    protected function query(): Builder
    {
        $query = $this->baseQueryScope();

        if ($this->getSearchInput()) {
            $query->where('title', 'LIKE', '%' . $this->getSearchInput() . '%');
        }

        return $query;
    }
}
