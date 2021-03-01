<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Sushi\Sushi;

class DiscountPlan extends Pivot
{
    use Sushi;

    public $incrementing = false;

    public function getRows()
    {
        return [
            ['discount_id' => 1, 'plan_id' => 1],
            ['discount_id' => 1, 'plan_id' => 2],
            ['discount_id' => 2, 'plan_id' => 1],
        ];
    }

    public function discount(): BelongsTo
    {
        return $this->belongsTo(Discount::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }
}
