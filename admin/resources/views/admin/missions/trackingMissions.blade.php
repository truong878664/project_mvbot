@extends('layouts.admin')

@section('title', 'Missions - Tracking Mission')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-10">
        <h1 class="h1 mb-0 text-gray-800">Missions - Tracking - List Robot</h1>
    </div>

    <div class="row" style="margin-top: 48px;">
        {{-- Block Tracking: Start --}}
        @if ($listsRobot->count() > 0)
            @foreach ($listsRobot as $robot)
                <div class="col-6 col-md-6 col-lg-4">
                    <a href="{{route('admin.missions.tracking.trackingStepMission', $robot)}}" class="text-center" style="text-decoration: none;">
                        <div class="card rounded border list-group-item list-group-item-action border-primary">
                            <div class="card-header px-4 pt-4 text-center">
                                <div class="card-body pt-1">
                                    @if ($robot->mode == 'navigation')
                                        <i class="align-middle me-2 fas fa-fw fa-robot" style="font-size: 50px; color: #4169E1;"></i>
                                    @else 
                                        <i class="align-middle me-2 fas fa-fw fa-robot" style="font-size: 50px; color: #008000;"></i>
                                    @endif
                                </div>
                            </div>
                            @if ($robot->mode == 'navigation')
                                <h3 class="card-title mb-4 text-center" style="font-size: 20px; color: #4169E1;">{{$robot->serial}}</h3>
                            @else 
                                <h3 class="card-title mb-4 text-center" style="font-size: 20px; color: #008000;">{{$robot->serial}}</h3>
                            @endif
                        </div>
                    </a>
                </div>
            @endforeach
        @endif
        {{-- Block Tracking: End --}}
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
    @endsection
@endsection