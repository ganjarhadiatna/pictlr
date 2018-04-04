<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StoryModel extends Model
{
    protected $table = 'story';

    function scopeGetID($query)
    {
        return DB::table('story')
        ->orderBy('idstory', 'desc')
        ->limit(1)
        ->value('idstory');
    }
    function scopeGetIduser($query, $idstory)
    {
        return DB::table('story')
        ->where('story.idstory', $idstory)
        ->value('story.id');
    }
    function scopeAddStory($query, $data)
    {
        return DB::table('story')->insert($data);
    }
    function scopeUpdateStory($query, $idstory, $data)
    {
        return DB::table('story')->where('story.idstory', $idstory)->update($data);
    }
    function scopeDeleteStory($query, $idstory, $id)
    {
        return DB::table('story')
        ->where('story.idstory', $idstory)
        ->where('story.id', $id)
        ->delete();
    }
    function scopeUpdateViewsStory($query, $idstory)
    {
        $no = (DB::table('story')->where('idstory', $idstory)->value('views'))+1;
        return DB::table('story')
        ->where('story.idstory', $idstory)
        ->update(['story.views' => $no]);
    }
    function scopeGetStory($query, $idstory)
    {
        return DB::table('story')
        ->select(
            'story.idstory',
            'story.description',
            'story.cover',
            'story.created',
            'story.views',
            'story.description',
            'users.id',
            'users.name',
            'users.about',
            'users.created_at',
            'users.visitor',
            'users.foto',
            DB::raw('(select count(story.idstory) from story where story.id = users.id) as ttl_story'),
            DB::raw('(select count(comment.idcomment) from comment where comment.idstory = story.idstory) as ttl_comment'),
            DB::raw('(select count(bookmark.idbookmark) from bookmark where bookmark.idstory = story.idstory) as ttl_save')
        )
        ->join('users','users.id', '=', 'story.id')
        ->where('story.idstory', $idstory)
        ->get();
    }
    function scopePagAllStory($query, $limit)
    {
        $id = Auth::id();
        return DB::table('story')
        ->select(
            'story.idstory',
            'story.cover',
            'story.created',
            'story.views',
            'story.description',
            'users.id',
            'users.name',
            'users.visitor',
            'users.foto',
            DB::raw('(select count(story.idstory) from story where story.id = users.id) as ttl_story'),
            DB::raw('(select count(comment.idcomment) from comment where comment.idstory = story.idstory) as ttl_comment'),
            DB::raw('(select count(bookmark.idbookmark) from bookmark where bookmark.idstory = story.idstory) as ttl_save'),
            DB::raw('(select bookmark.idbookmark from bookmark where bookmark.idstory = story.idstory and bookmark.id = '.$id.') as is_save')
        )
        ->join('users','users.id', '=', 'story.id')
        ->orderBy('story.idstory', 'desc')
        ->paginate($limit);
    }
    function scopePagRelatedStory($query, $limit, $idstory)
    {
        $id = Auth::id();
        return DB::table('story')
        ->select(
            'story.idstory',
            'story.cover',
            'story.created',
            'story.views',
            'story.description',
            'users.id',
            'users.name',
            'users.visitor',
            'users.foto',
            DB::raw('(select count(story.idstory) from story where story.id = users.id) as ttl_story'),
            DB::raw('(select count(comment.idcomment) from comment where comment.idstory = story.idstory) as ttl_comment'),
            DB::raw('(select count(bookmark.idbookmark) from bookmark where bookmark.idstory = story.idstory) as ttl_save'),
            DB::raw('(select bookmark.idbookmark from bookmark where bookmark.idstory = story.idstory and bookmark.id = '.$id.') as is_save')
        )
        ->join('users','users.id', '=', 'story.id')
        ->where('story.idstory','!=',$idstory)
        ->orderBy('story.idstory', 'desc')
        ->paginate($limit);
    }
    function scopePagPopularStory($query, $limit)
    {
        $id = Auth::id();
        return DB::table('story')
        ->select(
            'story.idstory',
            'story.cover',
            'story.created',
            'story.views',
            'story.description',
            'users.id',
            'users.name',
            'users.visitor',
            'users.foto',
            DB::raw('(select count(story.idstory) from story where story.id = users.id) as ttl_story'),
            DB::raw('(select count(comment.idcomment) from comment where comment.idstory = story.idstory) as ttl_comment'),
            DB::raw('(select count(bookmark.idbookmark) from bookmark where bookmark.idstory = story.idstory) as ttl_save'),
            DB::raw('(select bookmark.idbookmark from bookmark where bookmark.idstory = story.idstory and bookmark.id = '.$id.') as is_save')
        )
        ->join('users','users.id', '=', 'story.id')
        ->orderBy('ttl_comment', 'desc')
        ->paginate($limit);
    }
    /*trending belum benar karena komentar belum ada*/
    function scopePagTrendingStory($query, $limit)
    {
        $id = Auth::id();
        return DB::table('story')
        ->select(
            'story.idstory',
            'story.cover',
            'story.created',
            'story.views',
            'story.description',
            'users.id',
            'users.name',
            'users.visitor',
            'users.foto',
            DB::raw('(select count(story.idstory) from story where story.id = users.id) as ttl_story'),
            DB::raw('(select count(comment.idcomment) from comment where comment.idstory = story.idstory) as ttl_comment'),
            DB::raw('(select count(bookmark.idbookmark) from bookmark where bookmark.idstory = story.idstory) as ttl_save'),
            DB::raw('(select bookmark.idbookmark from bookmark where bookmark.idstory = story.idstory and bookmark.id = '.$id.') as is_save')
        )
        ->join('users','users.id', '=', 'story.id')
        ->orderBy('ttl_comment', 'desc')
        ->paginate($limit);
    }
    function scopePagSearchStory($query, $ctr, $limit)
    {
        $id = Auth::id();
        $searchValues = preg_split('/\s+/', $ctr, -1, PREG_SPLIT_NO_EMPTY);
        return DB::table('story')
        ->select(
            'story.idstory',
            'story.cover',
            'story.created',
            'story.views',
            'story.description',
            'users.id',
            'users.name',
            'users.visitor',
            'users.foto',
            DB::raw('(select count(story.idstory) from story where story.id = users.id) as ttl_story'),
            DB::raw('(select count(comment.idcomment) from comment where comment.idstory = story.idstory) as ttl_comment'),
            DB::raw('(select count(bookmark.idbookmark) from bookmark where bookmark.idstory = story.idstory) as ttl_save'),
            DB::raw('(select bookmark.idbookmark from bookmark where bookmark.idstory = story.idstory and bookmark.id = '.$id.') as is_save')
        )
        ->join('users','users.id', '=', 'story.id')
        ->Where('story.title','like',"%$ctr%")
        ->orWhere('story.description','like',"%$ctr%")
        ->orWhere('users.name','like',"%$ctr%")
        ->orWhere(function ($q) use ($searchValues)
        {
            foreach ($searchValues as $value) {
                $q->orWhere('story.title','like',"%$value%")->orWhere('story.description','like',"%$value%");
            }
        })
        ->paginate($limit);
    }
    function scopePagTagStory($query, $ctr, $limit)
    {
        $id = Auth::id();
        return DB::table('tags')
        ->select(
            'tags.idtags',
            'story.idstory',
            'story.cover',
            'story.created',
            'story.views',
            'story.description',
            'users.id',
            'users.name',
            'users.visitor',
            'users.foto',
            DB::raw('(select count(story.idstory) from story where story.id = users.id) as ttl_story'),
            DB::raw('(select count(comment.idcomment) from comment where comment.idstory = story.idstory) as ttl_comment'),
            DB::raw('(select count(bookmark.idbookmark) from bookmark where bookmark.idstory = story.idstory) as ttl_save'),
            DB::raw('(select bookmark.idbookmark from bookmark where bookmark.idstory = story.idstory and bookmark.id = '.$id.') as is_save')
        )
        ->join('story','story.idstory', '=', 'tags.idstory')
        ->join('users','users.id', '=', 'story.id')
        ->where('tags.tag', 'like', "%{$ctr}%")
        ->orderBy('tags.idtags', 'desc')
        ->groupBy('tags.idstory')
        ->paginate($limit);
    }
    function scopePagCtrStory($query, $ctr, $limit)
    {
        $id = Auth::id();
        return DB::table('category')
        ->select(
            'category.idcategory',
            'story.idstory',
            'story.cover',
            'story.created',
            'story.views',
            'story.description',
            'users.id',
            'users.name',
            'users.visitor',
            'users.foto',
            DB::raw('(select count(story.idstory) from story where story.id = users.id) as ttl_story'),
            DB::raw('(select count(comment.idcomment) from comment where comment.idstory = story.idstory) as ttl_comment'),
            DB::raw('(select count(bookmark.idbookmark) from bookmark where bookmark.idstory = story.idstory) as ttl_save'),
            DB::raw('(select bookmark.idbookmark from bookmark where bookmark.idstory = story.idstory and bookmark.id = '.$id.') as is_save')
        )
        ->join('story','story.idcategory', '=', 'category.idcategory')
        ->join('users','users.id', '=', 'story.id')
        ->where('category.title', $ctr)
        ->orderBy('story.idstory', 'desc')
        ->paginate($limit);
    }
    function scopePagTimelinesStory($query, $limit, $profile, $id)
    {
        $id = Auth::id();
        return DB::table('story')
        ->select(
            'story.idstory',
            'story.cover',
            'story.created',
            'story.views',
            'story.description',
            'users.id',
            'users.name',
            'users.visitor',
            'users.foto',
            DB::raw('(select count(story.idstory) from story where story.id = users.id) as ttl_story'),
            DB::raw('(select count(comment.idcomment) from comment where comment.idstory = story.idstory) as ttl_comment'),
            DB::raw('(select count(bookmark.idbookmark) from bookmark where bookmark.idstory = story.idstory) as ttl_save'),
            DB::raw('(select bookmark.idbookmark from bookmark where bookmark.idstory = story.idstory and bookmark.id = '.$id.') as is_save')
        )
        ->join('users','users.id', '=', 'story.id')
        ->where('story.id', $id)
        ->orWhere(function ($q) use ($profile)
        {
            foreach ($profile as $value) {
                $q->orWhere('story.id', $value->following);
            }
        })
        ->orderBy('story.idstory', 'desc')
        ->paginate($limit);
    }
    function scopePagUserStory($query, $limit, $iduser)
    {
        $id = Auth::id();
        return DB::table('story')
        ->select(
            'story.idstory',
            'story.cover',
            'story.created',
            'story.views',
            'story.description',
            'users.id',
            'users.name',
            'users.visitor',
            'users.foto',
            DB::raw('(select count(story.idstory) from story where story.id = users.id) as ttl_story'),
            DB::raw('(select count(comment.idcomment) from comment where comment.idstory = story.idstory) as ttl_comment'),
            DB::raw('(select count(bookmark.idbookmark) from bookmark where bookmark.idstory = story.idstory) as ttl_save'),
            DB::raw('(select bookmark.idbookmark from bookmark where bookmark.idstory = story.idstory and bookmark.id = '.$id.') as is_save')
        )
        ->join('users','users.id', '=', 'story.id')
        ->where('story.id', $iduser)
        ->orderBy('story.idstory', 'desc')
        ->paginate($limit);
    }
    function scopePagUserBookmark($query, $limit, $iduser)
    {
        $id = Auth::id();
        return DB::table('bookmark')
        ->select(
            'bookmark.idbookmark',
            'story.idstory',
            'story.cover',
            'story.created',
            'story.views',
            'story.description',
            'users.id',
            'users.name',
            'users.visitor',
            'users.foto',
            DB::raw('(select count(story.idstory) from story where story.id = users.id) as ttl_story'),
            DB::raw('(select count(comment.idcomment) from comment where comment.idstory = story.idstory) as ttl_comment'),
            DB::raw('(select count(bookmark.idbookmark) from bookmark where bookmark.idstory = story.idstory) as ttl_save'),
            DB::raw('(select bookmark.idbookmark from bookmark where bookmark.idstory = story.idstory and bookmark.id = '.$id.') as is_save')
        )
        ->join('story','story.idstory', '=', 'bookmark.idstory')
        ->join('users','users.id', '=', 'story.id')
        ->where('bookmark.id', $iduser)
        ->orderBy('bookmark.idbookmark', 'desc')
        ->paginate($limit);
    }
}
