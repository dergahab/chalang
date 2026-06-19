<?php

namespace App\Datatable;

use App\Models\Service;
use Illuminate\Database\Eloquent\Builder;

class ServiceDatatable extends BaseDatatable
{
    public function __construct()
    {
        parent::__construct(Service::class, [
            'id' => 'ID',
            'name' => [
                'title' => 'Ad',
                'orderable' => false,
                'searchable' => false,
            ],
            'status' => 'Status',
        ], [
            'in_main' => [
                'title' => 'Əsas Səhifədə',
                'view' => 'admin.pages.service.in_main',
            ],
            'actions' => [
                'title' => 'Əməliyyatlar',
                'view' => 'admin.pages.service.table_actions',
            ],
        ]);
    }

    protected function query(): Builder
    {
        $query = $this->baseQueryScope();

        // Filter by parent if provided
        if (request()->has('parent') && request('parent')) {
            $query->where('parent_id', request('parent'));
        } else {
            $query->where(function($q) {
                $q->where('parent_id', 0)->orWhereNull('parent_id');
            });
        }

        if ($this->getSearchInput()) {
            $query->whereHas('translations', function($q) {
                $q->where('name', 'LIKE', '%'.$this->getSearchInput().'%');
            });
        }

        return $query;
    }
}