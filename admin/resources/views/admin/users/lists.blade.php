@extends('layouts.admin')

@section('title', 'Users')

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

    <!-- Page Heading: Start -->
    <div class="container-fluid p-0">
        <div class="row mb-2 mb-xl-3">
            <div class="col-auto d-none d-sm-block">
                <h3 style="font-size: 32px;">Users</h3>
            </div>
        </div>
    </div>
    <!-- Page Heading: End -->


    {{-- Add users: Start --}}
    @can('create', App\Models\User::class)
        <p>
            <button type="button" class="btn btn-primary fs-2" data-bs-toggle="modal" data-bs-target="#addUser" 
                style="margin-top: 20px;">
                <i class="align-middle me-2 fas fa-fw fa-plus"></i>
                Add User
            </button>
        </p>
    @endcan
    {{-- Add users: End --}}

    {{-- Table manage Users: Start --}}
    <table class="table table-bordered text-center">
        <thead>
            <tr>
                {{-- <th>ID</th> --}}
                <th width="5%">#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Group</th>
                <th width="20%">Functions</th>
                {{-- <th width="5%">Delete</th> --}}
            </tr>
        </thead>
        <tbody>
            @if ($users->count() > 0)
                @foreach ($users as $key => $item)
                    <tr>
                        <td hidden class="user_id">{{ $item->id }}</td>
                        <td>{{ $key + 1 }}</td>
                        <td class="user__name">{{ $item->name }}</td>
                        <td class="user__email">{{ $item->email }}</td>
                        <td class="user__group--name">{{ $item->group->name }}</td>
                        <td>
                            {{-- Button edit: Start --}}
                            @can('users.edit')
                                <a href="{{ route('admin.users.edit')}}" class="btn btn-warning editUser" 
                                    data-bs-toggle="modal" data-bs-target="#editUser" style="width: 45px;">
                                    <i class="align-middle me-2 fas fa-fw fa-pen"></i> <span class="align-middle"></span>
                                </a>
                            @endcan
                            {{-- Button edit: End --}}

                            {{-- Button delete: Start --}}
                            @can('users.delete')
                                @if (Auth::user()->id !== $item->id)
                                    <a onclick="return confirm('Are you sure you want to delete {{ $item->name }}?')" 
                                        href="{{ route('admin.users.delete', $item)}}" 
                                        class="btn btn-danger" style="width: 45px;">
                                        <i class="align-middle me-2 fas fa-fw fa-trash"></i> <span class="align-middle"></span>
                                    </a>    
                                @endif
                            @endcan
                            {{-- Button delete: End --}}
                        </td>

                        {{-- <td>
                            @if (Auth::user()->id !== $item->id)
                                <a onclick="return confirm('Are you sure you want to delete {{ $item->name }}?')" 
                                    href="{{ route('admin.users.delete', $item)}}" 
                                    class="btn btn-danger">
                                    Delete
                                </a>    
                            @endif
                        </td> --}}
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    {{-- Table manage Users: End --}}

    {{-- Modal form add users: Start --}}
    <div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                {{-- Header form add user: START --}}
                <div class="modal-header" style="background-color: #4169E1">
                    <h3 class="modal-title" style="margin-left: 230px; font-size: 24px; color: #fff;">Add User</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                {{-- Header form add user: END --}}
                <form action="{{ route('admin.users.add') }}" method="POST">
                    {{-- FORM ADD USER: START --}}
                    <div class="card-body">
                        <div class="mb-3" width="80%">
                            <label class="form-label fst-normal">Name:</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter Name" value="{{old('name')}}">

                            @error('name') 
                                <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3" width="80%">
                            <label class="form-label fst-normal">Email:</label>
                            <input type="email" name="email" class="form-control" placeholder=" Enter Email" value="{{old('email')}}">

                            @error('email') 
                                <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3" width="80%">
                            <label class="form-label fst-normal">Password:</label>
                            <input type="password" name="password" class="form-control" placeholder="Enter Password">

                            @error('password') 
                                <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3" width="80%">
                            <label class="form-label fst-normal">Group:</label>
                            <select name="group_id" class="form-control">
                                <option value="0">Choose Group</option>
                                @if ($groups->count() > 0)
                                    @foreach ($groups as $item)
                                        <option value="{{$item->id}}" {{old('group_id') == $item->id ? 'selected': false}}>{{$item->name}}</option>
                                    @endforeach
                                @endif
                            </select>

                            @error('group_id') 
                                <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- FOOTER FORM ADD USER: START --}}
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add User</button>
                        </div>
                        {{-- FOOTER FORM ADD USER: END --}}
                    </div>
                    {{-- FORM ADD USER: END --}}
                    @csrf
                </form>

            </div>
        </div>
    </div>
    {{-- Modal form add users: End --}}


    {{-- Modal form edit users: Start --}}
    <div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                {{-- Header form EDIT user: START --}}
                <div class="modal-header" style="background-color: #4169E1">
                    <h3 class="modal-title" style="margin-left: 230px; font-size: 24px; color: #fff;">Edit User</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                {{-- Header form EDIT user: END --}}
                <form action="{{ route('admin.users.edit') }}" method="POST">
                    {{-- FORM EDIT USER: START --}}
                    <div class="card-body">
                        <input type="hidden" id="e_id" name="id" class="form-control" placeholder="Enter ID " value="">
                        
                        <div class="mb-3" width="80%">
                            <label class="form-label fst-normal">Name:</label>
                            <input type="text" id="e_name" name="name" class="form-control" placeholder="Enter Name" value="">

                            @error('name') 
                                <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3" width="80%">
                            <label class="form-label fst-normal">Email:</label>
                            <input type="email" id="e_email" name="email" class="form-control" placeholder="Enter Email" value="">

                            @error('email') 
                                <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3" width="80%">
                            <label class="form-label fst-normal">Password:</label>
                            <input type="password" id="e_password" name="password" class="form-control" placeholder="Enter Password">

                            @error('password') 
                                <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3" width="80%">
                            <label class="form-label fst-normal">Group:</label>
                            <select name="group_id" class="form-control">
                                <option value="0" id="e_group_id">Choose Group</option>
                                @if ($groups->count() > 0)
                                    @foreach ($groups as $item)
                                        <option value="{{$item->id}}" >{{$item->name}}</option>
                                    @endforeach
                                @endif
                            </select>

                            @error('group_id') 
                                <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- FOOTER FORM EDIT USER: START --}}
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update User</button>
                        </div>
                        {{-- FOOTER FORM EDIT USER: END --}}
                    </div>
                    {{-- FORM EDIT USER: END --}}
                    @csrf
                </form>
            </div>
        </div>
    </div>
    {{-- Modal form edit users: End --}}

    @section('script')
        {{-- GET VALUE TO EDIT: START --}}
        <script>
            jQuery(document).on('click', '.editUser', function() {
                let _this = $(this).parents('tr');
                jQuery('#e_id').val(_this.find('.user_id').text());
                jQuery('#e_name').val(_this.find('.user__name').text());
                jQuery('#e_email').val(_this.find('.user__email').text());
            })
        </script>
        {{-- GET VALUE TO EDIT: END --}}

        {{-- ACTIVE TOGGLE DASHBOARD: START --}}
        <script>
            document.querySelector('.admin__users').classList.add('active');
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