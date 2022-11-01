<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sound;

class SoundsController extends Controller
{
    //home sounds
    public function index() {
        //update sounds in folder
        $path = public_path('admins/sounds');
        $files = \File::allFiles($path);

        $fileNames = [];
        $fileNamesDB = [];

        foreach ($files as $file) {
            array_push($fileNames, pathinfo($file)['filename']);
        }

        $nameSounds = Sound::all('name');
        //dd($fileNames);
        foreach ($nameSounds as $name) {
            array_push($fileNamesDB, $name->name);
        }
        //dd($fileNamesDB);
        foreach ($fileNames as $index => $name) {
            if (!in_array($name, $fileNamesDB)) {
                $sound = new Sound();
                $sound->name = $name;
                $sound->path = $path.'/'.$name.'.mp3';
                $sound->save();
            }
            else {
                continue;
            }
        }
        $listSound = Sound::all();
        // dd($listSound);

        return view('admin.sounds.homeSounds',compact('listSound'));
        //  $listSound = Sound::all();

        // return view('admin.sounds.homeSounds', compact('listSound'));
        // return view('admin.sounds.homeSounds');
    }
}
