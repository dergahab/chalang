<?php

namespace App\Datatable;

use App\Models\CaseStudy;
use Illuminate\Database\Eloquent\Builder;

class CaseStudyDatatable extends BaseDatatable
{
    public function __construct()
    {
        parent::__construct(CaseStudy::class, [
            'id' => 'ID',
            'title' => [
                'title' => 'Başlıq',
                'orderable' => false,
                'searchable' => false,
            ],
        ], [
            'in_main' => [
                'title' => 'Ana səhifədə',
                'view' => 'admin.pages.case-study.in_main',
            ],
            'actions' => [
                'title' => 'Əməliyyatlar',
                'view' => 'admin.pages.case-study.table_actions',
            ],
        ]);
    }

    protected function query(): Builder
    {
        return $this->baseQueryScope();
    }
}
