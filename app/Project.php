<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'url', 'user_id'];

    public function getGroupKeyword()
    {
        return str_replace("/","",parse_url($this->url, PHP_URL_PATH));
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
