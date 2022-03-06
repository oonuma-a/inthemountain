<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class item extends Model
{
    protected $guarded = array('id');
    protected $table = 'item'; 
    const UPDATED_AT = 'update_at';
    const CREATED_AT = null;  
    public function getKeyType()
    {
        return 'string';
    }
    
}
