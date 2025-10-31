<?php

namespace App\traits;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

trait ImageUploadTrait
{
    protected $image_path = 'app/public/images/covers';
    protected $img_height = 600;
    protected $img_width = 600;

    public function uploadImage($img)
    {
        $img_name = $this->imageName($img);
        $manager = new ImageManager(new Driver());
        $manager->read($img)->resize($this->img_height, $this->img_width)->save(storage_path($this->image_path . '/' . $img_name));
        return 'images/covers/' . $img_name;
    }

    public function imageName($img)
    {
        return time() . '-' . $img->getClientOriginalName();
    }
}
