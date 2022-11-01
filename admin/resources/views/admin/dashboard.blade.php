@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-10">
        <h1 class="h1 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <div class="row" style="margin-top: 48px;">
        @can('groups')
            <div class="col-6 col-md-6 col-lg-4">
                <a href="{{route('admin.groups.index')}}" class="text-center" style="text-decoration: none;">
                    <div class="card rounded border list-group-item list-group-item-action border-primary">
                        <div class="card-header px-4 pt-4 text-center">
                            <div class="card-body pt-1">
                                <i class="align-middle me-2 fas fa-fw fa-users" style="font-size: 50px; color: #4169E1;"></i>
                            </div>
                        </div>
                        <h3 class="card-title mb-4 text-center" style="font-size: 20px; color: #4169E1;">GROUP USERS</h3>
                    </div>
                </a>
            </div>
        @endcan

        @can('users')
            <div class="col-6 col-md-6 col-lg-4">
                <a href="{{route('admin.users.index')}}" style="text-decoration: none;">
                    <div class="card rounded border list-group-item list-group-item-action border-primary">
                        <div class="card-header px-4 pt-4 text-center">
                            <div class="card-body pt-1">
                                <i class="align-middle me-2 fas fa-fw fa-user" style="font-size: 50px; color: #4169E1;"></i>
                            </div>
                        </div>
                        <h3 class="card-title mb-4 text-center" style="font-size: 20px; color: #4169E1;">USERS</h3>
                    </div>
                </a>
            </div>
        @endcan

        <div class="col-6 col-md-6 col-lg-4">
            <a href="{{route('admin.missions.index')}}" style="text-decoration: none;">
                <div class="card rounded border list-group-item list-group-item-action border-primary">
                    <div class="card-header px-4 pt-4 text-center">
                        <div class="card-body pt-1">
                            <i class="align-middle me-2 fas fa-fw fa-arrow-alt-circle-right" style="font-size: 50px; color: #4169E1;"></i>
                        </div>
                    </div>
                    <h3 class="card-title mb-4 text-center" style="font-size: 20px; color: #4169E1;">MISSIONS</h3>
                </div>
            </a>
        </div>

        <div class="col-6 col-md-6 col-lg-4">
            <a href="{{route('admin.maps.index')}}" style="text-decoration: none;">
                <div class="card rounded border list-group-item list-group-item-action border-primary">
                    <div class="card-header px-4 pt-4 text-center">
                        <div class="card-body pt-1">
                            <i class="align-middle me-2 fas fa-fw fa-map-marked" style="font-size: 50px; color: #4169E1;"></i>
                        </div>
                    </div>
                    <h3 class="card-title mb-4 text-center" style="font-size: 20px; color: #4169E1;">MAP</h3>
                </div>
            </a>
        </div>

        <div class="col-6 col-md-6 col-lg-4">
            <a href="{{route('admin.status.index')}}" style="text-decoration: none;">
                <div class="card rounded border list-group-item list-group-item-action border-primary">
                    <div class="card-header px-4 pt-4 text-center">
                        <div class="card-body pt-1">
                            <i class="align-middle me-2 far fa-fw fa-list-alt" style="font-size: 50px; color: #4169E1;"></i>
                        </div>
                    </div>
                    <h3 class="card-title mb-4 text-center" style="font-size: 20px; color: #4169E1;">STATUS</h3>
                </div>
            </a>
        </div>

        <div class="col-6 col-md-6 col-lg-4">
            <a href="{{route('admin.sounds.index')}}" style="text-decoration: none;">
                <div class="card rounded border list-group-item list-group-item-action border-primary">
                    <div class="card-header px-4 pt-4 text-center">
                        <div class="card-body pt-1">
                            <i class="align-middle me-2 fas fa-fw fa-music" style="font-size: 50px; color: #4169E1;"></i>
                        </div>
                    </div>
                    <h3 class="card-title mb-4 text-center" style="font-size: 20px; color: #4169E1;">SOUND</h3>
                </div>
            </a>
        </div>

        <div class="col-6 col-md-6 col-lg-4">
            <a href="{{route('admin.setting.index')}}" style="text-decoration: none;">
                <div class="card rounded border list-group-item list-group-item-action border-primary">
                    <div class="card-header px-4 pt-4 text-center">
                        <div class="card-body pt-1">
                            <i class="me-2 fas fa-fw fa-cog" style="font-size: 50px; color: #4169E1;"></i>
                        </div>
                    </div>
                    <h3 class="card-title mb-4 text-center" style="font-size: 20px; color: #4169E1;">SETTING</h3>
                </div>
            </a>
        </div>
    </div>

    @section('script')
        {{-- ACTIVE TOGGLE DASHBOARD: START --}}
        <script>
            document.querySelector('.admin__home').classList.add('active');
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