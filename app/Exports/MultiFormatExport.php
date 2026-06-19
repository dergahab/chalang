<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MultiFormatExport implements FromCollection, WithHeadings
{
    protected $data;
    protected $headings;

    public function __construct(array $data)
    {
        if (!empty($data)) {
            $this->headings = array_keys($data[0]);
        }
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        return $this->headings ?? [];
    }
}