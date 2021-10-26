<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $guarded = [];


    // one to one (show parent a category)
    public function offer()
    {
        return $this->belongsTo(Product::class);
    }
}
