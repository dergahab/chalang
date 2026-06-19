<?php

namespace App\Datatable;

use App\Models\PricingPlan;
use Illuminate\Database\Eloquent\Builder;

class PricingPlanDatatable extends BaseDatatable
{
    public function __construct()
    {
        parent::__construct(PricingPlan::class, [
            'id' => 'ID',
            'name' => [
                'title' => 'Ad',
                'orderable' => false,
                'searchable' => false,
            ],
            'price_monthly' => 'Aylıq qiymət',
        ], [
            'is_active' => [
                'title' => 'Status',
                'view' => 'admin.pages.pricing-plan.is_active',
            ],
            'actions' => [
                'title' => 'Əməliyyatlar',
                'view' => 'admin.pages.pricing-plan.table_actions',
            ],
        ]);
    }

    protected function query(): Builder
    {
        return $this->baseQueryScope();
    }
}
