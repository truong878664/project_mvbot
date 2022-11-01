@extends('layouts.admin')

@section('title', 'Missions - Create Missions')

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
        <h1 class="h1 mb-0 text-gray-800">Missions - Create Mission</h1>
    </div>

    {{-- Modal form Functions Groups: Start --}}
    <div class="row" style="margin-top: 48px;">
        {{-- Function of missions: Start --}}
        <div class="card">
            <div class="card-header">
                <h5 class="card-title fs-1">Functions</h5>
                <h6 class="card-subtitle text-muted fs-5">Functions of mission</h6>
            </div>
            
            <div class="card-body">
                <div class="mb-3">
                    @if ($listFunctions)
                        @foreach ($listFunctions as $color => $function)
                            <div class="btn-group">
                                @if ($function == 'Footprint')
                                    <button type="button" class="btn btn-{{$color}} fs-4 mb-2" data-bs-toggle="modal" data-bs-target="#Footprint_{{$function}}">
                                        {{$function}}
                                    </button>
                                @elseif ($function == 'If')
                                    <button type="button" class="btn btn-{{$color}} fs-4 mb-2" data-bs-toggle="modal" data-bs-target="#If_{{$function}}">
                                        {{$function}}
                                    </button>
                                @elseif ($function == 'Else')
                                    <button type="button" class="btn btn-{{$color}} fs-4 mb-2" data-bs-toggle="modal" data-bs-target="#Else_{{$function}}">
                                        {{$function}}
                                    </button>
                                @elseif ($function == 'EndIf')
                                    <button type="button" class="btn btn-{{$color}} fs-4 mb-2" data-bs-toggle="modal" data-bs-target="#EndIf_{{$function}}">
                                        {{$function}}
                                    </button>
                                @elseif ($function == 'IO')
                                    <button type="button" class="btn btn-{{$color}} fs-4 mb-2" data-bs-toggle="modal" data-bs-target="#IO_{{$function}}">
                                        {{$function}}
                                    </button>
                                @elseif ($function == 'TryCatch')
                                    <button type="button" class="btn btn-{{$color}} fs-4 mb-2" data-bs-toggle="modal" data-bs-target="#TryCatch_{{$function}}">
                                        {{$function}}
                                    </button>
                                @else 
                                    <button type="button" class="btn btn-{{$color}} fs-4 mb-2" data-bs-toggle="modal" data-bs-target="#{{$function}}">
                                        {{$function}}
                                    </button>
                                @endif
                            </div>
                            
                            {{-- Modal form add Footprint to group: Start --}}
                            <div class="modal fade" id="Footprint_{{$function}}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background-color: #4169E1">
                                            <h3 class="modal-title" style="margin-left: 20px; font-size: 24px; color: #fff;">Function - {{$function}}</h3>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        {{-- Header form add POINT: END --}}
                                        <form action="{{route('admin.missions.steps.addFootPrintGroups')}}" method="POST">
                                            {{-- FORM ADD POINT: START --}}
                                            <input hidden type="text" name="name_function" class="form-control" value="{{$function}}">

                                            <div class="card-body">
                                                <div class="mb-3" width="80%">
                                                    <label class="form-label fst-normal" for="">Top Width:</label>
                                                    <input type="text" name="top_width" class="form-control" placeholder="Top Width..." value="">

                                                    @error('top_width') 
                                                        <span style="color: red;">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="mb-3" width="80%">
                                                    <label class="form-label fst-normal" for="">Bottom Width:</label>
                                                    <input type="text" name="bottom_width" class="form-control" placeholder="Bottom Width..." value="">

                                                    @error('bottom_width') 
                                                        <span style="color: red;">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="mb-3" width="80%">
                                                    <label class="form-label fst-normal" for="">Top Height:</label>
                                                    <input type="text" name="top_height" class="form-control" placeholder="Top Height..." value="">

                                                    @error('top_height') 
                                                        <span style="color: red;">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="mb-3" width="80%">
                                                    <label class="form-label fst-normal" for="">Bottom Height:</label>
                                                    <input type="text" name="bottom_height" class="form-control" placeholder="Bottom Height..." value="">

                                                    @error('bottom_height') 
                                                        <span style="color: red;">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="mb-3" width="80%">
                                                    <label class="form-label fst-normal" for="">Group Mission:</label>
                                                    <select name="group_mission" id="" class="form-control">
                                                        <option value="0">Choose Group</option>
                                                        @if ($groupMissions->count() > 0)
                                                            @foreach ($groupMissions as $mission)
                                                                <option>{{$mission->name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>

                                                    @error('group_mission') 
                                                        <span style="color: red;">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                {{-- FOOTER FORM ADD POINT: START --}}
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Add Function</button>
                                                </div>
                                                {{-- FOOTER FORM ADD POINT: END --}}
                                            </div>
                                            {{-- FORM ADD POINT: END --}}
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>
                            {{-- Modal form add Footprint to group: End --}}

                            {{-- Modal form add If to group: Start --}}
                            <div class="modal fade" id="If_{{$function}}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background-color: #4169E1">
                                            <h3 class="modal-title" style="margin-left: 20px; font-size: 24px; color: #fff;">Function - {{$function}}</h3>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        {{-- Header form add IF: END --}}
                                        <form action="{{route('admin.missions.steps.addIfGroups')}}" method="POST">
                                            {{-- FORM ADD IF: START --}}
                                            <input hidden type="text" name="name_function" class="form-control" value="{{$function}}">
                                            <div class="card-body">
                                                <div class="mb-3" width="80%">
                                                    <label class="form-label fst-normal" for="">Group Mission:</label>
                                                    <select name="group_mission" id="" class="form-control">
                                                        <option value="0">Choose Group</option>
                                                        @if ($groupMissions->count() > 0)
                                                            @foreach ($groupMissions as $mission)
                                                                <option>{{$mission->name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>

                                                    @error('group_mission') 
                                                        <span style="color: red;">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                {{-- FOOTER FORM ADD IF: START --}}
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Add Function</button>
                                                </div>
                                                {{-- FOOTER FORM ADD IF: END --}}
                                            </div>
                                            {{-- FORM ADD IF: END --}}
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>
                            {{-- Modal form add If to group: END --}}


                            {{-- Modal form add ELSE to group: Start --}}
                            <div class="modal fade" id="Else_{{$function}}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background-color: #4169E1">
                                            <h3 class="modal-title" style="margin-left: 20px; font-size: 24px; color: #fff;">Function - {{$function}}</h3>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        {{-- Header form add ELSE: END --}}
                                        <form action="{{route('admin.missions.steps.addElseGroups')}}" method="POST">
                                            {{-- FORM ADD ELSE: START --}}
                                            <input hidden type="text" name="name_function" class="form-control" value="{{$function}}">
                                            <div class="card-body">
                                                <div class="mb-3" width="80%">
                                                    <label class="form-label fst-normal" for="">Group Mission:</label>
                                                    <select name="group_mission" id="" class="form-control">
                                                        <option value="0">Choose Group</option>
                                                        @if ($groupMissions->count() > 0)
                                                            @foreach ($groupMissions as $mission)
                                                                <option>{{$mission->name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>

                                                    @error('group_mission') 
                                                        <span style="color: red;">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                {{-- FOOTER FORM ADD ELSE: START --}}
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Add Function</button>
                                                </div>
                                                {{-- FOOTER FORM ADD ELSE: END --}}
                                            </div>
                                            {{-- FORM ADD ELSE: END --}}
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>
                            {{-- Modal form add ELSE to group: Start --}}

                            {{-- Modal form add EndIf to group: Start --}}
                            <div class="modal fade" id="EndIf_{{$function}}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background-color: #4169E1">
                                            <h3 class="modal-title" style="margin-left: 20px; font-size: 24px; color: #fff;">Function - {{$function}}</h3>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        {{-- Header form add EndIf: END --}}
                                        <form action="{{route('admin.missions.steps.addEndIfGroups')}}" method="POST">
                                            {{-- FORM ADD EndIf: START --}}
                                            <input hidden type="text" name="name_function" class="form-control" value="{{$function}}">
                                            <div class="card-body">
                                                <div class="mb-3" width="80%">
                                                    <label class="form-label fst-normal" for="">Group Mission:</label>
                                                    <select name="group_mission" id="" class="form-control">
                                                        <option value="0">Choose Group</option>
                                                        @if ($groupMissions->count() > 0)
                                                            @foreach ($groupMissions as $mission)
                                                                <option>{{$mission->name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>

                                                    @error('group_mission') 
                                                        <span style="color: red;">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                {{-- FOOTER FORM ADD EndIf: START --}}
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Add Function</button>
                                                </div>
                                                {{-- FOOTER FORM ADD EndIf: END --}}
                                            </div>
                                            {{-- FORM ADD EndIf: END --}}
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>

                             {{-- Modal form add TryCatch to group: Start --}}
                             <div class="modal fade" id="TryCatch_{{$function}}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background-color: #4169E1">
                                            <h3 class="modal-title" style="margin-left: 20px; font-size: 24px; color: #fff;">Function - {{$function}}</h3>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        {{-- Header form add TryCatch: END --}}
                                        <form action="{{route('admin.missions.steps.addTryCatchGroups')}}" method="POST">
                                            {{-- FORM ADD TryCatch: START --}}
                                            <input hidden type="text" name="name_function" class="form-control" value="{{$function}}">
                                            <div class="card-body">
                                                <div class="mb-3" width="80%">
                                                    <label class="form-label fst-normal" for="">Group Mission:</label>
                                                    <select name="group_mission" id="" class="form-control">
                                                        <option value="0">Choose Group</option>
                                                        @if ($groupMissions->count() > 0)
                                                            @foreach ($groupMissions as $mission)
                                                                <option>{{$mission->name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>

                                                    @error('group_mission') 
                                                        <span style="color: red;">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                {{-- FOOTER FORM ADD EndIf: START --}}
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Add Function</button>
                                                </div>
                                                {{-- FOOTER FORM ADD EndIf: END --}}
                                            </div>
                                            {{-- FORM ADD EndIf: END --}}
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>
                            {{-- Modal form add ELSE to group: Start --}}
                            
                            {{-- Modal form add IO to group: Start --}}
                            <div class="modal fade" id="IO_{{$function}}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background-color: #4169E1">
                                            <h3 class="modal-title" style="margin-left: 20px; font-size: 24px; color: #fff;">Function - {{$function}}</h3>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        {{-- Header form add IO: END --}}
                                        <form action="{{route('admin.missions.steps.addIOGroups')}}" method="POST">
                                            {{-- FORM ADD IO: START --}}
                                            <input hidden type="text" name="name_function" class="form-control" value="{{$function}}">
                                            <div class="card-body">
                                                <div class="mb-3" width="80%">
                                                    <label class="form-label fst-normal" for="">Group Mission:</label>
                                                    <select name="group_mission" id="" class="form-control">
                                                        <option value="0">Choose Group</option>
                                                        @if ($groupMissions->count() > 0)
                                                            @foreach ($groupMissions as $mission)
                                                                <option>{{$mission->name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>

                                                    @error('group_mission') 
                                                        <span style="color: red;">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="mb-3" width="80%">
                                                    <label class="form-label fst-normal" for="">IO Activation:</label>
                                                    <input type="text" name="io_1" class="form-control" placeholder="Enter the number of IO pins to be activated" value="">
                                                </div>
                                                {{-- FOOTER FORM ADD IO: START --}}
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Add Function</button>
                                                </div>
                                                {{-- FOOTER FORM ADD IO: END --}}
                                            </div>
                                            {{-- FORM ADD IO: END --}}
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>
                            {{-- Modal form add IO to group: Start --}}

                            {{-- Modal form add TryCatch to group: Start --}}
                            <div class="modal fade" id="TryCatch_{{$function}}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background-color: #4169E1">
                                            <h3 class="modal-title" style="margin-left: 20px; font-size: 24px; color: #fff;">Function - {{$function}}</h3>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        {{-- Header form add TryCatch: END --}}
                                        <form action="#" method="POST">
                                            {{-- FORM ADD TryCatch: START --}}
                                            <input hidden type="text" name="name_function" class="form-control" value="{{$function}}">
                                            <div class="card-body">
                                                <div class="mb-3" width="80%">
                                                    <label class="form-label fst-normal" for="">Group Mission:</label>
                                                    <select name="group_mission" id="" class="form-control">
                                                        <option value="0">Choose Group</option>
                                                        @if ($groupMissions->count() > 0)
                                                            @foreach ($groupMissions as $mission)
                                                                <option>{{$mission->name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>

                                                    @error('group_mission') 
                                                        <span style="color: red;">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                {{-- FOOTER FORM ADD TryCatch: START --}}
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary">Add Function</button>
                                                </div>
                                                {{-- FOOTER FORM ADD TryCatch: END --}}
                                            </div>
                                            {{-- FORM ADD TryCatch: END --}}
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>
                            {{-- Modal form add TryCatch to group: Start --}}
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        {{-- Function of missions: End --}}

        {{-- Actions of missions: Start --}}
        <div class="card">
            <div class="card-header">
                <h5 class="card-title fs-1">Actions</h5>
                <h6 class="card-subtitle text-muted fs-5">Actions of Mission</h6>
            </div>
            
            <div class="card-body">
                <div class="mb-3">
                    @if ($listActions)
                        @foreach ($listActions as $color => $action)
                            <div class="btn-group">
                                @if ($action == 'Music')
                                    <button type="button" class="btn btn-{{$color}} fs-4 mb-2" data-bs-toggle="modal" data-bs-target="#Music__{{$action}}">
                                        {{$action}}
                                    </button>
                                @elseif ($action == 'Sleep')
                                    <button type="button" class="btn btn-{{$color}} fs-4 mb-2" data-bs-toggle="modal" data-bs-target="#Sleep__{{$action}}">
                                        {{$action}}
                                    </button>
                                @elseif ($action == 'Warning')
                                    <button type="button" class="btn btn-{{$color}} fs-4 mb-2" data-bs-toggle="modal" data-bs-target="#Warning__{{$action}}">
                                        {{$action}}
                                    </button>
                                @elseif ($action == 'Timeout')
                                    <button type="button" class="btn btn-{{$color}} fs-4 mb-2" data-bs-toggle="modal" data-bs-target="#Timeout__{{$action}}">
                                        {{$action}}
                                    </button>
                                @else 
                                    <button type="button" class="btn btn-{{$color}} fs-4 mb-2" data-bs-toggle="modal" data-bs-target="#{{$action}}">
                                        {{$action}}
                                    </button>
                                @endif
                            </div>
                        
                            {{-- Modal form Music to robot: Start --}}
                            <div class="modal fade" id="Music__{{$action}}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background-color: #4169E1">
                                            <h3 class="modal-title" style="margin-left: 20px; font-size: 24px; color: #fff;">Action - {{$action}}</h3>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        {{-- Header form add POINT: END --}}
                                        <form action="{{route('admin.missions.steps.addMusicGroups')}}" method="POST">
                                            {{-- FORM ADD POINT: START --}}
                                            <input hidden type="text" name="name_action" class="form-control" value="{{$action}}">
                                            <div class="card-body">
                                                <div class="mb-3" width="80%">
                                                    <label class="form-label fst-normal" for="">Name Music:</label>
                                                    <input type="text" name="name_music" class="form-control" placeholder="Enter the name of music" value="">

                                                    @error('name_music') 
                                                        <span style="color: red;">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="mb-3" width="80%">
                                                    <label class="form-label fst-normal" for="inputState">Group Mission:</label>
                                                    <select name="group_mission" id="inputState" class="form-control">
                                                        <option value="0">Choose Group</option>
                                                        @if ($groupMissions->count() > 0)
                                                            @foreach ($groupMissions as $mission)
                                                                <option>{{$mission->name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    @error('group_mission') 
                                                        <span style="color: red;">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                {{-- FOOTER FORM ADD POINT: START --}}
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Add Music</button>
                                                </div>
                                                {{-- FOOTER FORM ADD POINT: END --}}
                                            </div>
                                            {{-- FORM ADD POINT: END --}}
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>
                            {{-- Modal form Music to robot: End --}}
                            
                            {{-- Modal form Sleep to robot: Start --}}
                            <div class="modal fade" id="Sleep__{{$action}}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background-color: #4169E1">
                                            <h3 class="modal-title" style="margin-left: 20px; font-size: 24px; color: #fff;">Action - {{$action}}</h3>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        {{-- Header form add POINT: END --}}
                                        <form action="{{route('admin.missions.steps.addSleepGroups')}}" method="POST">
                                            {{-- FORM ADD POINT: START --}}
                                            <input hidden type="text" name="name_action" class="form-control" value="{{$action}}">
                                            
                                            <div class="card-body">
                                                <div class="mb-3" width="80%">
                                                    <label class="form-label fst-normal" for="">Time:</label>
                                                    <input type="text" name="time_sleep" class="form-control" placeholder="Enter the time to sleep" value="">

                                                    @error('time_sleep') 
                                                        <span style="color: red;">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="mb-3" width="80%">
                                                    <label class="form-label fst-normal" for="inputState">Group Mission:</label>
                                                    <select name="group_mission" id="inputState" class="form-control">
                                                        <option value="0">Choose Group</option>
                                                        @if ($groupMissions->count() > 0)
                                                            @foreach ($groupMissions as $mission)
                                                                <option>{{$mission->name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>

                                                    @error('group_mission') 
                                                        <span style="color: red;">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                {{-- FOOTER FORM ADD POINT: START --}}
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Add Sleep</button>
                                                </div>
                                                {{-- FOOTER FORM ADD POINT: END --}}
                                            </div>
                                            {{-- FORM ADD POINT: END --}}
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>
                            {{-- Modal form Sleep to robot: End --}}


                            {{-- Modal form Warning to robot: Start --}}
                            <div class="modal fade" id="Warning__{{$action}}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background-color: #4169E1">
                                            <h3 class="modal-title" style="margin-left: 20px; font-size: 24px; color: #fff;">Action - {{$action}}</h3>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        {{-- Header form add POINT: END --}}
                                        <form action="{{route('admin.missions.steps.addWarningGroups')}}" method="POST">
                                            
                                            {{-- FORM ADD POINT: START --}}
                                            <input hidden type="text" name="name_action" class="form-control" value="{{$action}}">
                                            
                                            <div class="card-body">
                                                <div class="mb-3" width="80%">
                                                    <label class="form-label fst-normal" for="">Signal:</label>
                                                    <input type="text" name="signal" class="form-control" placeholder="Enter input signal to make request " value="">
                                                    @error('signal') 
                                                        <span style="color: red;">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="mb-3" width="80%">
                                                    <label class="form-label fst-normal" for="inputState">Group Mission:</label>
                                                    <select name="group_mission" id="inputState" class="form-control">
                                                        <option value="0">Choose Group</option>
                                                        @if ($groupMissions->count() > 0)
                                                            @foreach ($groupMissions as $mission)
                                                                <option>{{$mission->name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>

                                                    @error('group_mission') 
                                                        <span style="color: red;">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                {{-- FOOTER FORM ADD POINT: START --}}
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Add Signal</button>
                                                </div>
                                                {{-- FOOTER FORM ADD POINT: END --}}
                                            </div>
                                            {{-- FORM ADD POINT: END --}}
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>
                            {{-- Modal form Warning to robot: End --}}

                            {{-- Modal form TimeOut to robot: Start --}}
                            <div class="modal fade" id="Timeout__{{$action}}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background-color: #4169E1">
                                            <h3 class="modal-title" style="margin-left: 20px; font-size: 24px; color: #fff;">Action - {{$action}}</h3>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        {{-- Header form add POINT: END --}}
                                        <form action="{{route('admin.missions.steps.addTimeoutGroups')}}" method="POST">
                                            
                                            {{-- FORM ADD POINT: START --}}
                                            <input hidden type="text" name="name_action" class="form-control" value="{{$action}}">
                                            
                                            <div class="card-body">
                                                <div class="mb-3" width="80%">
                                                    <label class="form-label fst-normal" for="">Signal:</label>
                                                    <input type="text" name="number" class="form-control" placeholder="Enter input number to make request " value="">
                                                    @error('number') 
                                                        <span style="color: red;">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="mb-3" width="80%">
                                                    <label class="form-label fst-normal" for="inputState">Group Mission:</label>
                                                    <select name="group_mission" id="inputState" class="form-control">
                                                        <option value="0">Choose Group</option>
                                                        @if ($groupMissions->count() > 0)
                                                            @foreach ($groupMissions as $mission)
                                                                <option>{{$mission->name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>

                                                    @error('group_mission') 
                                                        <span style="color: red;">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                {{-- FOOTER FORM ADD POINT: START --}}
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Add Signal</button>
                                                </div>
                                                {{-- FOOTER FORM ADD POINT: END --}}
                                            </div>
                                            {{-- FORM ADD POINT: END --}}
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>
                            {{-- Modal form Warning to robot: End --}}
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        {{-- Actions of missions: End --}}

        {{-- Points of missions: Start --}}
        <div class="card">
            <div class="card-header">
                <h5 class="card-title fs-1">List Points</h5>
                <h6 class="card-subtitle text-muted fs-5">Step of Mission</h6>
            </div>

            <div class="card-body">
                <div class="mb-3">
                    @if ($points->count() > 0)
                        @foreach ($points as $point)
                            <div class="btn-group">
                                <button type="button" class="btn btn-{{$point->type}} fs-4 mb-2" data-bs-toggle="modal" data-bs-target="#point_{{$point->name}}" >
                                    {{$point->name}}
                                </button>
                            </div>

                            {{-- Modal form add point to group: Start --}}
                            <div class="modal fade" id="point_{{$point->name}}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background-color: #4169E1">
                                            <h3 class="modal-title" style="margin-left: 245px; font-size: 24px; color: #fff;">{{$point->name}}</h3>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        {{-- Header form add POINT: END --}}
                                        <form action="{{route('admin.missions.steps.addPointGroups', $point)}}" method="POST">
                                            {{-- FORM ADD POINT: START --}}
                                            <div class="card-body">
                                                <div class="mb-3" width="80%">
                                                    <label class="form-label fst-normal" for="inputState">Describe Point:</label>
                                                    {{-- Describe point --}}
                                                    <textarea name="describe" class="form-control" placeholder="{{$point->describe}}" rows="1" value="{{$point->describe}}" readonly=""></textarea>
                                                </div>

                                                <div class="mb-3" width="80%">
                                                    <label class="form-label fst-normal" for="inputState">Group Mission:</label>
                                                    <select name="group_mission" id="inputState" class="form-control">
                                                        <option value="0">Choose Group</option>
                                                        @if ($groupMissions->count() > 0)
                                                            @foreach ($groupMissions as $mission)
                                                                <option>{{$mission->name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>

                                                    @error('group_mission') 
                                                        <span style="color: red;">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                {{-- FOOTER FORM ADD POINT: START --}}
                                                <div class="modal-footer">
                                                    <a href="{{route('admin.missions.points.deletePoint', $point)}}">
                                                        <button onclick="return confirm('Do you want to delete {{$point->name}}?')" type="button" class="btn btn-danger float-start">Delete {{$point->name}}</button>

                                                    </a>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Add Point</button>
                                                </div>
                                                {{-- FOOTER FORM ADD POINT: END --}}
                                            </div>
                                            {{-- FORM ADD POINT: END --}}
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>
                            {{-- Modal form add point to group: End --}}
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        {{-- Points of missions: End --}}

        {{-- Step of missions: Start --}}
        <div class="card">
            <div class="card-header">
                <h5 class="card-title fs-1">Step Mission</h5>
                <h6 class="card-subtitle text-muted fs-5">List Step Mission</h6>
            </div>
    
            <div class="card-body">
                <div class="mb-3">
                    <button type="button" class="btn btn-primary fs-2" data-bs-toggle="modal" data-bs-target="#addGroup">
                        Step Mission
                    </button>
                </div>

                
        {{-- Step of missions: End --}}

     {{-- Groups Mission: Start --}}
     <div class="card">
        <div class="card-header">
            <h5 class="card-title fs-1">Groups Missions</h5>
            <h6 class="card-subtitle text-muted fs-5">List Group Missions</h6>
        </div>

        <div class="card-body">
            <div class="mb-3">
                <button type="button" class="btn btn-primary fs-2" data-bs-toggle="modal" data-bs-target="#addGroup">
                    Create Mission
                </button>
            </div>

            <div class="mb-3">
                @if ($groupMissions->count() > 0)
                    @foreach ($groupMissions as $group)
                        <div style="text-decoration: none;">
                            <div class="card-body rounded border list-group-item border-primary mb-4">
                                <h3 class="card-title mb-4" style="font-size: 20px; color: #4169E1;">
                                    {{$group->name}}
                                </h3>

                                @if($group->steps)
                                    <input hidden type="text" id="e__steps__missions" class="form-control" value="{{$group->steps}}">
                                    @foreach (explode("@",$group->steps) as $point)
                                        <span class="align-middle">
                                            <button class="btn btn-{{explode("|", $point)[1]}} fs-4 mb-2">
                                                {{explode("|", $point)[0]}}
                                            </button>
                                            {{-- <span class="indicator">4</span> --}}
                                        </span>
                                    @endforeach
                                @endif
                                
                                <div class="float-end">
                                    <a href="{{route('admin.missions.steps.deleteGroup', $group)}}" style="text-decoration: none;">
                                        <button onclick="return confirm('Do you want to delete {{$group->name}}?')" class="btn btn-danger fs-4 mb-2" style="margin-right: 10px;">
                                            Delete
                                        </button>
                                    </a>
                                    
                                    <a href="#">
                                        <button type="button" class="btn btn-primary fs-4 mb-2" data-bs-toggle="modal" data-bs-target="#sendTo_{{$group->name}}" >
                                            Send
                                        </button>
                                    </a>
                                </div>
                                
                                {{-- Modal form add point to group: Start --}}
                                <div class="modal fade" id="sendTo_{{$group->name}}" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color: #4169E1">
                                                <h3 class="modal-title" style="margin-left: 185px; font-size: 24px; color: #fff;">Send Mission To...</h3>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            {{-- Header form add POINT: END --}}
                                            
                                            <form action="{{route('admin.missions.steps.sendMission', $group)}}" method="POST">
                                                {{-- FORM ADD POINT: START --}}
                                                <input hidden type="text" id="e__steps__missions__send" name="steps__missions" class="form-control" value="{{$group->steps}}">
                                                
                                                <div class="card-body">
                                                    <div class="mb-3" width="80%">
                                                        <label class="form-label fst-normal" for="">Time Mission:</label>
                                                        <input type="text" name="time_mission" class="form-control" placeholder="Time Mission..." value="">
    
                                                        @error('time_mission') 
                                                            <span style="color: red;">{{ $message }}</span>
                                                        @enderror
                                                    </div>

                                                    <div class="mb-3" width="80%">
                                                        <label class="form-label fst-normal" for="e_name_robot">Choose Robot:</label>
                                                        <select name="name_robot" id="e_name_robot" class="form-control">
                                                            <option value="0">Choose Robot</option>
                                                            @if ($listsRobot->count() > 0)
                                                                @foreach ($listsRobot as $robot)
                                                                    <option value="{{$robot->serial}}">{{$robot->serial}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>

                                                        @error('name_robot') 
                                                            <span style="color: red;">{{ $message }}</span>
                                                        @enderror
                                                    </div>

                                                    {{-- FOOTER FORM ADD POINT: START --}}
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary btn__send">Send To</button>
                                                    </div>
                                                    {{-- FOOTER FORM ADD POINT: END --}}
                                                </div>
                                                {{-- FORM ADD POINT: END --}}
                                                @csrf
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                {{-- Modal form add point to group: End --}}
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    {{-- Groups Mission: End --}}
</div>
    {{-- Modal form Functions Groups: End --}}

    {{-- Modal form add Groups: Start --}}
    <div class="modal fade" id="addGroup" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                {{-- Header form add Groups: START --}}
                <div class="modal-header" style="background-color: #4169E1">
                    <h3 class="modal-title" style="margin-left: 230px; font-size: 24px; color: #fff;">Create Mission</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                {{-- Header form add Groups: END --}}
                <form action="{{ route('admin.missions.steps.addGroups') }}" method="POST">
                    {{-- FORM ADD Groups: START --}}
                    <div class="card-body">
                        <div class="mb-3" width="80%">
                            <label class="form-label fst-normal">Name:</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter The Name of  Mission" value="">

                            @error('name') 
                                <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- FOOTER FORM ADD Groups: START --}}
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create Mission</button>
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

    @section('script')
        {{-- ACTIVE TOGGLE DASHBOARD: START --}}
        <script>
            document.querySelector('.admin__missions').classList.add('active');
            document.querySelector('.admin__missions__create__missions').classList.add('active');
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

        {{-- Send Mission to robot: Start --}}
        <script>
        
            let allStepsMissions = document.querySelectorAll('#e__steps__missions');
            let allBtnSend = document.querySelectorAll('.btn__send');
            allBtnSend.forEach(function(btnSend, index) {
                btnSend.onclick = function() {

                    let stepsMission = allStepsMissions[index].getAttribute('value');
                    // console.log(stepsMission);
                    jQuery('#e__steps__missions__send').val(stepsMission);
                }
            })
        </script>
        {{-- Send Mission to robot: End --}}
    @endsection
@endsection