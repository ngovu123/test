<?php

namespace App\Http\Controllers;
use App\User;
use Mail, View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller as BaseController;

class ContactController extends BackendController {
	public function index(){
		return view('contact.contactus');
	}
	public function sendcontact(Request $request){
		$validator = Validator::make(
            Input::only('contact_name', 'contact_email','contact_messages'),
            User::$validators
        );
        if ($validator->fails())
        {
            return Redirect::back()->withInput()->withErrors($validator);
        }
        else {
            
            $data = array(
                'contact_name' =>Input::get('contact_name'),
                'contact_email'=>Input::get('contact_email'),
                'contact_messages'=>Input::get('contact_messages'),
                );

            Mail::send('contact.sendcontact', $data, function($message){
                $admin = User::where('name', '=', 'admin')->first();
                $message->from(Input::get('contact_email'), Input::get('contact_name'));
                $message->to($admin->email)->subject('New Contact Email');
            });            
            $request->session()->flash('flash_message', 'Thanks for contacting us! We\'ll be in touch soon.');
            $request->session()->flash('flash_type', 'alert-success');
            //return Redirect::to('/contact')->with('success', 'Thanks for contact us!');
            return redirect()->route('contact');
        }
	}
}