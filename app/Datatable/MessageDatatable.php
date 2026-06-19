<?php

namespace App\Datatable;

use App\Models\Message;
use Illuminate\Database\Eloquent\Builder;

class MessageDatatable extends BaseDatatable
{
    public function __construct()
    {
        parent::__construct(Message::class, [
            'id' => 'ID',
            'full_name' => 'Ad Soyad',
            'email' => 'Email',
            'phone' => 'Telefon',
            'type' => 'Növ',
            'created_at' => 'Tarix',
        ], [
            'actions' => [
                'title' => 'Əməliyyatlar',
                'view' => 'admin.pages.message.table_actions',
            ],
        ]);
    }

    protected function query(): Builder
    {
        $query = $this->baseQueryScope();

        if ($this->getSearchInput()) {
            $query->where(function($q) {
                $q->where('full_name', 'LIKE', '%'.$this->getSearchInput().'%')
                  ->orWhere('email', 'LIKE', '%'.$this->getSearchInput().'%')
                  ->orWhere('message', 'LIKE', '%'.$this->getSearchInput().'%');
            });
        }

        return $query;
    }
}