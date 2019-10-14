<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $guarded = [];

    public function profileImage()
    {
        if ($this->image) {
            return $this->image;
        } else {
            return "https://spyfreestagram.s3.eu-central-1.amazonaws.com/profile/blank.png";
        }
    }

    public function followers()
    {
        return $this->belongsToMany(User::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
