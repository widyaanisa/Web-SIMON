<?php

namespace App\Exports;

use App\Models\Pelaksanaan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PelaksanaanExport implements FromCollection, ShouldAutoSize, WithHeadings
{
    protected $collection;

    public function __construct($collection)
    {
        $this->collection = $collection;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->collection;
    }

    public function headings(): array
    {
        if ($this->collection()->count() < 1) return [];

        $attributes = [];
        foreach ($this->collection->first()->getAttributes() as $attr => $data) {
            array_push($attributes, $attr);
        }

        return $attributes;
    }
}
