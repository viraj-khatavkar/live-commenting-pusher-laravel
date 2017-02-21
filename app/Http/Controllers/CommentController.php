<?php

namespace App\Http\Controllers;

use App\Events\NewComment;
use App\Video;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Video $video)
    {
    	return response()->json(
    		$video->comments()->latest()->get()
		);
    }

    public function store(Video $video)
    {
    	$comment = $video->comments()->create([
    		'body' => request('body'),
    		'user_id' => auth()->user()->id,
    		'video_id' => $video->id
		]);

		broadcast(new NewComment($comment))->toOthers();

		return $comment;
    }
}
