<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\Conversions\Conversion;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\FileAdder;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @method void prepareToAttachMedia(Media $media, FileAdder $fileAdder)
 */
class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded;

    public function currency() : BelongsTo{
        return $this->belongsTo(Currency::class);
    }

    public function declinationProducts() : HasMany{
        return $this->hasMany(DeclinationProduct::class);
    }

    public function categoryProducts() : HasMany{
        return $this->hasMany(CategoryProduct::class);
    }

    public function brandProducts() : HasMany{
        return $this->hasMany(BrandProduct::class);
    }

    public function deliveryProducts() : HasMany{
        return $this->hasMany(DeliveryProduct::class);
    }
}
