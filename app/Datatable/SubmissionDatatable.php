<?php

namespace App\Datatable;

use App\Models\Submission;
use Illuminate\Database\Eloquent\Builder;

class SubmissionDatatable extends BaseDatatable
{
    public function __construct()
    {
        parent::__construct(Submission::class, [
            'id' => 'ID',
            'type' => 'Növ',
            'status' => 'Status',
            'created_at' => 'Tarix',
        ], [
            'actions' => [
                'title' => 'Əməliyyatlar',
                'view' => 'admin.pages.submission.table_actions',
            ],
        ]);
    }

    protected function query(): Builder
    {
        return $this->baseQueryScope();
    }
}
