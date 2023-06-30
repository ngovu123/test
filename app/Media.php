<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'media';
	protected $fillable = array('title','upimage', 'category', 'description');
    public static $validators = array(
        'title'   => 'required|min:3',
        'upimage'  => 'required',
        'description'  => 'required|min:6'
    );

    public static $validators_1 = array(
        'title'   => 'required|min:3',        
        'description'  => 'required|min:6'
    );

    public function categories(){
		return $this->hasMany('App\Categories');
	}
    public function images_preview()
    {
        return $this->hasMany('App\Images_preview','media_id');
    }
    public function download_log(){
        return $this->hasMany('App\Download_log','media_id');
    }
}
