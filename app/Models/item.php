<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'item';
    protected $guarded = array('id');
    const UPDATED_AT = 'update_at';
    const CREATED_AT = null;  

    protected $fillable = [
        'item_name',
        'item_number',
        'item_category',
        'item_text',
        'star',
        'image',
        'price',
        'discount_price',
        'update_at',
    ];
}
