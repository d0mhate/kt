<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title','body','status'];
    protected $hidden = ['updated_at','created_at','id'];
}
