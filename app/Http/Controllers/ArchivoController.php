<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Archivo;
use Illuminate\Support\Facades\Auth;


class ArchivoController extends Controller
{
    public function store(Request $request)
    {
        $file_name = $request->file->getClientOriginalName();
        $request->file->move(storage_path('app'), $file_name);
        $archivo = Archivo::create([
            'filename' => $file_name,
            'user_id' => Auth::id(),
        ]);
        return response($archivo);

        // return json_encode(simplexml_load_string(Storage::get($file_name)));
    }
    public function get($fileName)
    {
        // echo $request;
        // return $fileName;
        return json_encode(simplexml_load_string(Storage::get($fileName)));
    }
}
