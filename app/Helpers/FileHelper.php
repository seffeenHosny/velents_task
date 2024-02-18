<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FileHelper
{

    #region upload to Storage methods, USED NOW
    public static function upload_file($folder_path, $image)
    {
        $url = $image->store($folder_path);
        $folderPath = storage_path("app/public/$folder_path");
        File::chmod($folderPath, 0777);
        return $url;
    }

    public static function update_file($folder_path, $image, $old_image)
    {
        if (!empty($old_image)) {
            self::delete_file($old_image);
        }

        $url = self::upload_file($folder_path, $image);
        return $url;
    }

    public static function delete_file($picture)
    {
        if (Storage::exists($picture)) {
            Storage::delete($picture);
            return true;

        } else {
            return false;
        }
    }


    public static function delete_directory($path)
    {
        if ($path != null) {
            Storage::deleteDirectory($path);
        }
    }
}
