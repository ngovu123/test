<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Download_log extends Model
{
    protected $table = 'download_log';
	public function media()
 	{
		return $this->belongsTo('App\Media','media_id');
	}
}