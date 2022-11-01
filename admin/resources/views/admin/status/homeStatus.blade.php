@extends('layouts.admin')

@section('title', 'Status - List AMR')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-10">
        <h1 class="h1 mb-0 text-gray-800">Status - List Robot</h1>
    </div>

    <div class="row block__status" style="margin-top: 48px;"></div>
        
    @section('script')
        {{-- ACTIVE TOGGLE DASHBOARD: START --}}
        <script>
            document.querySelector('.admin__status').classList.add('active');
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

        {{-- SEND STATUS ROBOT: START --}}
        <script>
            let $$ = document.querySelector.bind(document);
            // let $$$ = document.querySelectorAll.bind(document);

            let app = {
                getValueRobots: function(callback) {
                    fetch(`{{ route('statusRobots.indexApi') }}`)
                        .then(function(response) {
                            return response.json();
                        })
                        .then(callback)
                },

                renderValues: function(dataRobots) {
                    let htmlBlockStatus = $$('.block__status')

                    let ros = new ROSLIB.Ros({
						url: 'ws://' + ipServer + ':9090'
					});

                    let iam_listener = new ROSLIB.Topic({
                        ros : ros,
                        name : "/IAM", //name Topic robot send to web
                        messageType : 'std_msgs/String',
                        queue_size: 1000,
				    });

                    iam_listener.subscribe(function(message) {
                        
                    //Data Robot
                    let dataPost = {
                        "serial": 		message.data.split('|')[0],
                        "mode": 		message.data.split('|')[1],
                        "volt_pin": 	message.data.split('|')[2],
                        "percent_pin": 	message.data.split('|')[3],
                        "radar1": 		message.data.split('|')[4],
                        "radar2": 		message.data.split('|')[5],
                        "camera1": 		message.data.split('|')[6],
                        "camera2": 		message.data.split('|')[7],
                        "I": 			message.data.split('|')[8],
                        "charging": 	message.data.split('|')[9],
                        "cell": 		message.data.split('|')[10],
                        "option": 		message.data.split('|')[11] 
                    };
                    
                    // Thêm hoặc cập nhật dữ liệu đã có
                    let index = dataRobots.findIndex(function(item) {
                        return item.serial === dataPost.serial;
                    });
                    // console.log(index);

                    if (index < 0) {
                        dataRobots.push(dataPost);
                    } else {
                        dataRobots.splice(index, 1, dataPost);
                    }

                    //Check robot in array
                    let htmlRobots = dataRobots.map((data) => {
                        return `
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="card rounded border border-primary">
                                    {{-- Name and mode of robot: Start --}}
                                    <div class="card-header px-4 pt-4">
                                        <h5 class="card-title mb-2" style="font-size: 20px;">${data.serial}</h5>
                                        <div class="badge bg-${(data.mode) === 'navigation' ? 'primary': 'success'} my-2" style="font-size: 16px;">${data.mode}</div>
                                    </div>
                                    {{-- Name and mode of robot: End --}}

                                    {{-- Percent Pin of robot: Start --}}
                                    <div class="list-group-item px-4 pb-4">
                                        <p class="mb-2 font-weight-bold">Batery Percent 
                                            {{-- Check charging of robot: Start --}}
                                            <span ${data.charging === '1' ? 'show' : 'hidden'} class="badge bg-warning" style="font-size: 12px;">Charging</span> 
                                            {{-- Check charging of robot: End --}}

                                            {{-- Amppe of robot: Start --}}
                                            <span class="badge bg-primary" style="font-size: 12px;">${data.I}A</span> 
                                            {{-- Amppe of robot: End --}}

                                            {{-- Option of robot: Start --}}
                                            <span class="badge bg-dark" style="font-size: 12px;">${data.option}℃</span> 
                                            {{-- Option of robot: End --}}

                                            <span class="float-end">${data.percent_pin}%</span>
                                        </p>
                                        
                                        <div class="progress progress-sm">
                                            <div class="progress-bar" role="progressbar" 
                                                aria-valuenow="${data.percent_pin}" aria-valuemin="0" 
                                                aria-valuemax="100" style="width: ${data.percent_pin}%;">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Percent Pin of robot: End --}}

                                    {{-- Volt Pin of robot: Start --}}
                                    <div class="list-group-item px-4 pb-4">
                                        <p class="mb-2 font-weight-bold">Volt Pin
                                            <span class="badge bg-secondary" style="font-size: 12px;">Max: 24V</span> 
                                            <span class="float-end">${data.volt_pin/24*100}%</span>
                                        </p>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar" role="progressbar" 
                                                aria-valuenow="${data.volt_pin}" aria-valuemin="0" 
                                                aria-valuemax="100" style="width: ${+data.volt_pin/24*100}%;">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Volt Pin of robot: End --}}

                                    {{-- Status Camera of robot: Start --}}
                                    <div class="list-group-item px-4 pb-4">
                                        <div class="row">
                                            <div class="col-12 col-md-6 col-lg-5">
                                                <div>
                                                    <span class="font-weight-bold">Camera 1: </span> 
                                                    <span class="badge bg-${(data.camera1 === '1' ? 'success' : 'danger')}">${(data.camera1 === '1' ? 'Active' : 'Inactive')}</span>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-5">
                                                <div>
                                                    <span class="font-weight-bold">Camera 2: </span> 
                                                    <span class="badge bg-${(data.camera2 === '1' ? 'success' : 'danger')}">${(data.camera2 === '1' ? 'Active' : 'Inactive')}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Volt Pin of robot: End --}}

                                    {{-- Status Lidar of robot: Start --}}
                                    <div class="list-group-item px-4 pb-4">
                                        <div class="row">
                                            <div class="col-12 col-md-6 col-lg-5">
                                                <div>
                                                    <span class="font-weight-bold">Lidar 1: </span> 
                                                    <span class="badge bg-${(data.radar1 === '1' ? 'success' : 'danger')}">${(data.radar1 === '1' ? 'Active' : 'Inactive')}</span>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-5">
                                                <div>
                                                    <span class="font-weight-bold">Lidar 2: </span> 
                                                    <span class="badge bg-${(data.radar2 === '1' ? 'success' : 'danger')}">${(data.radar2 === '1' ? 'Active' : 'Inactive')}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Status Lidar of robot: End --}}
                                </div>
                            </div>`
                        })
                        
                        htmlBlockStatus.innerHTML = htmlRobots.join('');
                    })
                },

                start: function() {
                    this.getValueRobots(this.renderValues);  
                }
            }

            app.start();
            
        </script>
        {{-- SEND STATUS ROBOT: END --}}
    @endsection
@endsection