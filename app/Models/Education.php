<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $table = 'education';

    protected $fillable = [
        'qualification', 'institution', 'start_year', 'end_year', 'description', 'sort_order',
    ];

    public function getDateRangeAttribute(): string
    {
        if (! $this->start_year && ! $this->end_year) {
            return '';
        }

        return $this->start_year && $this->end_year
            ? $this->start_year.' - '.$this->end_year
            : (string) ($this->start_year ?? $this->end_year);
    }
}
