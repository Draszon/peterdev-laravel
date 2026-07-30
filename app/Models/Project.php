<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Mcp\Enums\Role;

class Project extends Model
{
    protected $fillable = [
        'id',
        'title',
        'description',
        'url',
        'status',
    ];
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}
