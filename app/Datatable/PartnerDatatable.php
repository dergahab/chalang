<?php

namespace App\Datatable;

use App\Models\Partner;
use Illuminate\Database\Eloquent\Builder;

class PartnerDatatable extends BaseDatatable
{
    public function __construct()
    {
        parent::__construct(Partner::class, [
            'id' => 'ID',
            'name' => 'Ad',
        ], [
            'is_active' => [
                'title' => 'Status',
                'view' => 'admin.pages.partner.is_active',
            ],
            'actions' => [
                'title' => 'Əməliyyatlar',
                'view' => 'admin.pages.partner.table_actions',
            ],
        ]);
    }

    protected function query(): Builder
    {
        return $this->baseQueryScope();
    }
}
