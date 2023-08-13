<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commodity extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'item_en', 'item_si', 'item_tm', 'price_from', 'price_to', 'base_date'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
