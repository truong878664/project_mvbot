@extends('layouts.admin')

@section('title', 'Sounds')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-10">
        <h1 class="h1 mb-0 text-gray-800">Sound</h1>
    </div>
    
    {{-- Add music: Start --}}
    <p>
        <button type="button" class="btn btn-primary fs-2" data-bs-toggle="modal" data-bs-target="#addUser" 
            style="margin-top: 48px;">
            <i class="align-middle me-2 fas fa-fw fa-plus"></i>
            Add Music
        </button>
    </p>
    {{-- Add music: End --}}

    {{-- Table manage Users: Start --}}
    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th width="5%">#</th>
                <th>Music Name</th>
                <th width="30%">Audio</th>
            </tr>
        </thead>
        <tbody>
            @if ($listSound->count() > 0)
                @foreach ($listSound as $index => $sound)
                    <tr>
                        <td>{{$index + 1}}</td>
                        <td>{{$sound->name}}</td>
                        <td>
                            <audio controls>
                                <source src="{{asset('admins/sounds/music.mp3')}}" type="audio/mpeg">
                            </audio>
                        </td>
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
            document.querySelector('.admin__sound').classList.add('active');
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