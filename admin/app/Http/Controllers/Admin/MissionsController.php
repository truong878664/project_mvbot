<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StatusRobots;
use App\Models\Points;
use App\Models\GroupsMissions;
use App\Models\StepsMissions;

class MissionsController extends Controller
{
    //home missions
    public function index() {
        return view('admin.missions.homeMissions');
    }

    //home points
    public function points() {
        //Get robots from database
        $listsRobot = StatusRobots::all();
        return view('admin.missions.points.homePoints', compact('listsRobot'));
    }

    //create points
    public function createPoints(StatusRobots $robot) {
        return view('admin.missions.points.createPoints', compact('robot'));
    }

    //save points
    public function savePoints(Request $request, StatusRobots $robot) {
        $request->validate(
            [
                'name' => 'required|unique:points,name',
                'describe' => 'required',
                'type_point' => 'required'
        
            ],
            [
                'name.required' => 'Name is empty',
                'name.unique' => 'Name is used',
                'describe.required' => 'Describe is empty',
                'type_point.required' => 'Type Point is empty'
            ]
        );

        $point = new Points();
        $point->name = $request->name;
        $point->positionX = $request->position_x;
        $point->positionY = $request->position_y;
        $point->rotationZ = $request->rotation_dw.'|'.$request->rotation_dz;
        $point->describe = $request->describe;
        $point->type = $request->type_point;
        $point->robot_id = $robot->id;
        $point->save();

        return redirect()->route('admin.missions.points.createPoints', $robot)->with('msg', 'Save Point Successfully');
    }

    public function deletePoint(Points $point) {
        Points::destroy($point->id);
        return redirect()->route('admin.missions.steps.index')->with('msg', 'Delete Point Successfully');
    }

    //create steps of mission
    public function steps() {
        $points = Points::all();
        $groupMissions = GroupsMissions::all();
        $listsRobot = StatusRobots::all();

        //List functions
        $listFunctions = [
            'primary'   => 'If',
            'secondary' => 'Else',
            'warning'   => 'EndIf',
            'danger'    => 'TryCatch',
            'success'   => 'Footprint',
            'info'      => 'IO'
        ];

        //List action 
        $listActions = [
            'primary' => "Music",
            'success' => 'Sleep',
            'warning' => 'Warning',
            'info'    => 'Timeout'
            
        ];

        return view('admin.missions.createMissions', compact('points', 'groupMissions', 'listFunctions', 'listActions', 'listsRobot'));
        
    }

    //add groupMissions
    public function addGroups(Request $request) {
        $request->validate(
            [
                'name' => 'required|unique:groups_missions,name'
            ],
            [
                'name.required' => 'Name is empty',
                'name.unique' => 'Name is used'
            ]
        );

        $group = new GroupsMissions();
        $group->name = $request->name;
        $group->save();
        return redirect()->route('admin.missions.steps.index')->with('msg', 'Create Group Successfully');
    }

    //delete a group missions
    public function deleteGroup(GroupsMissions $group) {
        GroupsMissions::destroy($group->id);
        
        return redirect()->route('admin.missions.steps.index')->with('msg', 'Delete Group Successfully');
    }

    //Add Points to Groups
    public function addPointGroups(Points $point, Request $request) {
        $request->validate(
            [
                'group_mission' => ['required', function($attribute, $value, $fail){
                    if ($value == 0) {
                        $fail('Please Choose a Group');
                    }
                }]
            ],
            [
                'group_mission.required' => 'Group Mission is empty'
            ]
        );
        $group = GroupsMissions::where('name', $request->group_mission)->first();
        // $group->steps = $point;
        $step = [
            $point->name => ($point->name).'|'.($point->type).'|'.($point->positionX).'|'.($point->positionY).'|'.($point->rotationZ)
        ];
        
        if ($group->steps) {
            $group->steps = $group->steps.'@'.$step[$point->name];
            $group->save();
            return redirect()->route('admin.missions.steps.index')->with('msg', 'Add Point Successfully'); 
        } else {
            $group->steps = $step[$point->name];
            $group->save();

            return redirect()->route('admin.missions.steps.index')->with('msg', 'Add Point Successfully'); 
        }
    }

