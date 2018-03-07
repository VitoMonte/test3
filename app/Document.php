<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
	protected $fillable = [
        'title', 'file_puth', 'user_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
}
