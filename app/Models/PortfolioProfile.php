<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortfolioProfile extends Model
{
    protected $fillable = [
        'name', 'title', 'location', 'email', 'phone', 'website', 'upwork_url',
        'intro', 'bio', 'secondary_bio', 'profile_image', 'years_experience',
        'full_stack_years', 'availability', 'languages',
    ];

    public function getProfileImageUrlAttribute(): string
    {
        if (! $this->profile_image) {
            return asset('assets/profile/roland-cartoon.png');
        }

        return str_starts_with($this->profile_image, 'assets/')
            ? asset($this->profile_image)
            : asset('storage/'.$this->profile_image);
    }
}
