@extends('layouts.admin')

@section('title', 'Setting - WiFi')

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
        <h1 class="h1 mb-0 text-gray-800">Setting - WiFi - {{$robot->serial}}</h1>
    </div>

    {{-- Add WiFi: Start --}}
    <p>
        <button type="button" class="btn btn-primary fs-2 addWiFi" data-bs-toggle="modal" data-bs-target="#addWiFi" 
            style="margin-top: 48px;">
            <i class="align-middle me-2 fas fa-fw fa-plus"></i>
            Add WiFi
        </button>
    </p>
    {{-- Add WiFi: End --}}

    <div class="row" style="margin-top: 48px;">
        @if ($listsWifi->count() > 0)
            {{-- GET INFORMATION ROBOT: START--}}
            <input hidden type="text" id="name__robot" class="form-control" value="{{$robot->serial}}">
            {{-- GET INFORMATION ROBOT: END--}}

            @foreach ($listsWifi as $wifi)
                <div class="col-12 col-md-4 col-lg-4">
                    <div class="card rounded border border-primary">
                        <input hidden type="text" id="wifi__robot" class="form-control" value="{{$robot->table_wifi}}">

                        {{-- Name and mode of robot: Start --}}
                        <div class="card-header px-4 pt-4">
                            <div class="card-actions float-end">
                                <i class="align-middle me-2 fas fa-fw fa-wifi inactive_icon icon__wifi" style="font-size: 32px; color: green;"></i>
                            </div>
        
                            <h5 class="card-title mb-2 name__wifi" style="font-size: 20px;">{{$wifi->name}}</h5>
                        </div>
                        {{-- Name and mode of robot: End --}}
        
                        {{-- IP Master of robot: Start --}}
                        <div class="list-group-item px-4 pb-2">
                            <p class="mb-1 font-weight-bold fs-4">IP Master:<span class="float-end fs-4">{{$wifi->ip_master}}</span></p>
                        </div>
                        {{-- IP Master of robot: End --}}
        
                        {{-- IP Node of robot: Start --}}
                        <div class="list-group-item px-4 pb-2">
                            <p class="mb-1 font-weight-bold fs-4">IP Node:<span class="float-end fs-4">{{$wifi->ip_node}}</span></p>
                        </div>
                        {{-- IP Node of robot: End --}}
        
                        {{--Block button: Start --}}
                        <div class="list-group-item px-4 pb-2">
                            <button type="button" class="btn btn-primary btn-lg fs-4 wifi_connect">Connect</button>
                            <a href="{{route('admin.setting.wifi.deleteWifi', $wifi)}}">
                                <button type="button" class="btn btn-secondary btn-lg fs-4" style="margin-left: 12px;" 
                                onclick="return confirm('Are you delete {{$wifi->name}}?')">
                                    Delete
                                </button>
                            </a>
                        </div>
                        {{--Block button: End --}}
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    {{-- Modal form add WiFi: Start --}}
    <div class="modal fade" id="addWiFi" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                {{-- Header form add Wifi: START --}}
                <div class="modal-header" style="background-color: #4169E1">
                    <h3 class="modal-title" style="margin-left: 230px; font-size: 24px; color: #fff;">Add WiFi</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                {{-- Header form add Wifi: END --}}
                <form action="{{ route('admin.setting.wifi.addWifi', $robot) }}" method="POST">
                    <input hidden type="text" name="robot_id" class="form-control" placeholder="Password..." value="{{$robot->id}}">

                    <div class="card-body">
                        {{-- Name Wifi: Start--}}
                        <div class="mb-3" width="80%">
                            <label class="form-label fst-normal">Name:</label>
                            <input type="text" name="name" class="form-control" placeholder="Name..." value="">

                            @error('name') 
                                <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>
                        {{-- Name Wifi: End--}}

                        {{-- Password Wifi: Start--}}
                        <div class="mb-3" width="80%">
                            <label class="form-label fst-normal">Password:</label>
                            <input type="password" name="password" class="form-control" placeholder="Password..." value="">

                            @error('password') 
                                <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>
                        {{-- Password Wifi: End--}}

                        {{-- IP Master: Start--}}
                        <div class="mb-3" width="80%">
                            <label class="form-label fst-normal">IP Master:</label>
                            <input type="text" name="ip_master" class="form-control" placeholder="Ip master..." value="">

                            @error('ip_master') 
                                <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>
                        {{-- IP Master: End--}}

                        {{-- IP Node: Start--}}
                        <div class="mb-3" width="80%">
                            <label class="form-label fst-normal">IP Node:</label>
                            <input type="text" name="ip_node" class="form-control" placeholder="Ip node..." value="">

                            @error('ip_node') 
                                <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>
                        {{-- IP Node: End--}}

                        {{-- FOOTER FORM ADD Wifi: START --}}
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add WiFi</button>
                        </div>
                        {{-- FOOTER FORM ADD Wifi: END --}}
                    </div>
                    {{-- FORM ADD Wifi: END --}}
                    @csrf
                </form>
            </div>
        </div>
    </div>
    {{-- Modal form add WiFi: End --}}

    @section('script')
        {{-- ACTIVE TOGGLE DASHBOARD: START --}}
        <script>
            document.querySelector('.admin__setting').classList.add('active');
            document.querySelector('.admin__setting__wifi').classList.add('active');
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


        {{-- SEND DATA WIFI TO ROBOT: START --}}
        <script>
            let allBtnConnect = document.querySelectorAll('.wifi_connect');

            allBtnConnect.forEach(function(btnConnect, index) {
                btnConnect.onclick = function() {
                    if (jQuery('.wifi_connect')[index].innerText === 'Connect') {

                        jQuery('.wifi_connect')[index].innerText = 'Disconnect';
                        
                        jQuery('.icon__wifi')[index].classList.toggle('active_icon');
    
                        jQuery('.wifi_connect')[index].classList.toggle('btn-danger');

                        // Get value info of robot and wifi
                        let infoWifi = jQuery('#wifi__robot').val();
                        
                        let nameRobot = jQuery('#name__robot').val();

                        //Connectting Wifi
                        const ros = new ROSLIB.Ros({
                            url: 'ws://' + ipServer + ':9090'
                        });

                        var robotWiFi = new ROSLIB.Topic({
                            ros : ros,
                            name : "/" + nameRobot + "/wifiConnect",
                            messageType : 'std_msgs/String',
                            queue_size: 200,
                        });

                        //Information
                        const infoWiFiData = new ROSLIB.Message({
                            data: JSON.stringify(JSON.parse(infoWifi)[index]),
                        });

                        robotWiFi.publish(infoWiFiData);

                    } else {
                        jQuery('.icon__wifi')[index].classList.toggle('active_icon');
    
                        jQuery('.wifi_connect')[index].classList.toggle('btn-danger');

                        jQuery('.wifi_connect')[index].innerText = 'Connect';
                    } 
                }
            })
        </script>
        {{-- SEND DATA WIFI TO ROBOT: END --}}
    @endsection
@endsection