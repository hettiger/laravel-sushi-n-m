<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Sushi\Sushi;

class Plan extends Model
{
    use Sushi;

    public function getRows()
    {
        return [
            ['id' => 1, 'name' => 'SAAS Plus'],
            ['id' => 2, 'name' => 'SAAS Premium'],
        ];
    }

    public function pivot(): HasMany
    {
        return $this->hasMany(DiscountPlan::class);
    }

    public function discounts(): BelongsToMany
    {
        return $this->belongsToMany(Discount::class);
    }
}
