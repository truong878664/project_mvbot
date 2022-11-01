@extends('layouts.admin')

@section('title', 'Maps - Mapping - Controller')

@section('content')
    {{-- Alert message with danger: Start --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <div class="alert-message">
                <strong>Hello there!</strong> Please check data enter!
            </div>
        </div>
    @endif
    {{-- Alert message with danger: End --}}

    {{-- Alert message with action success: Start --}}
    @if (session('msg'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <div class="alert-message">
                <strong>Hello there!</strong> {{session('msg')}}!
            </div>
        </div>
    @endif
    {{-- Alert message with action success: End --}}

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-10">
        <h1 class="h1 mb-0 text-gray-800">Maps - Controller Mapping - {{$robot->serial}}</h1>
    </div>

    <p>
        <button type="button" class="btn btn-primary fs-2" data-bs-toggle="modal" data-bs-target="#saveMap" 
            style="margin-top: 48px;">
            <i class="align-middle me-2 fas fa-fw fa-plus"></i>
            Save Map
        </button>
    </p>

    {{-- Tag display mapp: Start --}}
    <div class="row" id="mapping__content" style="margin-top: 48px;">
        <input hidden type="text" id="e__name__robot" name="name__robot" class="form-control" value="{{$robot->serial}}">
    </div>
    {{-- Tag display mapp: End --}}

    {{-- Modal form save Map: Start --}}
    <div class="modal fade" id="saveMap" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                {{-- Header form add Groups: START --}}
                <div class="modal-header" style="background-color: #4169E1">
                    <h3 class="modal-title" style="margin-left: 115px; font-size: 24px; color: #fff;">Save Mapping of {{$robot->serial}}</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                {{-- Header form add Groups: END --}}
                <form action="{{route('admin.maps.mapping.saveMapping', $robot)}}" method="POST">
                    {{-- FORM ADD Groups: START --}}
                    <div class="card-body">
                        <div class="mb-3" width="80%">
                            <label class="form-label fst-normal">Name Mapping:</label>
                            <input type="text" id="e_name" name="name" class="form-control" placeholder="Enter Name" value="">

                            @error('name') 
                                <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- FOOTER FORM ADD Groups: START --}}
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary button__save">Save Map</button>
                        </div>
                        {{-- FOOTER FORM ADD Groups: END --}}
                    </div>
                    {{-- FORM ADD Groups: END --}}
                    @csrf
                </form>
            </div>
        </div>
    </div>
    {{-- Modal form save Map: End --}}

    @section('script')
        {{-- ACTIVE TOGGLE DASHBOARD: START --}}
        <script>
            document.querySelector('.admin__maps').classList.add('active');
            document.querySelector('.admin__maps__mapping').classList.add('active');
            document.querySelector('.admin__maps__show').classList.add('show');
            document.querySelector('#zone_joystick').classList.remove('inactive_controller');
            document.querySelector('#zone_joystick').classList.add('active_controller');
            console.log(document.querySelector('#zone_joystick').classList);
        </script>
        {{-- ACTIVE TOGGLE DASHBOARD: END --}}

        {{-- CREATE JOYSTICK: START --}}
        <script>
            //Connectting Wifi
            const ros = new ROSLIB.Ros({
                url: 'ws://' + ipServer + ':9090'
            });

            // create map_listener from Robot
            var map_listener = new ROSLIB.Topic({
                ros : ros,
                name : "/map",
                messageType : 'nav_msgs/OccupancyGrid',
                queue_size: 1,
            });
                
            // Setup a client to listen to TFs.
            var tfClient = new ROSLIB.TFClient({
                ros : ros,
                rate : 5,
                fixedFrame : '/map',
                angularThres : 0.08,
                transThres : 0.05,
            });

            // axes origin
            var axes = new ROS3D.Axes({
                scale: 3,
                shaftRadius: 0.025,
                headRadius: 0.05,
            });

            var viewer = new ROS3D.Viewer({
                divID : 'mapping__content',
                width : document.querySelector('#mapping__content').offsetWidth,
                height : 600, 
                background: '#000000',//'#000000', //'#66CDAA',
                antialias : false,
                alpha: 0.5,
                cameraPose: {x:10, y:10, z:20},
            });

            viewer.addObject(axes);

            let nameRobot = jQuery('#e__name__robot').val();

            // Mapping with name Robot Seri
            let gridClient2 = new ROS3D.OccupancyGridClient({
                ros : ros,
                rootObject : viewer.scene,
                continuous: true,
                // continuous: true,
                tfClient: tfClient,
                // topic: '/MB22_916b/move_base/global_costmap/costmap',
                // color: 0xFF0000,
                topic: "/" + nameRobot + '/map',
                // opacity: 0.1,
            });

            //Connecting Robot Controller
            let cmd_vel_listener = new ROSLIB.Topic({
                ros : ros,
                name : "/" + nameRobot,
                messageType : 'geometry_msgs/Twist',
                queue_size: 1,
            });

            let move = function(linear, angular) {
                let twist = new ROSLIB.Message({
                    linear: {
                        x: linear,
                        y: 0,
                        z: 0
                    },
                    angular: {
                        x: 0,
                        y: 0,
                        z: angular
                    }
                });
                cmd_vel_listener.publish(twist);
            }

            createJoystick = function () {
                let options = {
                    zone: document.getElementById('zone_joystick'),
                    threshold: 0.1,
                    position: {
                        left: 100 + 'px', 
                        top: 175 + 'px' 
                    },
                    mode: 'static',
                    size: 125,
                    color: '#000000',
                };

                manager = nipplejs.create(options);

                linear_speed = 0;
                angular_speed = 0;

                self.manager.on('start', function (event, nipple) {
                    // console.log("Movement start");
                    timer = setInterval(function () {
                        move(linear_speed, angular_speed);
                    }, 500);
                });

                self.manager.on('move', function (event, nipple) {
                    // console.log("Moving");
                    max_linear = 0.5; // m/s 0.5;
                    max_angular = 0.314; // rad/s
                    max_distance = 200; // pixels;
                    linear_speed = Math.sin(nipple.angle.radian) * max_linear * nipple.distance/max_distance;
                    angular_speed = -Math.cos(nipple.angle.radian) * max_angular * nipple.distance/max_distance;
                });

                self.manager.on('end', function () {
                    // console.log("Movement end");
                    if (timer) {
                        clearInterval(timer);
                    } 
                    move(0, 0);
                });
            }

            createJoystick();
        </script>
        {{-- CREATE JOYSTICK: END --}}

        {{-- SEND DATA TO ROBOT: START --}}
        <script>
            jQuery(document).on('click', '.button__save', function() {
                // Get value info of robot and wifi
                let nameRobot = jQuery('#e__name__robot').val();
                let nameMap = jQuery('#e_name').val();
                // console.log(nameMap);
                let nameMapping = {
                    "nameMapping": nameMap
                };

                //Connectting Wifi
                const ros = new ROSLIB.Ros({
                    url: 'ws://' + ipServer + ':9090'
                });

                var dataNameMapping = new ROSLIB.Topic({
                    ros : ros,
                    name : "/" + nameRobot + "/saveMapping",
                    messageType : 'std_msgs/String',
                    queue_size: 200,
                });

                //Information
                const infoNameMapping = new ROSLIB.Message({
                    data: JSON.stringify(dataNameMapping),
                });
                
                robotEthernet.publish(infoNameMapping);  
            })
        </script>
        {{-- SEND DATA TO ROBOT: END --}}
    @endsection
@endsection