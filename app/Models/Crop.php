<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Crop extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = ['name', 'description', 'market_id'];

    protected $searchableFields = ['*'];

    public function prices()
    {
        return $this->hasMany(Price::class);
    }

    public function market()
    {
        return $this->belongsTo(Market::class);
    }
}
