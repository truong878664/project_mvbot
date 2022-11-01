@extends('layouts.admin')

@section('title', 'Maps - Tracking AMR')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-10">
        <h1 class="h1 mb-0 text-gray-800">Maps - Tracking AMR</h1>
    </div>

    @section('script')
        {{-- ACTIVE TOGGLE DASHBOARD: START --}}
        <script>
            document.querySelector('.admin__maps').classList.add('active');
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
    @endsection
@endsection