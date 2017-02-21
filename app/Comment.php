<?php

namespace App;

use App\User;
use App\Video;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['body', 'user_id', 'video_id'];

    public function video()
    {
    	return $this->belongsTo(Video::class);
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
