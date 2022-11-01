@extends('layouts.admin')

@section('title', 'Maps - List Map')

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
        <h1 class="h1 mb-0 text-gray-800">Maps - List</h1>
    </div>

    {{-- Table manage Users: Start --}}
    <table class="table table-bordered text-center" style="margin-top: 48px;">
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="30%">Name</th>
                <th>Path</th>
                <th width="15%">Action</th>
            </tr>
        </thead>
        <tbody>
            @if ($maps->count() > 0)
                @foreach ($maps as $index => $map)
                    <tr>
                        <td>{{$index + 1}}</td>
                        <td>{{$map->name}}</td>
                        <td>{{$map->path}}</td>
                        <td>
                            {{-- Button edit: Start --}}
                            <a href="#" class="btn btn-success sendMap" 
                                data-bs-toggle="modal" data-bs-target="#sendMap_{{$map->name}}" style="width: 45px;">
                                <i class="align-middle me-2 fas fa-fw fa-file-export"></i> <span class="align-middle"></span>
                            </a>
                            {{-- Button edit: End --}}
                        </td>

                        {{-- Modal form map send ip to robot: Start --}}
                        <div class="modal fade" id="sendMap_{{$map->name}}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    {{-- Header form map send ip to robot: START --}}
                                    <div class="modal-header" style="background-color: #4169E1">
                                        <h3 class="modal-title" style="margin-left: 190px; font-size: 24px; color: #fff;">Send Map {{$map->name}}</h3>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    {{-- Header form map send ip to robot: END --}}
                                    <form action="{{route('admin.maps.list.sendMapRobot', $map)}}" method="POST">
                                        {{-- FORM map send ip to robot: START --}}
                                        <div class="card-body">
                                            <div class="mb-3" width="80%">
                                                <label class="form-label fst-normal" for="e_name_robot">Name Action:</label>
                                                <select name="name_action" id="e_name_action" class="form-control">
                                                    <option value="0">Choose Action</option>
                                                    <option value="save">Save</option>
                                                    <option value="delete">Delete</option>
                                                </select>

                                                @error('name_action') 
                                                    <span style="color: red;">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="mb-3" width="80%">
                                                <label class="form-label fst-normal" for="e_name_robot">Choose Robot:</label>
                                                <select name="name_robot" id="e_name_robot" class="form-control">
                                                    <option value="0">Choose Robot</option>
                                                    @if ($listsRobot->count() > 0)
                                                        @foreach ($listsRobot as $robot)
                                                            <option value="{{$robot->serial}}">{{$robot->serial}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>

                                                @error('name_robot') 
                                                    <span style="color: red;">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            {{-- FOOTER FORM map send ip to robot: START --}}
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary button_send_map">Send Robot</button>
                                            </div>
                                            {{-- FOOTER FORM map send ip to robot: END --}}
                                        </div>
                                        {{-- FORM map send ip to robot: END --}}
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        </div>
                        {{-- Modal form map send ip to robot: End --}}
                    </tr>
                @endforeach
            @endif
            <tr>
            </tr>
        </tbody>
    </table>

    @section('script')
        {{-- ACTIVE TOGGLE DASHBOARD: START --}}
        <script>
            document.querySelector('.admin__maps').classList.add('active');
            document.querySelector('.admin__maps__list').classList.add('active');
            document.querySelector('.admin__maps__show').classList.add('show');
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

        {{-- SEND ACTION TO ROBOT: START --}}
        <script>
            jQuery(document).on('click', '.button_send_map', function() {
                let _this = $(this).parents('body');

                // get name robot
                let nameAction = jQuery('#e_name_action').val();
                let nameRobot = jQuery('#e_name_robot').val();
                
                // console.log(nameAction, nameRobot);

                //Connectting Wifi
                const ros = new ROSLIB.Ros({
                    url: 'ws://' + ipServer + ':9090'
                });

                var robotAction = new ROSLIB.Topic({
                    ros : ros,
                    name : "/" + nameRobot + "/mapAction",
                    messageType : 'std_msgs/String',
                    queue_size: 200,
                });

                //Information
                const infoActionData = new ROSLIB.Message({
                    data: JSON.stringify(nameAction),
                });
                
                robotAction.publish(infoActionData);  
                console.log(robotAction, infoActionData.data);
            })
        </script>
        {{-- SEND ACTION TO ROBOT: END --}}
    @endsection
@endsection