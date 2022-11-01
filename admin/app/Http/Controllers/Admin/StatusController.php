<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StatusRobots;

class StatusController extends Controller
{
    //home status AMR
    public function index() {
        $listRobots = StatusRobots::all();
        return view('admin.status.homeStatus', compact('listRobots'));
    }

    //create API status AMR
    public function indexApi() {
        return StatusRobots::all();
    }

    //Add robot to database
    public function addRobot(Request $request) {
        $robot = StatusRobots::where('serial', $request->serial)->first();
        if ($robot) {
            $robot->serial = $request->serial;
            $robot->mode = $request->mode;
            $robot->volt_pin = $request->volt_pin;
            $robot->percent_pin = $request->percent_pin;
            $robot->radar1 = $request->radar1;
            $robot->radar2 = $request->radar2;
            $robot->camera1 = $request->camera1;
            $robot->camera2 = $request->camera2;
            $robot->I = $request->I;
            $robot->charging = $request->charging;
            $robot->cell = $request->cell;
            $robot->option = $request->option;
            $robot->save();
            return view('admin.dashboard');
        } else {
            $robot = new StatusRobots();
            $robot->serial = $request->serial;
            $robot->mode = $request->mode;
            $robot->volt_pin = $request->volt_pin;
            $robot->percent_pin = $request->percent_pin;
            $robot->radar1 = $request->radar1;
            $robot->radar2 = $request->radar2;
            $robot->camera1 = $request->camera1;
            $robot->camera2 = $request->camera2;
            $robot->I = $request->I;
            $robot->charging = $request->charging;
            $robot->cell = $request->cell;
            $robot->option = $request->option;
            $robot->save();
            return view('admin.dashboard');
        }
    }
}
