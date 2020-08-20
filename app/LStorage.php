<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use ImageIntr;
use Storage;

class LStorage extends Model
{
    private $_image;

    /**
     * constructor
     * 
     */
    public function __construct($image = null){
        $this->_image = $image;
    }


    /**
     * crop photos
     * 
     * @param object image
     * @param int width
     * @param int height
     * 
     * @return object
     */
    public function cropPhoto($image = null, $w = 500, $h = null){
        if(!isset($image) || !Storage::disk('public')->exists($image) || !isset($w))
            return null;

        $image = "storage/".$image;
        $img = ImageIntr::make($image);

        // resize the image so that the largest side fits within the limit; the smaller
        // side will be scaled to maintain the original aspect ratio
        $img->resize($w, $h, function ($constraint) {
            $constraint->aspectRatio();
        });

        return $img;
    }

    /**
     * save photos to local storage "{publisher}/{article}/{aspectratio}/image"
     * saves multiple copies at different sizes
     * 
     * @param int pub
     * @param int art
     * @param string image
     * 
     * @return bool
     */
    public function savePhoto($pub = null, $art = null, $img = null){
        $image = null;

        if(isset($this->_image))
            $image = $this->_image;
            
        if(isset($img))
            $image = $img;

        if(!isset($image) 
            || (!isset($pub) || gettype($pub) !== "integer" ) 
            || (!isset($art) || gettype($art) !== "integer"))
            return null;

        // get image content from the web
        $contents = file_get_contents($image);


        if(!isset($contents))
            return null;

        // get the last url param 
        $name = explode('/', $image)[count(explode('/', $image)) - 1];
        // get the image extenssion
        $ext = explode('.', $name)[count(explode('.', $name)) - 1];
        // some image links don't have the extention at the end 
        // so we get it from the web
        if(!in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])){
            $size = getimagesize($image);
            $ext = image_type_to_extension($size[2]);
        }

        // full name of photo
        $name = substr(md5(time()), 1) . '.' . $ext;


        // save the original image
        $org_path = "images/$pub/$art/original/$name";
        Storage::disk("public")->put($org_path, $contents);

        // get the image sizes from configuration
        $sizes = config('capp.images.sizes');

        // small
        $sm_path = "images/$pub/$art/small/$name";
        $small_img = $this->cropPhoto($org_path, (int)$sizes["small"]);
        $small_img->save("storage/temp.jpg");
        Storage::disk("public")->put($sm_path, $small_img);

        // medium
        $md_path = "images/$pub/$art/medium/$name";
        $medium_img = $this->cropPhoto($org_path, (int)$sizes["medium"]);
        $medium_img->save("storage/temp.jpg");
        Storage::disk("public")->put($md_path, $medium_img);

        // large
        $lg_path = "images/$pub/$art/large/$name";
        $large_img = $this->cropPhoto($org_path, (int)$sizes["large"]);
        $large_img->save("storage/temp.jpg");
        Storage::disk("public")->put($lg_path, $large_img);

        Storage::disk("public")->delete("temp.jpg");
        
        return $name;
    }
}
