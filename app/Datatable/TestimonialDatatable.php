<?php

namespace App\Datatable;

use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Builder;

class TestimonialDatatable extends BaseDatatable
{
    public function __construct()
    {
        parent::__construct(Testimonial::class, [
            'id' => 'ID',
            'name' => [
                'title' => 'Ad',
                'orderable' => false,
                'searchable' => false,
            ],
        ], [
            'is_active' => [
                'title' => 'Status',
                'view' => 'admin.pages.testimonial.is_active',
            ],
            'actions' => [
                'title' => 'Əməliyyatlar',
                'view' => 'admin.pages.testimonial.table_actions',
            ],
        ]);
    }

    protected function query(): Builder
    {
        return $this->baseQueryScope();
    }
}
