<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{

    /**
     * The attributes that are mass assignable.
     * 
     * @var array
     */
    protected $fillable = [
        'uuid', 'name', 'email', 'web_address', 'cover_letter', 'resume_path', 'is_working', 'visitor', 'location'
    ];

    /**
     * Get the comments for the blog post.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy('created_at', 'DESC');
    }
}
