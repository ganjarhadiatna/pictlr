<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\BookmarkModel;
use App\StoryModel;
use App\NotifModel;

class BookmarkController extends Controller
{
	function add(Request $request)
    {
    	$id = Auth::id();
    	$idstory = $request['idstory'];
    	$ch = BookmarkModel::Check($idstory, $id);
    	if (is_int($ch)) {
    		$rest = BookmarkModel::Remove($idstory, $id);
		    if ($rest) {
		    	echo "unbookmark";	
		    } else {
		    	echo "failedremove";
		    }
    	} else {
    		$data = array('idstory' => $idstory, 'id' => $id);
	    	$rest = BookmarkModel::Add($data);
	    	if ($rest) {
	    		//get user id
	    		$iduser = StoryModel::GetIduser($idstory);
	    		if ($id != $iduser) {
	    			//get bookmark id
		    		$idbookmark = BookmarkModel::GetIduser($iduser);
		    		//add notif bookmark
		    		$notif = array(
		    			'idstory' => $idstory,
		    			'idbookmark' => $idbookmark,
		    			'id' => $id,
		    			'iduser' => $iduser,
		    			'title' => 'Saved your Story',
		    			'type' => 'bookmark'
		    		);
		    		NotifModel::AddNotifS($notif);
	    		}
	    		echo "bookmark";	
	    	} else {
	    		echo "failedadd";
	    	}
    	}
    }
    function remove(Request $request)
    {
    	$idbookmark = $request['idbookmark'];
	    $rest = BookmarkModel::Remove($idbookmark);
	    if ($rest) {
	    	echo 1;
	    } else {
	    	echo 0;
	    }
    }
}
