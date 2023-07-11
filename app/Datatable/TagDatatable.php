<?php

namespace App\Datatable;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;

class TagDatatable extends BaseDatatable
{
    public function __construct()
    {
        parent::__construct(Tag::class, [
            'id' => 'ID',
            'name' => 'Şirkət',
        ], [
            'actions' => [
                'title' => 'Actions',
                'view' => 'admin.pages.tags.table_actions',
            ],
        ]);
    }

    protected function query(): Builder
    {
        $query = $this->baseQueryScope();

        if ($this->getSearchInput()) {
            $query->where('name', 'LIKE', '%'.$this->getSearchInput().'%');
        }

        return $query;
    }
}
