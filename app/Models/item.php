<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class item extends Model
{
    protected $guarded = array('id');
    protected $table = 'item'; 
    public function getKeyType()
    {
        return 'string';
    }
}
