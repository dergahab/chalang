<?php

namespace App\Datatable;

use App\Models\Faq;
use Illuminate\Database\Eloquent\Builder;

class FaqDatatable extends BaseDatatable
{
    public function __construct()
    {
        parent::__construct(Faq::class, [
            'id' => 'ID',
            'question' => [
                'title' => 'Sual',
                'orderable' => false,
                'searchable' => false,
            ],
        ], [
            'is_active' => [
                'title' => 'Status',
                'view' => 'admin.pages.faq.is_active',
            ],
            'actions' => [
                'title' => 'Əməliyyatlar',
                'view' => 'admin.pages.faq.table_actions',
            ],
        ]);
    }

    protected function query(): Builder
    {
        return $this->baseQueryScope();
    }
}
