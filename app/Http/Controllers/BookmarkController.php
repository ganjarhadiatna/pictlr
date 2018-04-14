<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\BookmarkModel;
use App\StoryModel;
use App\NotifModel;

class BookmarkController extends Controller
{
	function save(Request $req)
    {
		$id = Auth::id();
        $idstory = $req['idstory'];
        $idboxs = $req['idboxs'];
        $data = array(
			'id' => $id,
            'idstory' => $idstory,
            'idboxs' => $idboxs
        );
        $rest = BookmarkModel::Add($data);
	    if ($rest) {
			//get user id
			$ch = BookmarkModel::Check($idstory, $id);
	    	$iduser = StoryModel::GetIduser($idstory);
	    	if ($id != $iduser) {
		   		//add notif bookmark
		   		$notif = array(
		   			'idstory' => $idstory,
		   			'idbookmark' => $ch,
		   			'id' => $id,
		   			'iduser' => $iduser,
		   			'title' => 'Saved your Story',
		  			'type' => 'bookmark'
		  		);
				NotifModel::AddNotifS($notif);
			}
			echo $ch;
		} else {
			echo 0;
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
