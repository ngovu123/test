<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Images_preview extends Model
{
    protected $table = 'images_preview';
    protected $guarded =[];

	public function media()
    {
        return $this->belongsTo('App\Media','media_id');
    }
}
