<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * The attributes that are mass assignable.
     * 
     * @var array
     */
    protected $fillable = [
        'user_id', 'created_by', 'subject', 'comment', 'rating'
    ];

    /**
     * Get the user that owns the comment.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the candidate that owns the comment.
     */
    public function candidate()
    {
        return $this->belongsTo(Candidate::class)->orderBy('created_at', 'DESC');
    }
}
