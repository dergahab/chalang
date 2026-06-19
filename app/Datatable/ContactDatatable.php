<?php

namespace App\Datatable;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Builder;

class ContactDatatable extends BaseDatatable
{
    public function __construct()
    {
        parent::__construct(Contact::class, [
            'id' => 'ID',
            'mail' => 'Email',
            'address' => 'Ünvan',
            'phone' => 'Telefon',
        ], [
            'actions' => [
                'title' => 'Əməliyyatlar',
                'view' => 'admin.pages.contact.table_actions',
            ],
        ]);
    }

    protected function query(): Builder
    {
        return $this->baseQueryScope();
    }
}