    //Add Music to Groups
    public function addMusicGroups(Request $request) {
        $request->validate(
            [   
                'name_music' => 'required',
                'group_mission' => ['required', function($attribute, $value, $fail){
                    if ($value == 0) {
                        $fail('Please Choose a Group');
                    }
                }]
            ],
            [
                'name_music.required' => 'Time is empty',
                'group_mission.required' => 'Group Mission is empty'
            ]
        );
        $group = GroupsMissions::where('name', $request->group_mission)->first();
        // $group->steps = $point;
        $sleep = [
            $request->name_action => ($request->name_action).'|'.'primary'.'|'.($request->name_music)
        ];
        
        if ($group->steps) {
            $group->steps = $group->steps.'@'.$sleep[$request->name_action];
            $group->save();
            return redirect()->route('admin.missions.steps.index')->with('msg', 'Add Music Successfully'); 
        } else {
            $group->steps = $sleep[$request->name_action];
            $group->save();

            return redirect()->route('admin.missions.steps.index')->with('msg', 'Add Music Successfully'); 
        }
    }


    //Add Sleep to Groups
    public function addSleepGroups(Request $request) {
        $request->validate(
            [
                'time_sleep' => 'required',
                'group_mission' => ['required', function($attribute, $value, $fail){
                    if ($value == 0) {
                        $fail('Please Choose a Group');
                    }
                }]
            ],
            [
                'time_sleep.required' => 'Time Sleep is empty',
                'group_mission.required' => 'Group Mission is empty'
            ]
        );
        $group = GroupsMissions::where('name', $request->group_mission)->first();
        // $group->steps = $point;
        $music = [
            $request->name_action => ($request->name_action).'|'.'success'.'|'.($request->time_sleep)
        ];
        
        if ($group->steps) {
            $group->steps = $group->steps.'@'.$music[$request->name_action];
            $group->save();

            return redirect()->route('admin.missions.steps.index')->with('msg', 'Add Sleep Successfully'); 
        } else {
            $group->steps = $music[$request->name_action];
            $group->save();

            return redirect()->route('admin.missions.steps.index')->with('msg', 'Add Sleep Successfully'); 
        }
    }

    //Add Warning to Groups
    public function addWarningGroups(Request $request) {
        $request->validate(
            [
                'signal' => 'required',
                'group_mission' => ['required', function($attribute, $value, $fail){
                    if ($value == 0) {
                        $fail('Please Choose a Group');
                    }
                }]
            ],
            [
                'signal.required' => 'Signal is empty',
                'group_mission.required' => 'Group Mission is empty'
            ]
        );
        $group = GroupsMissions::where('name', $request->group_mission)->first();
        // $group->steps = $point;
        $signal = [
            $request->name_action => ($request->name_action).'|'.'warning'.'|'.($request->signal)
        ];
        
        if ($group->steps) {
            $group->steps = $group->steps.'@'.$signal[$request->name_action];
            $group->save();

            return redirect()->route('admin.missions.steps.index')->with('msg', 'Add Signal Successfully'); 
        } else {
            $group->steps = $signal[$request->name_action];
            $group->save();

            return redirect()->route('admin.missions.steps.index')->with('msg', 'Add Signal Successfully'); 
        }
    }

