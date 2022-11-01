@extends('layouts.admin')

@section('title', 'No connect')

@section('content')
    <!-- Page Heading -->
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="alert-message">
            <strong>Hello there!</strong> You do not have Auth!
        </div>
    </div>

    <script>
        createJoystick = function() {
            var options = {
                zone: document.getElementById('zone_joystick'),
                threshold: 0.1,
                position: {
                    left: 60 + 'px',
                    top: 52 + 'px'
                },
                mode: 'static',
                size: 120,
                color: '#000000',
            };

            manager = nipplejs.create(options);

            linear_speed = 0;
            angular_speed = 0;

            self.manager.on('start', function(event, nipple) {
                console.log("Movement start");
            });

            self.manager.on('move', function(event, nipple) {
                console.log("Moving");
            });

            self.manager.on('end', function() {
                console.log("Movement end");
            });
        }
        createJoystick();
    </script>
@endsection
