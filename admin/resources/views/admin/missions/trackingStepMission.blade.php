@extends('layouts.admin')

@section('title', 'Maps - Missions - Tracking Mission')

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
        <h1 class="h1 mb-0 text-gray-800">Missions - Tracking - {{$robot->serial}}</h1>
    </div>

    {{-- Time Mission: Start --}}
    @if (session('time__mission'))
        <label style="margin-top: 24px;" class="form-label fst-normal" for="">Time Mission:</label>
        <input type="text" id="e__time__mission" name="time__mission" class="form-control" placeholder="Enter Time Mission..." value="{{session('time__mission')}}" readonly="">
    @endif
    {{-- Time Mission: End --}}
    
    {{-- Get Points of mission: Start --}}
    @if (session('steps'))
        <label style="margin-top: 12px;" class="form-label fst-normal" for="">Steps Mission:</label>
        <textarea name="describe" id="e__steps__mission" name="steps__mission" class="form-control" placeholder="{{session('steps')}}" rows="1" value="{{session('steps')}}" readonly=""></textarea>    
    @endif
    {{-- Get Points of mission: End --}}


    <div class="row" id="mapping__content" style="margin-top: 32px;">
        <input hidden type="text" id="e__name__robot" name="name__robot" class="form-control" value="{{$robot->serial}}">
    </div>

    @section('script')
        {{-- ACTIVE TOGGLE DASHBOARD: START --}}
        <script>
            document.querySelector('.admin__missions').classList.add('active');
            document.querySelector('.admin__missions__tracking__missions').classList.add('active');
            document.querySelector('.admin__missions__show').classList.add('show');
        </script>
        {{-- ACTIVE TOGGLE DASHBOARD: END --}}

        {{-- CREATE JOYSTICK: START --}}
        <script>
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
                    console.log("Movement start");
                });

                self.manager.on('move', function (event, nipple) {
                    console.log("Moving");
                });

                self.manager.on('end', function () {
                    console.log("Movement end");
                });
            }
            createJoystick();
        </script>
        {{-- CREATE JOYSTICK: END --}}

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
            let timeMission = document.querySelector('#e__time__mission').getAttribute('value');
            let steps = document.querySelector('#e__steps__mission').getAttribute('value');
            
            let arrSteps = steps.split("@");
            console.log(arrSteps);

            // Send data to Robot: Start
            let robotMission = new ROSLIB.Topic({
                ros : ros,
                name : "/" + nameRobot + "/mission",
                messageType : 'std_msgs/String',
                queue_size: 200,
            });

            //Information
            const infoSteps = new ROSLIB.Message({
                data: JSON.stringify(timeMission + '@' + steps),
            });

            robotMission.publish(infoSteps); 
            // Send data to Robot: End

            // Display information: Start
            arrSteps.forEach((element, index) => {
                let newDate = new Date();
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
                    name : "/" + nameRobot + "/point_pub" + index + newDate.getSeconds(),
                    messageType : 'geometry_msgs/PointStamped',
                    queue_size: 1,
                });

                //topic send data pose to robot
                pose_pub = new ROSLIB.Topic({
                    ros : ros,
                    name : "/" + nameRobot + "/pose_pub" + index +  newDate.getSeconds(),
                    messageType : 'geometry_msgs/PoseStamped',
                    queue_size: 1,
                });
                // console.log(element.split('|')[2]);
                //point data 
                point_msg.point.x = +element.split('|')[2];
                point_msg.point.y = +element.split('|')[3];

                //publish point to robot
                point_pub.publish(point_msg);

                //pose data
                const roll = 0, pitch = 0;
                const yaw = +element.split('|')[4]/180*Math.PI;
                const qz = Math.cos(roll/2) * Math.cos(pitch/2) * Math.sin(yaw/2) - Math.sin(roll/2) * Math.sin(pitch/2) * Math.cos(yaw/2);
                const qw = Math.cos(roll/2) * Math.cos(pitch/2) * Math.cos(yaw/2) + Math.sin(roll/2) * Math.sin(pitch/2) * Math.sin(yaw/2);

                pose_msg.pose.position.x = +element.split('|')[2];
                pose_msg.pose.position.y = +element.split('|')[3];
                pose_msg.pose.position.z = 0;
                pose_msg.pose.orientation.x = 0;
                pose_msg.pose.orientation.y = 0;
                pose_msg.pose.orientation.z = qz;
                pose_msg.pose.orientation.w = qw;

                //publish pose to robot
                pose_pub.publish(pose_msg);

                //display point map display
                point = new ROS3D.Point({
                    ros : ros,
                    rootObject : viewer.scene,
                    tfClient : tfClient,
                    topic: "/" + nameRobot + "/point_pub" + index + newDate.getSeconds(),
                    color: 0xCD853F,
                    queue_size: 1,
                    throttle_rate: 1000,	
                    radius: 0.25,
                });

                //display pose map display
                pose = new ROS3D.Pose({
                    ros: ros,
                    rootObject : viewer.scene,
                    tfClient : tfClient,
                    color: 	0xFF33FF,
                    topic: "/" + nameRobot + "/pose_pub" + index + newDate.getSeconds(),
                    headDiameter: 0.5,
                    shaftDiameter: 0.1,
                    length: 2,
                });
            })
            // Display information: End
        </script>
    @endsection
@endsection