<?php

namespace App;
use App\Notifications\AdminsResetPasswordNotification;

class Admin_users extends User
{
    protected $table ='admin_users';

       /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminsResetPasswordNotification($token));
    }
}
