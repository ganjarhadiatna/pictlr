<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProfileModel extends Model
{
	protected $table = 'users';

    function scopeEditProfile($query, $id, $data)
    {
        return DB::table('users')
        ->where('users.id', $id)
        ->update($data);
    }
	function scopeUpdateVisitor($query, $id)
    {
        $no = (DB::table('users')->where('id', $id)->value('visitor'))+1;
        return DB::table('users')
        ->where('users.id', $id)
        ->update(['users.visitor' => $no]);
    }
    function scopeGetPass($query, $id)
    {
        return DB::table('users')
        ->where('users.id', $id)
        ->value('password');
    }
    function scopeUserSmallData($query, $id)
    {
        return DB::table('users')
        ->select (
            'users.id',
            'users.foto',
            'users.username'
        )
        ->where('users.id', $id)
        ->get();
    }
    function scopeUserData($query, $id)
    {
    	return DB::table('users')
    	->select (
    		'users.id',
    		'users.name',
    		'users.email',
            'users.username',
    		'users.created_at',
    		'users.about',
    		'users.visitor',
    		'users.foto',
            'users.website',
            DB::raw('(select count(story.idstory) from story where story.id = users.id) as ttl_story'),
            DB::raw('(select count(bookmark.idbookmark) from bookmark where bookmark.id = users.id) as ttl_bookmark'),
            DB::raw('(select count(follow.idfollow) from follow where follow.followers = users.id) as ttl_following'),
            DB::raw('(select count(follow.idfollow) from follow where follow.following = users.id) as ttl_followers')
    	)
    	->where('users.id', $id)
    	->get();
    }
    function scopeTopUsers($query, $iduser, $limit)
    {
        return DB::table('users')
        ->select (
            'users.id',
            'users.name',
            'users.email',
            'users.username',
            'users.created_at',
            'users.about',
            'users.visitor',
            'users.foto',
            'users.website',
            DB::raw('(select idfollow from follow where following=users.id and followers='.$iduser.') as is_following')
        )
        ->orderBy('users.visitor', 'desc')
        ->limit($limit)
        ->get();
    }
    function scopeSearchUsers($query, $ctr, $iduser)
    {
        $searchValues = preg_split('/\s+/', $ctr, -1, PREG_SPLIT_NO_EMPTY);
        return DB::table('users')
        ->select (
            'users.id',
            'users.name',
            'users.email',
            'users.username',
            'users.created_at',
            'users.about',
            'users.visitor',
            'users.foto',
            'users.website',
            DB::raw('(select idfollow from follow where following=users.id and followers='.$iduser.') as is_following')
        )
        ->where(function ($q) use ($searchValues)
        {
            foreach ($searchValues as $value) {
                $q->orWhere('users.name','like',"%$value%")->orWhere('users.about','like',"%$value%");
            }
        })
        ->orderBy('users.visitor', 'desc')
        ->limit(7)
        ->get();
    }
}
