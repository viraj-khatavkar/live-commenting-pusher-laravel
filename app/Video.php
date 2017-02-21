<?php

namespace App;

use App\Comment;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = ['embed_link'];

    public function comments()
    {
    	return $this->hasMany(Comment::class);
    }
}
