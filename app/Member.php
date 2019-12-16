<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'id', 'imagename', 'member_info','user_id'
    ];
    public $incrementing = false;
    public function user() {
        return $this->belongsTo(User::class);
    }
}