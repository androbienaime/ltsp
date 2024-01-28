<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class DeclinationProduct extends Pivot
{
    use HasFactory;

    public function declination() : BelongsTo{
        return $this->belongsTo(Declination::class);
    }

    public function product() : BelongsTo{
        return $this->belongsTo(Product::class);
    }
}
