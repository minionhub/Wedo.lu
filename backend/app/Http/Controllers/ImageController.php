<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Image;
use Illuminate\Support\Facades\DB;
use App\Models\Project;

class ImageController extends Controller
{
    public function imageUpload(Request $request) {
        if($request->get('image'))
        {
            $image = $request->get('image');
            $name = round(microtime(true) * 1000).'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            if (!file_exists(public_path('images'))) {
                mkdir(public_path('images'), 0777, true);
            }

            \Image::make($request->get('image'))->save(public_path('images/').$name);
        }
        $url = env('APP_URL', 'http://localhost') . '/api/images/' . $name;
        return response()->json(['success' => 'You have successfully uploaded an image', 'url' => $url], 200);
    }

    public function fileUpload(Request $request) {
        $file = Input::file('file');
        $filename = $file->getClientOriginalName();

        $path = hash( 'sha256', time());

        if(Storage::disk('uploads')->put('/'.$filename,  File::get($file))) {
            return response()->json([
                'status' => 'success',
                'url' => env('APP_URL', 'http://localhost') . '/api/uploads/' . $filename
            ], 200);
        }
        return response()->json([
            'status' => 'failure'
        ], 400);
    }

    public function projectFilesUpload(Request $request){
        $file = Input::file('file');
        $user_id = $request->get('user_id');
        $project_id = $request->get('project_id');

        $filename = $file->getClientOriginalName();
        $path = 'uploads/projects/' . $user_id . '/' . $project_id;
        if(!is_dir($path)){
            mkdir($path, 0755, true);
        }
        if(Storage::disk('uploads')->put('\/projects\/' . $user_id . '/' . $project_id . '/' .$filename,  File::get($file))) {
            $files = DB::table('projects')->where('project_id', $project_id)->value('attached_files');
            if(strlen($files) < 1){
                $file = array();
                array_push($file, $path . '/' . $filename);
                $files = json_encode($file);
            }else{
                $file = array();
                $file = json_decode($files);
                array_push($file, $path . '/' . $filename);
                $files = json_encode($file);
            }
            DB::table('projects')->where('project_id', $project_id)->update(['attached_files' => $files]);
            return response()->json([
                'status' => 'success'
            ], 200);
        }
        return response()->json([
            'status' => 'failure'
        ], 400);
    }
}
