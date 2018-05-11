<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LoveModel extends Model
{
    function scopeGetIduser($query, $iduser)
    {
        return DB::table('love')
        ->where('love.id', $iduser)
        ->orderBy('love.idlove', 'desc')
        ->limit(1)
        ->value('idlove');
    }
    function scopeAdd($query, $data)
    {
    	return DB::table('love')->insert($data);
    }
    function scopeRemove($query, $idstory, $id)
    {
    	return DB::table('love')
    	->where('idstory', $idstory)
    	->where('id', $id)
    	->delete();
    }
    function scopeCheck($query, $idstory, $id)
    {
    	return DB::table('love')
    	->where('idstory', $idstory)
    	->where('id', $id)
    	->value('idlove');
    }
    function scopeTotal($query, $id)
    {
    	return DB::table('love')
    	->where('id', $id)
    	->count('idlove');
    }
}