    //Add Timeout to Groups
    public function addTimeoutGroups(Request $request) {
        $request->validate(
            [
                'number' => 'required',
                'group_mission' => ['required', function($attribute, $value, $fail){
                    if ($value == 0) {
                        $fail('Please Choose a Group');
                    }
                }]
            ],
            [
                'number.required' => 'Number is empty',
                'group_mission.required' => 'Group Mission is empty'
            ]
        );
        $group = GroupsMissions::where('name', $request->group_mission)->first();
        // $group->steps = $point;
        $number = [
            $request->name_action => ($request->name_action).'|'.'info'.'|'.($request->number)
        ];
        
        if ($group->steps) {
            $group->steps = $group->steps.'@'.$number[$request->name_action];
            $group->save();

            return redirect()->route('admin.missions.steps.index')->with('msg', 'Add Number Successfully'); 
        } else {
            $group->steps = $number[$request->name_action];
            $group->save();

            return redirect()->route('admin.missions.steps.index')->with('msg', 'Add Number Successfully'); 
        }
    }
    

    //Add If to Groups
    public function addIfGroups(Request $request) {
        $request->validate(
            [
                'group_mission' => ['required', function($attribute, $value, $fail){
                    if ($value == 0) {
                        $fail('Please Choose a Group');
                    }
                }]
            ],
            [
                'group_mission.required' => 'Group Mission is empty'
            ]
        );
        $group = GroupsMissions::where('name', $request->group_mission)->first();
        
        $if = [
            $request->name_function => ($request->name_function).'|'.'primary'
        ];

        if ($group->steps) {
            $group->steps = $group->steps.'@'.$if[$request->name_function];
            $group->save();

            return redirect()->route('admin.missions.steps.index')->with('msg', 'Add If Successfully'); 
        } else {
            $group->steps = $if[$request->name_function];
            $group->save();

            return redirect()->route('admin.missions.steps.index')->with('msg', 'Add If Successfully'); 
        }
    }

    //Add Else to Groups
    public function addElseGroups(Request $request) {
        $request->validate(
            [
                'group_mission' => ['required', function($attribute, $value, $fail){
                    if ($value == 0) {
                        $fail('Please Choose a Group');
                    }
                }]
            ],
            [
                'group_mission.required' => 'Group Mission is empty'
            ]
        );
        $group = GroupsMissions::where('name', $request->group_mission)->first();
        
        $if = [
            $request->name_function => ($request->name_function).'|'.'secondary'
        ];

        if ($group->steps) {
            $group->steps = $group->steps.'@'.$if[$request->name_function];
            $group->save();

            return redirect()->route('admin.missions.steps.index')->with('msg', 'Add Else Successfully'); 
        } else {
            $group->steps = $if[$request->name_function];
            $group->save();

            return redirect()->route('admin.missions.steps.index')->with('msg', 'Add Else Successfully'); 
        }
    }

    //Add IO to Groups
    public function addIOGroups(Request $request) {
        $request->validate(
            [
                'group_mission' => ['required', function($attribute, $value, $fail){
                    if ($value == 0) {
                        $fail('Please Choose a Group');
                    }
                }]
            ],
            [
                'group_mission.required' => 'Group Mission is empty'
            ]
        );
        $group = GroupsMissions::where('name', $request->group_mission)->first();
        
        $if = [
            $request->name_function => ($request->name_function).'|'.'info'.'|'.($request->io_1)

        ];
        if ($group->steps) {
            $group->steps = $group->steps.'@'.$if[$request->name_function];
            $group->save();

            return redirect()->route('admin.missions.steps.index')->with('msg', 'Add IO Successfully'); 
        } else {
            $group->steps = $if[$request->name_function];
            $group->save();
            return redirect()->route('admin.missions.steps.index')->with('msg', 'Add IO Successfully'); 
        }
    }

    //Add EndIf to Groups
    public function addEndIfGroups(Request $request) {
        $request->validate(
            [
                'group_mission' => ['required', function($attribute, $value, $fail){
                    if ($value == 0) {
                        $fail('Please Choose a Group');
                    }
                }]
            ],
            [
                'group_mission.required' => 'Group Mission is empty'
            ]
        );
        $group = GroupsMissions::where('name', $request->group_mission)->first();
        
        $if = [
            $request->name_function => ($request->name_function).'|'.'warning'
        ];

        if ($group->steps) {
            $group->steps = $group->steps.'@'.$if[$request->name_function];
            $group->save();

            return redirect()->route('admin.missions.steps.index')->with('msg', 'Add EndIf Successfully'); 
        } else {
            $group->steps = $if[$request->name_function];
            $group->save();

            return redirect()->route('admin.missions.steps.index')->with('msg', 'Add EndIf Successfully'); 
        }
    }

