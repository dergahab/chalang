<?php

namespace App\Datatable;

use App\Models\Contenttext;
use Illuminate\Database\Eloquent\Builder;

class TextDatatable extends BaseDatatable
{
    public function __construct()
    {
        parent::__construct(Contenttext::class, [
            'id' => 'ID',
            'key' => 'Açar söz',
            'title' => 'Başlıq',
        ], [

            'actions' => [
                'title' => 'Əməliyyat',
                'view' => 'admin.pages.content_text.table_actions',
            ],
        ]);
    }

    protected function baseQueryScope(): Builder
    {
        return parent::baseQueryScope();
    }

    protected function query(): Builder
    {
        $query = $this->baseQueryScope();

        if ($this->getSearchInput()) {
            $query
                ->where('title_az', 'LIKE', '%'.$this->getSearchInput().'%')
                ->orWhere('key', 'LIKE', '%'.$this->getSearchInput().'%');

        }

        return $query;
    }
}
