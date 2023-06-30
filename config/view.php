<?php

return [

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Most templating systems load templates from disk. Here you may specify
    | an array of paths that should be checked for your views. Of course
    | the usual Laravel view path has already been registered for you.
    |
    */

    'paths' => [
        realpath(base_path('resources/views')),
    ],

    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    |
    | This option determines where all the compiled Blade templates will be
    | stored for your application. Typically, this is within the storage
    | directory. However, as usual, you are free to change this value.
    |
    */

    'compiled' => realpath(storage_path('framework/views')),
        
    'rootpath'       =>  url('public/application/assets/'),
    'downloadpath'      =>  'public/content/files/downloads/images/',
    'filepath'          =>  'public/content/files/downloads/images/',
    'downloadfilepath'  =>   'content/files/downloadfile/',
    'settingspath'      =>  url('public/content/files/settings/'),
    'numPage'           =>  12,

];
