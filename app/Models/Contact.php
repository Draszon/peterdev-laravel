<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'contact_name',
        'contact_link'
    ];

    protected function formattedUrl(): Attribute
    {
        return Attribute::make(
            get: function($value, $attributes) {
                if (str_contains($attributes['contact_link'], '@')) {
                    return 'mailto:' . $attributes['contact_link'];
                }

                return $attributes['contact_link'];
            }
        );
    }
}
