<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tour extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = ['travel_id','name','start_date','end_date','price'];


    public function travels(): BelongsTo
    {
        return $this->belongsTo(Travel::class,'tour_uuid');
    }

    public function getPriceAttribute($value): float|int
    {
        return $value / 100;
    }

    public function setPriceAttribute($value): void {
         $this->attributes['price'] = $value * 100;
    }
}
