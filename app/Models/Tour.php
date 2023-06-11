<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    protected $primaryKey = 'uuid';
    public $timestamps = false;

    use HasFactory;
    use HasUuids;

    protected $fillable = ['name','start_date','end_date','price'];


    public function travels() {
        return $this->belongsTo(Travel::class,'tour_uuid');
    }

    public function getPriceAttribute($value) {
        return $value / 100;
    }

    public function setPriceAttribute($value) {
        return $this->attributes['price'] = $value * 100;
    }
}
