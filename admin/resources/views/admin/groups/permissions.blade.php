@extends('layouts.admin')

@section('title', 'Permissions' . $group->name)

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <div class="alert-message">
                <strong>Hello there!</strong> Please check data enter!
            </div>
        </div>
    @endif

    @if (session('msg'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <div class="alert-message">
                <strong>Hello there!</strong> {{ session('msg') }}!
            </div>
        </div>
    @endif

    <!-- Page Heading -->
    <div class="container-fluid p-0">
        <div class="row mb-2 mb-xl-3">
            <div class="col-auto d-none d-sm-block">
                <h3 style="font-size: 32px;">Permissions: {{ $group->name }}</h3>
            </div>
        </div>
    </div>

    <form action="" method="POST">
        @csrf
        <table class="table table-bordered" style="margin-top: 30px;">
            <thead>
                <tr>
                    <th width="15%" class="text-center">Module</th>
                    <th class="text-center">Permission</th>
                </tr>
            </thead>
            <tbody>
                @if ($modules->count() > 0)
                    @foreach ($modules as $module)
                        <tr>
                            <td>{{ $module->title }}</td>
                            <td>
                                <div class="row">
                                    @if (!empty($roleListArr))
                                        @foreach ($roleListArr as $roleName => $roleLabel)
                                            <div class="col-2">
                                                <label for="role_{{ $module->name }}_{{ $roleName }}">
                                                    <input type="checkbox" name="role[{{ $module->name }}][]"
                                                        id="role_{{ $module->name }}_{{ $roleName }}"
                                                        value="{{ $roleName }}"
                                                        {{ isRole($roleArr, $module->name, $roleName) ? 'checked' : false }} />
                                                    {{ $roleLabel }}
                                                </label>
                                            </div>
                                        @endforeach
                                    @endif

                                    @if ($module->name == 'groups')
                                        <div class="col-2">
                                            <label for="role_{{ $module->name }}_permission">
                                                <input type="checkbox" name="role[{{ $module->name }}][]"
                                                    id="role_{{ $module->name }}_permission" value="permission"
                                                    {{ isRole($roleArr, $module->name, 'permission') ? 'checked' : false }} />
                                                Permission
                                            </label>
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        <button type="submit" class="btn btn-primary btn-lg">Permission</button>
    </form>

@section('script')
    {{-- ACTIVE TOGGLE DASHBOARD: START --}}
    <script>
        document.querySelector('.admin__groups').classList.add('active');
    </script>
    {{-- ACTIVE TOGGLE DASHBOARD: END --}}


    {{-- CREATE JOYSTICK: START --}}
    <script>
        createJoystick = function() {
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
    {{-- CREATE JOYSTICK: END --}}
@endsection
@endsection
