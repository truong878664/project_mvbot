@extends('layouts.admin')

@section('title', 'Maps - Missions - Create Points')

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
        <h1 class="h1 mb-0 text-gray-800">Missions - Create Points - {{$robot->serial}}</h1>
    </div>

    {{-- Infor of positions: Start --}}
    <div class="row" style="margin-top: 48px;">
        <div class="mb-3 col-md-4">
            <label class="form-label" for="inputX">Position X</label>
            <input type="text" name="position__x" class="form-control mb-2" id="inputX" value="0">
            <input type="range" name="range__position__x" class="form-range value__positionX" id="customRange1" min="-100" max="100" value="0">
        </div>
        <div class="mb-3 col-md-4">
            <label class="form-label" for="inputY">Position Y</label>
            <input type="text" name="position__y" class="form-control mb-2" id="inputY" value="0">
            <input type="range" name="range__position__y" class="form-range value__positionY" id="customRange1" min="-100" max="100" value="0">
        </div>
        <div class="mb-3 col-md-4">
            <label class="form-label" for="inputZ">Rotation Z</label>
            <input type="text" name="rotation__z" class="form-control mb-2" id="inputZ" value="0">
            <input type="range" name="range__rotation__z" class="form-range" id="customRange1" min="-180" max="180" value="0">
        </div>
    </div>
    {{-- Infor of positions: Start --}}

    {{-- Button save point: Start --}}
    <div class="row" style="margin-top: 20px;">
        <button type="button" class="btn btn-primary fs-2 savePoints" data-bs-toggle="modal" data-bs-target="#savePoints">
            Save Points
        </button>
    </div>
    {{-- Button save point: End --}}

    <div class="row" id="mapping__content" style="margin-top: 48px;">
        <input hidden type="text" id="e__name__robot" name="name__robot" class="form-control" value="{{$robot->serial}}">
    </div>

    {{-- Modal form add Points: Start --}}
    <div class="modal fade" id="savePoints" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                {{-- Header form add Groups: START --}}
                <div class="modal-header" style="background-color: #4169E1">
                    <h3 class="modal-title" style="margin-left: 140px; font-size: 24px; color: #fff;">Save Point of {{$robot->serial}}</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <input hidden type="text" id="e_dw" name="dw" class="form-control" value="">
                <input hidden type="text" id="e_dz" name="dz" class="form-control" value="">

                {{-- Header form add Groups: END --}}
                <form action="{{route('admin.missions.points.savePoints', $robot)}}" method="POST">
                    {{-- FORM ADD Groups: START --}}
                    <div class="card-body">
                        <div class="mb-3" width="80%">
                            <label class="form-label fst-normal">Name Point:</label>
                            <input type="text" id="e_name" name="name" class="form-control" placeholder="Enter Name" value="">

                            @error('name') 
                                <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3" width="80%">
                            <label class="form-label fst-normal">Position X:</label>
                            <input type="text" id="e_position_x" name="position_x" class="form-control" value="" readonly="">

                            @error('position_x') 
                                <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3" width="80%">
                            <label class="form-label fst-normal">Position Y:</label>
                            <input type="text" id="e_position_y" name="position_y" class="form-control" value="" readonly="">

                            @error('position_y') 
                                <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3" width="80%">
                            <label class="form-label fst-normal">Rotation Z:</label>
                            <input type="text" id="e_rotation_Z" name="rotation_z" class="form-control" value="" readonly="">

                            @error('rotation_z') 
                                <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3" width="80%">
                            <label class="form-label fst-normal">Rotation dw:</label>
                            <input type="text" id="e_rotation_dw" name="rotation_dw" class="form-control" value="" readonly="">

                            @error('rotation_dw') 
                                <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3" width="80%">
                            <label class="form-label fst-normal">Rotation dz:</label>
                            <input type="text" id="e_rotation_dz" name="rotation_dz" class="form-control" value="" readonly="">

                            @error('rotation_dz') 
                                <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3" width="80%">
                            <label class="form-label fst-normal">Describe</label>
							<textarea name="describe" class="form-control" placeholder="Textarea" rows="1"></textarea>

                            @error('describe') 
                                <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3" width="80%">
                            <label class="form-label fst-normal" for="inputState">Type of Point:</label>
                            <select name="type_point" id="inputState" class="form-control">
                                <option selected="">Choose...</option>
                                <option>primary</option>
                                <option>success</option>
                                <option>secondary</option>
                                <option>warning</option>
                            </select>

                            @error('type_point') 
                                <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- FOOTER FORM ADD Groups: START --}}
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Point</button>
                        </div>
                        {{-- FOOTER FORM ADD Groups: END --}}
                    </div>
                    {{-- FORM ADD Groups: END --}}
                    @csrf
                </form>
            </div>
        </div>
    </div>
    {{-- Modal form add Points: End --}}
    
    @section('script')
        {{-- ACTIVE TOGGLE DASHBOARD: START --}}
        <script>
            document.querySelector('.admin__missions').classList.add('active');
            document.querySelector('.admin__missions__create__points').classList.add('active');
            document.querySelector('.admin__missions__show').classList.add('show');
        </script>
        {{-- ACTIVE TOGGLE DASHBOARD: END --}}

        {{-- Get data position: Start --}}
        <script>
            jQuery(document).on('click', '.savePoints', function() {
                let _this = $(this).parents('body');
                jQuery('#e_position_x').val(_this.find('input[name=position__x]').val());
                jQuery('#e_position_y').val(_this.find('input[name=position__y]').val());
                jQuery('#e_rotation_Z').val(_this.find('input[name=rotation__z]').val());
                jQuery('#e_rotation_dw').val(_this.find('input[name=dw]').val());
                jQuery('#e_rotation_dz').val(_this.find('input[name=dz]').val());
            })
        </script>
        {{-- Get data posirion: End --}}

        {{-- CREATE JOYSTICK: START --}}
        <script>
            //Connectting Wifi
            const ros = new ROSLIB.Ros({
                url: 'ws://' + ipServer + ':9090'
            });

            // create map_listener from Robot
            let map_listener = new ROSLIB.Topic({
                ros : ros,
                name : "/map",
                messageType : 'nav_msgs/OccupancyGrid',
                queue_size: 1,
            });
                
            // Setup a client to listen to TFs.
            let tfClient = new ROSLIB.TFClient({
                ros : ros,
                rate : 5,
                fixedFrame : '/map',
                angularThres : 0.08,
                transThres : 0.05,
            });

            // axes origin
            let axes = new ROS3D.Axes({
                scale: 3,
                shaftRadius: 0.025,
                headRadius: 0.05,
            });

            let viewer = new ROS3D.Viewer({
                divID : 'mapping__content',
                width : document.querySelector('#mapping__content').offsetWidth,
                height : 600, 
                background: '#000000',//'#000000', //'#66CDAA',
                antialias : false,
                alpha: 0.5,
                cameraPose: {x:10, y:10, z:20},
            });

            //Lock view
            document.querySelector('#mapping__content').onmousemove = function(event) {
                viewer.cameraControls.rotateUp(1.57);
            }

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

            //create points
            /* 
                * Caculator points on map display: Start
            */
            // console.log(event.offsetX, event.offsetY);

            let functionCaculator = function(x_event, y_event) {
                let read_div = document.querySelector('#mapping__content').getBoundingClientRect();
                // console.log(read_div);
                /*
                    Caculator position of the world
                        -- Convert coordinates from the world to the coordinates of the screen
                    START
                */
                let vec = new THREE.Vector3(); // create once and reuse
                let pos = new THREE.Vector3(); // create once and reuse
    
                vec.set(
                    (x_event / read_div.width ) * 2 - 1,
                    - ( y_event / read_div.height ) * 2 + 1,
                    0.5 );
    
                vec.unproject(viewer.camera );
    
                vec.sub(viewer.camera.position).normalize();
    
                let distance = - viewer.camera.position.z / vec.z;
                // console.log( distance );
                pos.copy(viewer.camera.position).add(vec.multiplyScalar(distance));
                /* 
                    Caculator position of the world
                        -- Convert coordinates from the world to the coordinates of the screen
                    END
                */
                return pos;
            }

            let createTopic = function(pos, degree) {
                let timeCurrent = new Date();
                //format data point of robot
                point_msg = new ROSLIB.Message({
                    header: {
                        frame_id: "/map",
                    },
                    point: {
                        x: 0,
                        y: 0,
                        z: 0,
                    }
                });

                //format data pose of robot
                pose_msg = new ROSLIB.Message({
                    header: {
                        frame_id: "/map",
                    },
                    pose: {
                        position: {
                            x:0,
                            y:0,
                            z:0,
                        },
                        orientation: {
                            x:0,
                            y:0,
                            z:0,
                            w:1,
                        },
                    }
                });

                //topic send data point to robot
                point_pub = new ROSLIB.Topic({
                    ros : ros,
                    name : "/" + nameRobot + "/point_pub",
                    // name : "/point_pub" + "_",
                    messageType : 'geometry_msgs/PointStamped',
                    queue_size: 1,
                });

                //topic send data pose to robot
                pose_pub = new ROSLIB.Topic({
                    ros : ros,
                    name : "/" + nameRobot + "/pose_pub",
                    // name : "/pose_pub" + "_",
                    messageType : 'geometry_msgs/PoseStamped',
                    queue_size: 1,
                });

                /* 
                    * Caculator points on map display: Start
                */
                // console.log(event.offsetX, event.offsetY);
                let z_camera = viewer.camera.position.z;
                let rotary_x = viewer.camera.rotation._x;
                let rotary_y = viewer.camera.rotation._y;
                let rotary_z = viewer.camera.rotation._z;
                // console.log(z_camera, rotary_x, rotary_y, rotary_z);
                
                
                // // get position click
                // let x_event = event.offsetX;
                // let y_event = event.offsetY;
                // console.log(x_event, y_event);
                
                // pos = dataCaculator[1](x_event, y_event)
                
                document.querySelector('input[name=position__x]').value = pos.x;
                document.querySelector('input[name=range__position__x]').value = pos.x;
                document.querySelector('input[name=position__y]').value = pos.y;
                document.querySelector('input[name=range__position__y]').value = pos.y;

                //point data 
                point_msg.point.x = pos.x;
                point_msg.point.y = pos.y;
                
                //publish point to robot
                point_pub.publish(point_msg);
                
                //display point map display
                point = new ROS3D.Point({
                    ros : ros,
                    rootObject : viewer.scene,
                    tfClient : tfClient,
                    topic: "/" + nameRobot + "/point_pub",
                    // topic: "/point_pub" + "_",
                    color: 0xCD853F,
                    queue_size: 1,
                    throttle_rate: 1000,	
                    radius: 0.25,
                });

                //pose data
                const roll = 0, pitch = 0;
                const yaw = degree/180*Math.PI;
                const qz = Math.cos(roll/2) * Math.cos(pitch/2) * Math.sin(yaw/2) - Math.sin(roll/2) * Math.sin(pitch/2) * Math.cos(yaw/2);
                const qw = Math.cos(roll/2) * Math.cos(pitch/2) * Math.cos(yaw/2) + Math.sin(roll/2) * Math.sin(pitch/2) * Math.sin(yaw/2);
                
                pose_msg.pose.position.x = pos.x;
                pose_msg.pose.position.y = pos.y;
                pose_msg.pose.position.z = 0;
                pose_msg.pose.orientation.x = 0;
                pose_msg.pose.orientation.y = 0;
                pose_msg.pose.orientation.z = qz;
                pose_msg.pose.orientation.w = qw;

                document.querySelector('input[name=dz]').value = qz;
                document.querySelector('input[name=dw]').value = qw;


                //publish pose to robot
                pose_pub.publish(pose_msg);

                //display pose map display
                pose = new ROS3D.Pose({
                    ros: ros,
                    rootObject : viewer.scene,
                    tfClient : tfClient,
                    color: 	0xFF33FF,
                    topic: "/" + nameRobot + "/pose_pub",
                    // topic: "/pose_pub" + "_",
                    headDiameter: 0.5,
                    shaftDiameter: 0.1,
                    length: 2,
                });
            }

            document.querySelector('#mapping__content').ondblclick = function(event) {
                x_position = event.offsetX;
                y_position = event.offsetY;

                let degree = document.querySelector('input[name=rotation__z]').value;
                let pos = functionCaculator(x_position, y_position);

                // change value with input X text
                document.querySelector('input[name=position__x]').onchange = function() {
                    document.querySelector('input[name=range__position__x]').value = +document.querySelector('input[name=position__x]').value;
                    pos.x = +document.querySelector('input[name=position__x]').value;
                    createTopic(pos, degree);
                }

                // change value with input X text
                document.querySelector('input[name=range__position__x]').onchange = function() {
                    document.querySelector('input[name=position__x]').value = +document.querySelector('input[name=range__position__x]').value;
                    pos.x = +document.querySelector('input[name=range__position__x]').value;
                    createTopic(pos, degree);
                }
                
                // change value with input Y text
                document.querySelector('input[name=position__y]').onchange = function() {
                    document.querySelector('input[name=range__position__y]').value = +document.querySelector('input[name=position__y]').value;
                    pos.y = +document.querySelector('input[name=position__y]').value;
                    createTopic(pos, degree);
                }

                // change value with input Y text
                document.querySelector('input[name=range__position__y]').onchange = function() {
                    document.querySelector('input[name=position__y]').value = +document.querySelector('input[name=range__position__y]').value;
                    pos.y = +document.querySelector('input[name=range__position__y]').value;
                    createTopic(pos, degree);
                }

                // change value with input Z text
                document.querySelector('input[name=rotation__z]').onchange = function() {
                    document.querySelector('input[name=range__rotation__z]').value = +document.querySelector('input[name=rotation__z]').value;
                    degree = +document.querySelector('input[name=rotation__z]').value;
                    createTopic(pos, degree);
                }

                // change value with input Z text
                document.querySelector('input[name=range__rotation__z]').onchange = function() {
                    document.querySelector('input[name=rotation__z]').value = +document.querySelector('input[name=range__rotation__z]').value;
                    degree = +document.querySelector('input[name=range__rotation__z]').value;
                    createTopic(pos, degree);
                }
                
                createTopic(pos, degree);
            }

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
                        left: 120 + 'px', 
                        top: 100 + 'px' 
                    },
                    mode: 'static',
                    size: 100,
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
    @endsection
@endsection