<?php

namespace App\Services;

use App\Models\Image;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Class DynamicImageService
 * @package App\Services
 */
class DynamicImageService
{
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
}
