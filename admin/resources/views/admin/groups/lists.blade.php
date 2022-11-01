@extends('layouts.admin')

@section('title', 'Groups')

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
                <strong>Hello there!</strong> {{ session('msg') }}!
            </div>
        </div>
    @endif
    {{-- Alert message with action success: End --}}

    <!-- Page Heading -->
    <div class="container-fluid p-0">
        <div class="row mb-2 mb-xl-3">
            <div class="col-auto d-none d-sm-block">
                <h3 style="font-size: 32px;">Groups User</h3>
            </div>
        </div>
    </div>


    {{-- Add Groups: Start --}}
    @can('create', App\Models\Groups::class)
        <p>
            <button type="button" class="btn btn-primary fs-2" data-bs-toggle="modal" data-bs-target="#addGroup"
                style="margin-top: 20px;">
                <i class="align-middle me-2 fas fa-fw fa-plus"></i>
                Add Group
            </button>
        </p>
    @endcan
    {{-- Add Groups: End --}}

    {{-- Table manage Groups: Start --}}
    <table class="table table-bordered text-center">
        <thead>
            <tr>
                {{-- <th>ID</th> --}}
                <th width="5%">ID</th>
                <th>Name</th>
                <th width="10%">People</th>
                <th width="20%">People Create</th>

                @can('groups.permission')
                    <th width="15%">Permissions</th>
                @endcan

                <th width="20%">Functions</th>
            </tr>
        </thead>

        <tbody>
            @if ($groups->count() > 0)
                @foreach ($groups as $key => $item)
                    <tr>
                        <td hidden class="group_id">{{ $item->id }}</td>
                        <td>{{ $key + 1 }}</td>
                        <td class="group__name">{{ $item->name }}</td>
                        <td>{{ $item->users->count() }}</td>

                        <td>
                            {{ !empty($item->postBy->name) ? $item->postBy->name : false }}
                        </td>

                        @can('groups.permission')
                            <td>
                                <a href="{{ route('admin.groups.permission', $item) }}" class="btn btn-primary">
                                    Permission
                                </a>
                            </td>
                        @endcan

                        <td>
                            @can('groups.edit')
                                <a class="btn btn-warning editGroup" data-bs-toggle="modal" data-bs-target="#editGroup"
                                    style="width: 45px;">
                                    <i class="align-middle me-2 fas fa-fw fa-pen"></i> <span class="align-middle"></span>
                                </a>
                            @endcan

                            @can('groups.delete')
                                @if (Auth::user()->id !== $item->id)
                                    <a onclick="return confirm('Are you sure you want to delete {{ $item->name }}?')"
                                        href="{{ route('admin.groups.delete', $item) }}" class="btn btn-danger"
                                        style="width: 45px;">
                                        <i class="align-middle me-2 fas fa-fw fa-trash"></i> <span class="align-middle"></span>
                                    </a>
                                @endif
                            @endcan
                        </td>

                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    {{-- Table manage Groups: End --}}

    {{-- Modal form add Groups: Start --}}
    <div class="modal fade" id="addGroup" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                {{-- Header form add Groups: START --}}
                <div class="modal-header" style="background-color: #4169E1">
                    <h3 class="modal-title" style="margin-left: 230px; font-size: 24px; color: #fff;">Add Group</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                {{-- Header form add Groups: END --}}
                <form action="{{ route('admin.groups.add') }}" method="POST">
                    {{-- FORM ADD Groups: START --}}
                    <div class="card-body">
                        <div class="mb-3" width="80%">
                            <label class="form-label fst-normal">Name:</label>
                            <input type="text" name="name" class="form-control" placeholder="Name..."
                                value="{{ old('name') }}">

                            @error('name')
                                <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- FOOTER FORM ADD Groups: START --}}
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Group</button>
                        </div>
                        {{-- FOOTER FORM ADD Groups: END --}}
                    </div>
                    {{-- FORM ADD Groups: END --}}
                    @csrf
                </form>
            </div>
        </div>
    </div>
    {{-- Modal form add Groups: End --}}


    {{-- Modal form edit Groups: Start --}}
    <div class="modal fade" id="editGroup" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                {{-- Header form EDIT user: START --}}
                <div class="modal-header" style="background-color: #4169E1">
                    <h3 class="modal-title" style="margin-left: 230px; font-size: 24px; color: #fff;">Edit User</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                {{-- Header form EDIT user: END --}}
                <form action="{{ route('admin.groups.edit') }}" method="POST">
                    {{-- FORM EDIT USER: START --}}
                    <div class="card-body">
                        <input type="hidden" id="e_id" name="id" class="form-control" placeholder="Enter ID"
                            value="">

                        <div class="mb-3" width="80%">
                            <label class="form-label fst-normal">Name:</label>
                            <input type="text" id="e_name" name="name" class="form-control"
                                placeholder="Enter Name" value="">

                            @error('name')
                                <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- FOOTER FORM EDIT USER: START --}}
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update Group</button>
                        </div>
                        {{-- FOOTER FORM EDIT USER: END --}}
                    </div>
                    {{-- FORM EDIT USER: END --}}
                    @csrf
                </form>
            </div>
        </div>
    </div>
    {{-- Modal form edit Groups: End --}}

    {{-- Script of javascript: Start --}}
@section('script')
    {{-- GET VALUE TO EDIT: START --}}
    <script>
        jQuery(document).on('click', '.editGroup', function() {
            let _this = $(this).parents('tr');
            jQuery('#e_id').val(_this.find('.group_id').text());
            jQuery('#e_name').val(_this.find('.group__name').text());
        })
    </script>
    {{-- GET VALUE TO EDIT: END --}}

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
{{-- Script of javascript: End --}}
@endsection