    //Add TryCatch to Groups
    public function addTryCatchGroups(Request $request) {
        $request->validate(
            [
                'group_mission' => ['required', function($attribute, $value, $fail){
                    if ($value == 0) {
                        $fail('Please Choose a Group');
                    }
                }]
            ],
            [
                'group_mission.required' => 'Group Mission is empty'
            ]
        );
        $group = GroupsMissions::where('name', $request->group_mission)->first();
        
        $trycatch = [
            $request->name_function => ($request->name_function).'|'.'danger'
        ];

        if ($group->steps) {
            $group->steps = $group->steps.'@'.$trycatch[$request->name_function];
            $group->save();

            return redirect()->route('admin.missions.steps.index')->with('msg', 'Add TryCatch Successfully'); 
        } else {
            $group->steps = $trycatch[$request->name_function];
            $group->save();

            return redirect()->route('admin.missions.steps.index')->with('msg', 'Add TryCatch Successfully'); 
        }
    }

    //Add Points to Groups
    public function addFootPrintGroups(Request $request) {
        $request->validate(
            [   
                'top_width' => 'required',
                'bottom_width' => 'required',
                'top_height' => 'required',
                'bottom_height' => 'required',
                'group_mission' => ['required', function($attribute, $value, $fail){
                    if ($value == 0) {
                        $fail('Please Choose a Group');
                    }
                }]
            ],
            [
                'group_mission.required' => 'Group Mission is empty',
                'top_width.required'     => 'Top Width is empty',
                'top_height.required'    => 'Top Height is empty',
                'bottom_width.required'  => 'Bottom Width is empty',
                'bottom_height.required' => 'Bottom Height is empty'
            ]
        );
        
        $group = GroupsMissions::where('name', $request->group_mission)->first();
        // $group->steps = $point;
        $function = [
            $request->name_function => ($request->name_function).'|'.'success'.'|'.($request->top_width).'|'.($request->bottom_width).'|'
                                        .($request->top_height).'|'.($request->bottom_height)
        ];
        
        if ($group->steps) {
            $group->steps = $group->steps.'@'.$function[$request->name_function];
            $group->save();

            return redirect()->route('admin.missions.steps.index')->with('msg', 'Add Footprint Successfully'); 
        } else {
            $group->steps = $step[$request->name_function];
            $group->save();

            return redirect()->route('admin.missions.steps.index')->with('msg', 'Add Footprint Successfully'); 
        }
    }

    //Send mission to robot
    public function sendMissionToRobot(GroupsMissions $group, Request $request) {
        $request->validate(
            [   
                'time_mission' => 'required',
                'name_robot' => ['required', function($attribute, $value, $fail){
                    if ($value == 0) {
                        $fail('Please choose a group');
                    }
                }]
            ],
            [   
                'time_mission.required' => 'Time Mission is empty',
                'name_robot.required' => 'Name Robot is empty'
            ]
        );
        // $steps = $request->steps__missions;
        $robot = StatusRobots::where('serial', $request->name_robot)->first();
        return redirect()->route('admin.missions.tracking.trackingStepMission', $robot)->with(['steps' => $request->steps__missions])
        ->with(['time__mission' => $request->time_mission])->with('msg', 'Send Robot Successfully');
    }

    //Tracking Missions
    public function trackingMission() {
        //Get robots from database
        $listsRobot = StatusRobots::all();
        return view('admin.missions.trackingMissions', compact('listsRobot'));
    }

    //Tracking Missions
    public function trackingStepMission(StatusRobots $robot) {
        //Get robots from database
        return view('admin.missions.trackingStepMission', compact('robot'));
    }
}
