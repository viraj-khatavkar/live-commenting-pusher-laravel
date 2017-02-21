<?php

namespace App\Http\Controllers;

use App\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function show(Video $video)
    {
    	return view('video.show', [
    		'video' => $video,
		]);
    }
}
