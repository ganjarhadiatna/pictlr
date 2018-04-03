<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;

use App\StoryModel;
use App\ImageModel;

class ImageController extends Controller
{
    function upload(Request $request)
    {
    	$this->validate($request, [
    		'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:100000',
    	]);
    	$id = Auth::id();
    	$image = $request->file('image');
    	$chrc = array('[',']','@',' ','+','-','#','*','<','>','_','(',')',';',',','&','%','$','!','`','~','=','{','}','/',':','?','"',"'",'^');
	    $filename = $id.time().str_replace($chrc, '', $image->getClientOriginalName());

	    //saving to database
	    $data = ['image' => $filename, 'id' => $id];
	    ImageModel::AddImage($data);

	    //saving image to server
	    $destination = public_path('story/images/');
	    $image->move($destination, $filename);

	    echo $filename;
    }
}
