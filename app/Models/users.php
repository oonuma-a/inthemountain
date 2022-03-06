<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class users extends Model
{
    protected $guarded = array('id');
    protected $table = 'users';
    const UPDATED_AT = 'update_at';
    const CREATED_AT = null;  
    public function getKeyType()
    {
        return 'string';
    }    
}
