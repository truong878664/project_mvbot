<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StatusRobots;
use App\Models\Maps;

class MapsController extends Controller
{
    //home tracking robot in maps
    public function index() {
        return view('admin.maps.homeMaps');
    }

    //listsMap of AMR
    public function listMaps() {
        //update maps in folder
        $path = public_path('admins/maps');
        $files = \File::allFiles($path);

        $fileNames = [];
        $fileNamesDB = [];  

        foreach ($files as $file) {
            array_push($fileNames, pathinfo($file)['filename']);
        }
        

        $nameMaps = Maps::all('name');
        foreach ($nameMaps as $name) {
            array_push($fileNamesDB, $name->name);
        }

        foreach ($fileNames as $index => $name) {
            if (!in_array($name, $fileNamesDB)) {
                $map = new Maps();
                $map->name = $name;
                $map->path = $path.'/'.$name.'.yaml';
                $map->save();
            }
            else {
                continue;
            }
        }

        $maps = Maps::all();
        $listsRobot = StatusRobots::all();

        return view('admin.maps.listMaps', compact('maps', 'listsRobot'));
    }

    //Send map to robot
    public function sendMapRobot(Request $request) {
        $request->validate(
            [   
                'name_action' => ['required', function($attribute, $value, $fail) {
                    if ($value == 0) {
                        $fail('Please choose a action');
                    }
                }],

                'name_robot' => ['required', function($attribute, $value, $fail) {
                    if ($value == 0) {
                        $fail('Please choose a group');
                    }
                }]
            ],
            [
                'name_robot.required' => 'Group mission is empty',
                'name_action.required'   => 'Name action is empty'
            ]
        );

        return redirect()->route('admin.maps.list.index')->with('msg', 'Send to Robot Successfully'); 
    }

    //Mapping AMR
    public function mapping() {
        //Get robots from database
        $listsRobot = StatusRobots::all();
        return view('admin.maps.mappingTool', compact('listsRobot'));
    }

    //Control Mapping AMR
    public function controllerMapping(StatusRobots $robot) {
        //Get robots from database
        return view('admin.maps.controllerMapping', compact('robot'));
    }

    //Save Mapping AMR
    public function saveMapping(Request $request, StatusRobots $robot) {
        //Save Mapping
        $request->validate(
            [
                'name' => 'required',
            ],
            [
                'name.required' => 'Name is empty',
            ]
        );
        return redirect()->route('admin.maps.mapping.controllerMapping', $robot)->with('msg', 'Add Group Successfully');
    }
}
