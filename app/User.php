<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
     protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','last_name','slug', 'email', 'password','address','phone','cash','pay_id','avata_img'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];
    public static $validators = array(
        'contact_name'   => 'required|min:3',
        'contact_email'  => 'required|min:6|email',
        'contact_messages'  => 'required|min:6');
}
