<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CategoryModel extends Model
{
    function scopeGetCtr($query)
    {
    	return DB::table('category')->get();
    }
}
