<?php

namespace App;
use App\Setting;
use Config;
use Intervention\Image\ImageManagerStatic as Image;
class ImageHandler {

	public static function uploadImage($image, $folder, $filename = '', $type = 'upload'){
		return call_user_func( Config::get('site.media_upload_function'), array('image' => $image, 'folder' => $folder, 'filename' => $filename, 'type' => $type) );
	}

	public static function upload($args){

		$image 		= $args['image'];
		$folder 	= $args['folder'];
		$filename 	= $args['filename'];
		$type 		= $args['type'];

		if($folder == 'images'){
			$month_year = date('FY').'/';
		} else {
			$month_year = '';
		}

		$upload_folder = 'public/content/files/' . $folder . '/'.$month_year;
		if ( @getimagesize($image) ){
			// if the folder doesn't exist then create it.
			if (!file_exists($upload_folder)) {
				mkdir($upload_folder, 0777, true);
			}

			if($type =='upload'){

				$filename =  str_replace(" ", "-", $image->getClientOriginalName());
				// if the file exists give it a unique name
				while (file_exists($upload_folder.$filename)) {
					$filename =  uniqid() . '-' . $filename;
				}

				$uploadSuccess = $image->move($upload_folder, $filename);

				if(strpos($filename, '.gif') > 0){
					$new_filename = str_replace('.gif', '-animation.gif', $filename);
					copy($upload_folder . $filename, $upload_folder . $new_filename);
				}
			} else if($type = 'url'){
				
				$file = file_get_contents($image);

				if(strpos($image, '.gif') > 0){
					$extension = '-animation.gif';
				} else {
					$extension = '.jpg';
				}

				$filename = str_replace(" ", "-", $filename . $extension);

				if (file_exists($upload_folder.$filename)) {
					$filename =  uniqid() . '-' . $filename . $extension;
				}

			    if(strpos($image, '.gif') > 0){
					file_put_contents($upload_folder.$filename, $file);
					$filename = str_replace('-animation.gif', '.gif', $filename);
				}
			    file_put_contents($upload_folder.$filename, $file);
			}

			$settings = Setting::first();

			$img = Image::make($upload_folder . $filename);

			if($folder == 'images'){
				$img->resize(1000, null, true);
			} else if($folder == 'avatars'){
				$img->resize(200, 200, false);
			}

			//if($settings->enable_watermark && $folder == 'images'){
			if($folder == 'images'){
				$img->insert(Config::get('site.uploads_dir') . '/settings/' . $settings->watermark_image, $settings->watermark_offset_x, $settings->watermark_offset_y, $settings->watermark_position);
				$img->save($upload_folder . $filename);
			} else {
				$img->save($upload_folder . $filename);
			}

			return $month_year . $filename;

		} else {
			return false;
		}
	}
}