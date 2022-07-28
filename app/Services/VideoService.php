<?php 
    
namespace App\Services;

use App\Models\Video;
use getID3;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class VideoService{
    public function storeVideo(Request $request){
        try {
            //input new video
            $video = $request->file('video');
            //call function getID3
            $getID3 = new getID3();
            //name video
            $videoName = date('YmdHis') . "." . $video->getClientOriginalExtension();
            //path video
            $path = 'video/' . $request->get('type_id');

            if(!File::isDirectory(public_path('storage/' . $path))){
                File::makeDirectory(public_path('storage/' . $path));
            }
            $video->storeAs($path . "/", $videoName, ['disk' => 'public']);
            //duration video
            $file = $getID3->analyze($video);
            $duration = "00:" . $file['playtime_string'];
            //extension video
            $fileExt = $video->extension();
            //size video
            $fileSize = $video->getSize();

            //add function/logic to input and create
            $input['name'] = $videoName;
            $input['path'] = $path . "/" . $videoName;
            $input['size'] = $fileSize;
            $input['ext'] = $fileExt;
            $input['duration'] = $duration;

            $vid = Video::create($input);

            return [
                'status' => true,
                'message' => $path,
                'data' => $vid,
                'id' => $vid->id
            ];
        } catch (QueryException $e) {
            return [
                'status' => false,
                'message' => $e,
            ];
        }   
        
    }

    public function updateVideo(Request $request, $fileBefore){
        try {
            //delete photo first
            Storage::disk('public')->delete($fileBefore);
            //input new video
            $video = $request->file('video');
            //call function getID3
            $getID3 = new getID3();
            //name video
            $videoName = date('YmdHis') . "." . $video->getClientOriginalExtension();
            //path video
            //path video
            $path = 'video/' . $request->get('type_id');

            if(!File::isDirectory(public_path('storage/' . $path))){
                File::makeDirectory(public_path('storage/' . $path));
            }
            $video->storeAs($path . "/", $videoName, ['disk' => 'public']);
            //duration video
            $file = $getID3->analyze($video);
            $duration = "00:" . $file['playtime_string'];
            //extension video
            $fileExt = $video->extension();
            //size video
            $fileSize = $video->getSize();

            //add function/logic to input and create
            $input['name'] = $videoName;
            $input['path'] = $path;
            $input['size'] = $fileSize;
            $input['ext'] = $fileExt;
            $input['duration'] = $duration;

            $vid = Video::create($input);

            return [
                'status' => true,
                'message' => $path,
                'data' => $vid,
                'id' => $vid->id
            ];
        } catch (QueryException $e) {
            return [
                'status' => false,
                'message' => $e,
            ];
            // dd($e);
        }
        
    }

    public function deleteImage($fileBefore){
        try {
            Storage::disk('public')->delete($fileBefore);
            return true;
        } catch (QueryException $e) {
            return $e;
        }
    }
}