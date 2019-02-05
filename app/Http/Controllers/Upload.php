<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use App\File;
class Upload extends Controller
{
    /**
     * $request, $path,$upload_type = 'single', $delete_file = null, $new_name = null, $crud_type = []
     */


    public function delete()
    {
        $file = File::find($id);
        if(!empty($file))
        {
            Storage::delete($file->full_file);
            $file->delete();
        }
    }



    public static function upload($data = [])
    {
        if(in_array('new_name', $data)){

            $new_name = $data['new_name'] === null ? time() : $data['new_name'];
        }
        if(request()->hasFile($data['file']) && $data['upload_type'] == 'single')
        {
            Storage::has($data['delete_file']) ? Storage::delete($data['delete_file']) : '';
            return request()->file($data['file'])->store($data['path']);
        }elseif(request()->hasFile($data['file']) && $data['upload_type'] == 'files'){
            Storage::has($data['delete_file']) ? Storage::delete($data['delete_file']) : '';
           $file = request()->file($data['file']);

           $size        = $file->getSize();
            $mime_type  = $file->getMimeType();
            $name       = $file->getClientOriginalName();
            $hash_name  = $file->hashName();
           $file->store($data['path']);
            $add = File::create([
                'name'          => $name,
                'size'          => $size,
                'file'          => $hash_name,
                'path'          => $data['path'],
                'full_file'     => $data['path'] . '/' . $hash_name,
                'mime_type'     => $mime_type,
                'file_type'     => $data['file_type'] ,
                'relation_id'   => $data['relation_id'],
                'delete_file'   => '',
            ]);
            return $data['path'] . '/' . $hash_name;
        }

    }
}
