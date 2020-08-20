<?php

namespace App;
//test

//test cm
//test comment.
use Illuminate\Database\Eloquent\Model;
// add test comment

class Image extends Model
{
    protected $fillable = [
		'post_id',
		'path',
    ];

    public function post()
    {
		return $this->belongsTo('App\Post');
    }
}
