<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Messenger extends Model
{
    protected $table ='messenger';

    public static $validators = array(
        'msg'   => 'required|min:10',
        'captcha' => 'required|captcha',
    );
    public static $msg = array(
            'msg.required'   => 'Type your messager.',
            'msg.min'   => 'Your messager lenght is < 10 ',
            'captcha.required'   => 'Enter capcha',
            'captcha.captcha'   => 'cThe captcha is Incorrect'
            
        );
}
