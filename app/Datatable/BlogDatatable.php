<?php

namespace App\Datatable;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Builder;

class BlogDatatable extends BaseDatatable
{
    public function __construct()
    {
        parent::__construct(Blog::class, [
            'id' => 'ID',
            'title' => 'Basliq',
        ], [
            'actions' => [
                'title' => 'Actions',
                'view' => 'admin.pages.blog.table_actions',
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
