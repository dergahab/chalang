<?php

namespace App\Datatable;

use App\Models\TeamMember;
use Illuminate\Database\Eloquent\Builder;

class TeamMemberDatatable extends BaseDatatable
{
    public function __construct()
    {
        parent::__construct(TeamMember::class, [
            'id' => 'ID',
            'name' => [
                'title' => 'Ad',
                'orderable' => false,
                'searchable' => false,
            ],
            'position' => [
                'title' => 'Vəzifə',
                'orderable' => false,
                'searchable' => false,
            ],
        ], [
            'is_featured' => [
                'title' => 'Seçilmiş',
                'view' => 'admin.pages.team-member.is_featured',
            ],
            'actions' => [
                'title' => 'Əməliyyatlar',
                'view' => 'admin.pages.team-member.table_actions',
            ],
        ]);
    }

    protected function query(): Builder
    {
        return $this->baseQueryScope();
    }
}
