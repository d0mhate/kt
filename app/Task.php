<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title', 'body', 'status', 'user_id'];
    protected $hidden = ['updated_at', 'created_at'];
}
