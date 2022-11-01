<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WiFi;
use App\Models\StatusRobots;
use DB;
use Hash;

class SettingController extends Controller
{
    //
    //home setting AMR
    public function index() {
        return view('admin.setting.homeSetting'); 
    }

    //home wifi
    public function homeWifi() {
        //Get robots from database
        $listsRobot = StatusRobots::all();
        return view('admin.setting.wifi.homeWifi', compact('listsRobot'));
    }

    //get wifi
    public function getWifi(StatusRobots $robot) {
        //Get robots from database
        $listsWifi = $robot->table_wifi;
        return view('admin.setting.wifi.listsWifi', compact('listsWifi', 'robot'));
    }

    //add wifi
    public function addWifi(Request $request) {
        $request->validate(
            [
                'name' => 'required|unique:table_wifi,name',
                'password' => 'required',
                'ip_master' => 'required',
                'ip_node' => 'required'
            ],
            [
                'name.required' => 'Name is empty',
                'name.unique' => 'Name is used',
                'ip_master.required' => 'Ip master is empty',
                'ip_node.required' => 'Ip node is empty'
            ]
        );

        $wifi = new WiFi();
        $wifi->name = $request->name;
        $wifi->password = Hash::make($request->password);
        $wifi->robot_id = $request->robot_id;
        $wifi->ip_master = $request->ip_master;
        $wifi->ip_node = $request->ip_node;
        $wifi->save();

        return redirect()->route('admin.setting.wifi.getWifi', $request->robot_id)->with('msg', 'Add WiFi Successfully');
    }

    //Delete a WiFi
    public function deleteWifi(WiFi $wifi) {
        $idRobot = $wifi->robot->id;
        WiFi::destroy($wifi->id);
        
        return redirect()->route('admin.setting.wifi.getWifi', $idRobot)->with('msg', 'Delete WiFi Successfully');
    }


    //home users
    public function homeUsers() {
        //Get robots from database
        $listsRobot = StatusRobots::all();
        return view('admin.setting.users.homeUsers', compact('listsRobot'));
    }

    //send IP from users to robot
    public function userSendIp(StatusRobots $robot, Request $request) {
        $request->validate(
            [
                'ip_master' => 'required',
                'ip_node'   => 'required'
            ],
            [
                'ip_master.required' => 'Ip master is empty',
                'ip_node.required'   => 'Ip node is empty'
            ]
        );

        return redirect()->route('admin.setting.ethernet.index')->with('msg', 'Send to '.$robot->serial.' Successfully');
    }

    //home ethernet
    public function homeEthernet() {
        //Get robots from database
        $listsRobot = StatusRobots::all();
        return view('admin.setting.ethernet.homeEthernet', compact('listsRobot'));
    }
}
