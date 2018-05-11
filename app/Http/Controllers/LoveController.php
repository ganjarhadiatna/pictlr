<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\LoveModel;
use App\StoryModel;
use App\NotifModel;

class LoveController extends Controller
{
    function add(Request $request)
    {
    	$id = Auth::id();
    	$idstory = $request['idstory'];
    	$ch = LoveModel::Check($idstory, $id);
    	if (is_int($ch)) {
    		$rest = LoveModel::Remove($idstory, $id);
		    if ($rest) {
		    	echo "unlove";	
		    } else {
		    	echo "failedremove";
		    }
    	} else {
    		$data = array('idstory' => $idstory, 'id' => $id);
	    	$rest = LoveModel::Add($data);
	    	if ($rest) {
	    		//get user id
	    		$iduser = StoryModel::GetIduser($idstory);
	    		if ($id != $iduser) {
	    			//get love id
		    		$idlove = LoveModel::GetIduser($iduser);
		    		//add notif love
		    		$notif = array(
		    			'idstory' => $idstory,
		    			'idlove' => $idlove,
		    			'id' => $id,
		    			'iduser' => $iduser,
		    			'type' => 'love'
		    		);
		    		NotifModel::AddNotifS($notif);
	    		}
	    		echo "love";	
	    	} else {
	    		echo "failedadd";
	    	}
    	}
    }
    function remove(Request $request)
    {
    	$idlove = $request['idlove'];
	    $rest = LoveModel::Remove($idlove);
	    if ($rest) {
	    	echo 1;
	    } else {
	    	echo 0;
	    }
    }
}
