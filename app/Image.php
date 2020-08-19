<?php

namespace App;

//test cm
//test comment.
use Illuminate\Database\Eloquent\Model;

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
