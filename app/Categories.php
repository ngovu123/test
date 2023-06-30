<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $table = 'categories';

	// protected $fillable = array('name', 'url_slug', 'order');
    public static $validators = array(
        'name'   => 'required|min:3|unique:categories',
        'url_slug'  => 'required',
        'order'  => 'required');

    public function media(){
		return $this->hasMany('App\Media');
	}
}
