<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Sushi\Sushi;

class Discount extends Model
{
    use Sushi;

    public function getRows()
    {
        return [
            ['id' => 1, 'name' => 'Summer Sale'],
            ['id' => 2, 'name' => 'Black Friday'],
        ];
    }

    public function pivot(): HasMany
    {
        return $this->hasMany(DiscountPlan::class);
    }

    public function plans(): BelongsToMany
    {
        return $this->belongsToMany(Plan::class)->using(DiscountPlan::class);
    }
}
