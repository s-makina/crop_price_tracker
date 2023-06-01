<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Price extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['date', 'price', 'crop_id'];

    protected $searchableFields = ['*'];

    protected $casts = [
        'date' => 'date',
    ];

    public function crop()
    {
        return $this->belongsTo(Crop::class);
    }
}
