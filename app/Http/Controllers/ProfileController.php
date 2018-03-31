<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;

use App\StoryModel;
use App\ProfileModel;
use App\FollowModel;
use App\TagModel;

class ProfileController extends Controller
{
	function profile()
    {
        $id = Auth::id();
        $profile = ProfileModel::UserData($id);
        $mostViews = StoryModel::UserMostViews(2, 0, $id);
        $userStory = StoryModel::PagUserStory(20, $id);
        return view('profile.index', [
            'title' => 'User Profile',
            'path' => 'profile',
            'nav' => 'story',
            'profile' => $profile,
            'mostViews' => $mostViews,
            'userStory' => $userStory
        ]);
    }
	function story($id)
	{
		$iduser = Auth::id();
		if ($iduser == $id) {
			$pathProfile = 'profile';
		} else {
			$pathProfile = 'none';
		}
        $profile = ProfileModel::UserData($id);
        $userStory = StoryModel::PagUserStory(20, $id);
        $statusFolow = FollowModel::Check($id, $iduser);
        return view('profile.index', [
            'title' => 'User Profile',
            'path' => $pathProfile,
            'nav' => 'story',
            'profile' => $profile,
            'userStory' => $userStory,
            'statusFolow' => $statusFolow
        ]);
	}
	function bookmark($id)
	{
		$iduser = Auth::id();
		if ($iduser == $id) {
			$pathProfile = 'profile';
		} else {
			$pathProfile = 'none';
		}
        $profile = ProfileModel::UserData($id);
        $userStory = StoryModel::PagUserBookmark(20, $id);
        $statusFolow = FollowModel::Check($id, $iduser);
        return view('profile.index', [
            'title' => 'User Profile',
            'path' => $pathProfile,
            'nav' => 'bookmark',
            'profile' => $profile,
            'userStory' => $userStory,
            'statusFolow' => $statusFolow
        ]);
	}

    function profileNotif()
    {
        $id = Auth::id();
        $profile = ProfileModel::UserData($id);
        $topUsers = ProfileModel::TopUsers($id, 8);
        $topTags = TagModel::TopSmallTags();
        return view('profile.notifications', [
            'title' => 'Profile Notifications',
            'path' => 'notif',
            'topUsers' => $topUsers,
            'topTags' => $topTags
        ]);
    }
	function profileSetting()
    {
        $id = Auth::id();
        $profile = ProfileModel::UserData($id);
        return view('profile.setting', [
            'title' => 'Profile Setting',
            'path' => 'profile',
            'profile' => $profile
        ]);
    }
    function profileSettingProfile()
    {
        $id = Auth::id();
        $profile = ProfileModel::UserData($id);
        return view('profile.edit', [
            'title' => 'Edit Profile',
            'path' => 'profile',
            'profile' => $profile
        ]);
    }
    function profileSettingPassword()
    {
        $id = Auth::id();
        $profile = ProfileModel::UserData($id);
        return view('profile.password', [
            'title' => 'Change Password',
            'path' => 'profile',
            'profile' => $profile
        ]);
    }
    function saveProfile(Request $request)
    {
    	$id = Auth::id();
    	$foto = $request['foto'];
    	$name = $request['name'];
    	$email = $request['email'];
    	$about = $request['about'];
    	$website = $request['website'];

    	if ($request->hasFile('foto')) {
    		//setting foto profile
	    	$this->validate($request, [
	    		'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
	    	]);

    		$image = $request->file('foto');

    		$chrc = array('[',']','@',' ','+','-','#','*','<','>','_','(',')',';',',','&','%','$','!','`','~','=','{','}','/',':','?','"',"'",'^');
		    $filename = $id.time().str_replace($chrc, '', $image->getClientOriginalName());

		    //create thumbnail
		    $destination = 'profile/thumbnails/'.$filename;
		    $img = Image::make($image->getRealPath());
		    $img->resize(200, 200, function ($constraint) {
		    	$constraint->aspectRatio();
		    })->save($destination);

		    //create image real
		    $destination = 'profile/photos/';
		    $image->move($destination, $filename);	

		    //set array data
		    $data = array(
		    	'name' => $name,
		    	'email' => $email,
		    	'about' => $about,
		    	'foto' => $filename,
		    	'website' => $website
		    );
    	} else {
    		//set array data
		    $data = array(
		    	'name' => $name,
		    	'email' => $email,
		    	'about' => $about,
		    	'website' => $website
		    );
    	}
	    $rest = ProfileModel::EditProfile($id, $data);
	    if ($rest) {
	    	echo "success";	
	    } else {
	    	echo "failed";
	    }
    }
}
