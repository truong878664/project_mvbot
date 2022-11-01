@extends('layouts.admin')

@section('title', 'Setting - List Robot')

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
        <h1 class="h1 mb-0 text-gray-800">Setting - Ethernet - List Robot</h1>
    </div>
    
    <div class="row" style="margin-top: 48px;">
        {{-- Block Wifi: Start --}}
        @if ($listsRobot->count() > 0)
            @foreach ($listsRobot as $robot)
                <div class="col-6 col-md-6 col-lg-4">
                    <a href="#" class="text-center" style="text-decoration: none;" data-bs-toggle="modal" data-bs-target="#sendTo_{{$robot->serial}}">
                        <div class="card rounded border list-group-item list-group-item-action border-primary">
                            <div class="card-header px-4 pt-4 text-center">
                                <div class="card-body pt-1">
                                    <i class="align-middle me-2 fas fa-fw fa-robot" style="font-size: 50px; color: #4169E1;"></i>
                                </div>
                            </div>
                            <h3 class="card-title mb-4" style="font-size: 20px; color: #4169E1;">{{$robot->serial}}</h3>
                        </div>
                    </a>
                </div>

                {{-- Modal form user send ip to robot: Start --}}
                <div class="modal fade" id="sendTo_{{$robot->serial}}" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            {{-- Header form user send ip to robot: START --}}
                            <div class="modal-header" style="background-color: #4169E1">
                                <h3 class="modal-title" style="margin-left: 160px; font-size: 24px; color: #fff;">Send IP To {{$robot->serial}}</h3>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            {{-- Header form user send ip to robot: END --}}
                            <form action="{{route('admin.setting.ethernet.userSendIp', $robot)}}" method="POST">
                                {{-- FORM user send ip to robot: START --}}
                                <div class="card-body">
                                    <input hidden type="text" id="e_name_robot" name="name_robot" class="form-control" value="{{$robot->serial}}">

                                    <div class="mb-3" width="80%">
                                        <label class="form-label fst-normal">IP Master:</label>
                                        <input type="text" id="e_ip_master" name="ip_master" class="form-control" placeholder="Enter IP master" value="">

                                        @error('ip_master') 
                                            <span style="color: red;">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-3" width="80%">
                                        <label class="form-label fst-normal">IP Node:</label>
                                        <input type="text" id="e_ip_node" name="ip_node" class="form-control" placeholder="Enter IP node" value="">

                                        @error('ip_node') 
                                            <span style="color: red;">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- FOOTER FORM user send ip to robot: START --}}
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary button_send_ip">Send Robot</button>
                                    </div>
                                    {{-- FOOTER FORM user send ip to robot: END --}}
                                </div>
                                {{-- FORM user send ip to robot: END --}}
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
                {{-- Modal form user send ip to robot: End --}}
            @endforeach
        @endif
        {{-- Block Wifi: End --}}
    </div>

    @section('script')
        {{-- ACTIVE TOGGLE DASHBOARD: START --}}
        <script>
            document.querySelector('.admin__setting').classList.add('active');
            document.querySelector('.admin__setting__ethernet').classList.add('active');
            document.querySelector('.admin__setting__show').classList.add('show');
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


        {{-- SEND DATA IP TO ROBOT: START --}}
        <script>
            jQuery(document).on('click', '.button_send_ip', function() {
                let _this = $(this).parents('body');

                // get name robot
                let nameRobot = jQuery('#e_name_robot').val();
                let ip_master = jQuery('#e_ip_master').val();
                let ip_node = jQuery('#e_ip_node').val();
                let ipSend = {
                    "ip_master": ip_master,
                    "ip_node": ip_node
                };

                //Connectting Wifi
                const ros = new ROSLIB.Ros({
                    url: 'ws://' + ipServer + ':9090'
                });

                var robotEthernet = new ROSLIB.Topic({
                    ros : ros,
                    name : "/" + nameRobot + "/ethernet",
                    messageType : 'std_msgs/String',
                    queue_size: 200,
                });

                //Information
                const infoIpData = new ROSLIB.Message({
                    data: JSON.stringify(ipSend),
                });
                
                robotEthernet.publish(infoIpData);  
            })
        </script>
        {{-- SEND DATA IP TO ROBOT: END --}}
    @endsection
@endsection