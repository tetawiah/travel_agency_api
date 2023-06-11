<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Travel extends Model
{
    protected $table = 'travels';
    protected $primaryKey = 'uuid';
    public $timestamps = false;

    use HasFactory;
    use HasSlug;
    use HasUuids;

    protected $fillable = ['is_public', 'slug', 'name', 'description', 'num_of_days',];

    public function tours()
    {
        return $this->hasMany(Tour::class);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function getNumOfNightsAttribute()
    {
        return $this->num_of_days - 1;
    }

}
