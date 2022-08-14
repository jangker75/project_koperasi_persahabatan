<?php

namespace App\Services;

use App\Models\Image;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

/**
 * Class DynamicImageService
 * @package App\Services
 */
class DynamicImageService
{
    public function uploadImage($image, $path)
    {
        try {
            if ($image && $path) {
                $imageName = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->storeAs('public/' . $path, $imageName);
                $path =  $path . '/' . $imageName;
                return $path;
            } else {
                return null;
            }
        } catch (\Throwable $e) {
            echo 'Image Helper saveImage ' . $e->getMessage();
        }
    }

    public function upload(String $name, Request $request, String $module, String $alternate)
    {
        try {
            $image = $request->file($name);
            $imageName = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $path =  $name . '/' . $module . '/' . $imageName;
            $image->storeAs($name . '/' . $module . '/', $imageName, ['disk' => 'public']);
            $size = $image->getSize();
            $extension = $image->getClientOriginalExtension();

            
            return [
                'status' => 'success',
                'path' => $path,
            ];
        } catch (QueryException $e) {
            return [
                'status' => false,
                'message' => $e
            ];
        }
    }

    public function update(String $name, Request $request, String $module, String $alternate, $pathbefore){
        try {
            Storage::disk('public')->delete($pathbefore);
            $image = $request->file($name);
            $imageName = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $path =  $name . '/' . $module . '/' . $imageName;
            $image->storeAs($name . '/' . $module . '/', $imageName, ['disk' => 'public']);
            $size = $image->getSize();
            $extension = $image->getClientOriginalExtension();

            // dd($image);
            return [
                'status' => 'success',
                'path' => $path,
            ];
        } catch (QueryException $e) {
            return [
                'status' => false,
                'message' => $e
            ];
        }
    }

    public function delete($pathbefore)
    {
        try {
            Storage::disk('public')->delete($pathbefore);
            return true;
        } catch (QueryException $e) {
            return $e;
        }
    }

    public function showImage($filename = 'noname.jpg')
    {
        // $path = $folder.'/'.$filename;
        $filename = trim($filename);
        $exists = Storage::disk('public')->exists($filename);
        
        if($exists) {
        //     //get content of image
            $content = Storage::get('public/'.$filename);
            
        //     //get mime type of image
            $mime = Storage::mimeType('public/'.$filename);
        //     //prepare response with image content and response code
            $response = Response::make($content, 200);
        //     //set header 
            $response->header("Content-Type", $mime);
        //     // return response
            return $response;
        } else {
        // abort(404);
           return $this->getDefaultImage();
        }
    }
    protected function getDefaultImage()
    {
        $content = Storage::get(config('constant.NO_IMAGE_DEFAULT'));
        $mime = Storage::mimeType(config('constant.NO_IMAGE_DEFAULT'));
        $response = Response::make($content, 200);
        $response->header("Content-Type", $mime);
        return $response;
    }
}
