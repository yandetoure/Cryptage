<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'content', 'file', 'user_id'];

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = encrypt($value);
    }

    public function getTitleAttribute($value)
    {
        return decrypt($value);
    }

    public function setContentAttribute($value)
    {
        $this->attributes['content'] = encrypt($value);
    }

    public function getContentAttribute($value)
    {
        return decrypt($value);
    }
}

