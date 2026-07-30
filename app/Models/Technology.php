<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Mcp\Enums\Role;

class Technology extends Model
{
    protected $fillable = [
        'id',
        'type',
        'title',
        'description',
    ];
}
