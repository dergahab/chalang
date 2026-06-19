<?php

namespace App\Datatable;

use App\Models\About;
use Illuminate\Database\Eloquent\Builder;

class AboutDatatable extends BaseDatatable
{
    public function __construct()
    {
        parent::__construct(About::class, [
            'id' => 'ID',
            'title' => 'Başlıq',
            'image' => 'Şəkil',
        ], [
            'actions' => [
                'title' => 'Əməliyyatlar',
                'view' => 'admin.pages.about.table_actions',
            ],
        ]);
    }

    protected function query(): Builder
    {
        return $this->baseQueryScope();
    }
}