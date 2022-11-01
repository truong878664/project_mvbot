<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
    <meta name="author" content="AdminKit">
    <meta name="keywords"
        content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="{{ asset('admins') }}/img/icons/icon-48x48.png">

    <link rel="canonical" href="index.htm">

    <title>@yield('title') - Page Manager</title>

    <link href="{{ asset('admins') }}/css2.css?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    {{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/nipplejs/0.7.3/nipplejs.js"></script> --}}
    <script src="{{ asset('admins') }}/library/nipplejs.js"></script>
    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <!-- Choose your prefered color scheme -->
    <!-- <link href="css/light.css" rel="stylesheet"> -->
    <!-- <link href="css/dark.css" rel="stylesheet"> -->

    <!-- BEGIN SETTINGS -->
    <!-- Remove this after purchasing -->
    <link class="js-stylesheet" href="{{ asset('admins') }}/css/light.css" rel="stylesheet">
    <style>
        body {
            opacity: 0;
        }

        .inactive_icon {
            display: none;
        }

        .active_icon {
            display: inline-block;
        }

        .active_controller {
            display: block;
        }

        .inactive_controller {
            display: none;
        }
    </style>
    <!-- END SETTINGS -->
    <script async="" src="{{ asset('admins') }}/gtag/js.js?id=UA-120946860-10"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-120946860-10', {
            'anonymize_ip': true
        });
    </script>
</head>
<!--
  HOW TO USE:
  data-theme: default (default), dark, light, colored
  data-layout: fluid (default), boxed
  data-sidebar-position: left (default), right
  data-sidebar-layout: default (default), compact
-->

<body data-theme="default" data-layout="fluid" data-sidebar-position="left" data-sidebar-layout="default">
    <div class="wrapper">
        <nav id="sidebar" class="sidebar js-sidebar">
            <div class="sidebar-content js-simplebar">
                <a class="sidebar-brand" href="{{ route('admin.index') }}">
                    <span class="sidebar-brand-text align-middle">
                        <span class="align-middle"><i class="align-middle me-2 fas fa-fw fa-robot"></i>MViBot
                            HiTech</span>
                    </span>
                    <svg class="sidebar-brand-icon align-middle" width="32px" height="32px" viewbox="0 0 24 24"
                        fill="none" stroke="#FFFFFF" stroke-width="1.5" stroke-linecap="square"
                        stroke-linejoin="miter" color="#FFFFFF" style="margin-left: -3px">
                        <path d="M12 4L20 8.00004L12 12L4 8.00004L12 4Z"></path>
                        <path d="M20 12L12 16L4 12"></path>
                        <path d="M20 16L12 20L4 16"></path>
                    </svg>
                </a>


                <ul class="sidebar-nav">
                    <li class="sidebar-header fw-bolder">
                        DASHBOARD
                    </li>

                    <li class="sidebar-item admin__home">
                        <a class="sidebar-link" href="{{ route('admin.index') }}">
                            <i class="align-middle me-2 fas fa-fw fa-table"></i> <span class="align-middle">Home</span>
                        </a>
                    </li>

                    <!-- Divider -->
                    <hr class="sidebar-divider" style="color: #fff;">

                    <li class="sidebar-header fw-bolder">
                        ADMIN
                    </li>

                    @can('groups')
                        <li class="sidebar-item admin__groups">
                            <a class="sidebar-link" href="{{ route('admin.groups.index') }}">
                                <i class="align-middle me-2 fas fa-fw fa-users"></i> <span class="align-middle">Groups
                                    User</span>
                            </a>
                        </li>
                    @endcan

                    @can('users')
                        <li class="sidebar-item admin__users">
                            <a class="sidebar-link" href="{{ route('admin.users.index') }}">
                                <i class="align-middle me-2 fas fa-fw fa-user"></i> <span class="align-middle">Users</span>
                            </a>
                        </li>
                    @endcan

                    <!-- Divider -->
                    <hr class="sidebar-divider" style="color: #fff;">

                    {{-- Interface: Start --}}
                    <li class="sidebar-header fw-bolder">
                        INTERFACE
                    </li>

                    {{-- SideBar Missions: Start --}}
                    <li class="sidebar-item admin__missions">
                        <a data-bs-target="#missions" data-bs-toggle="collapse" class="sidebar-link">
                            <i class="align-middle me-2 fas fa-fw fa-arrow-alt-circle-right"></i> <span
                                class="align-middle">Missions</span>
                        </a>

                        <ul id="missions" class="sidebar-dropdown list-unstyled collapse admin__missions__show"
                            data-bs-parent="#sidebar">
                            <li class="sidebar-item admin__missions__create__points">
                                <a class="sidebar-link" href="{{ route('admin.missions.points.index') }}">Create
                                    Points</a>
                            </li>
                            <li class="sidebar-item admin__missions__create__missions">
                                <a class="sidebar-link" href="{{ route('admin.missions.steps.index') }}">Create
                                    Mission</a>
                            </li>
                            <li class="sidebar-item admin__missions__tracking__missions">
                                <a class="sidebar-link" href="{{ route('admin.missions.tracking.index') }}">Tracking
                                    Mission</a>
                            </li>
                        </ul>
                    </li>
                    {{-- SideBar Missions: End --}}

                    {{-- SideBar Maps: Start --}}
                    <li class="sidebar-item admin__maps">
                        <a data-bs-target="#maps" data-bs-toggle="collapse" class="sidebar-link">
                            <i class="align-middle me-2 fas fa-fw fa-map-marked"></i> <span
                                class="align-middle">Maps</span>
                        </a>

                        <ul id="maps" class="sidebar-dropdown list-unstyled collapse admin__maps__show"
                            data-bs-parent="#sidebar">
                            <li class="sidebar-item admin__maps__list">
                                <a class="sidebar-link" href="{{ route('admin.maps.list.index') }}">List Maps</a>
                            </li>
                            <li class="sidebar-item admin__maps__mapping">
                                <a class="sidebar-link" href="{{ route('admin.maps.mapping.index') }}">Mapping
                                    Tool</a>
                            </li>
                        </ul>
                    </li>
                    {{-- SideBar Maps: End --}}

                    {{-- SideBar Status: Start --}}
                    <li class="sidebar-item admin__status">
                        <a class="sidebar-link" href="{{ route('admin.status.index') }}">
                            <i class="align-middle me-2 far fa-fw fa-list-alt"></i> <span
                                class="align-middle">Status</span>
                        </a>
                    </li>
                    {{-- SideBar Status: End --}}

                    {{-- SideBar Sound: Start --}}
                    <li class="sidebar-item admin__sound">
                        <a class="sidebar-link" href="{{ route('admin.sounds.index') }}">
                            <i class="align-middle me-2 fas fa-fw fa-music"></i> <span
                                class="align-middle">Sound</span>
                        </a>
                    </li>
                    {{-- SideBar Sound: End --}}

                    {{-- SideBar Setting: Start --}}
                    <li class="sidebar-item admin__setting">
                        <a data-bs-target="#setting" data-bs-toggle="collapse" class="sidebar-link">
                            <i class="me-2 fas fa-fw fa-cog"></i> <span class="align-middle">Setting</span>
                        </a>

                        <ul id="setting" class="sidebar-dropdown list-unstyled collapse admin__setting__show"
                            data-bs-parent="#sidebar">
                            <li class="sidebar-item admin__setting__wifi">
                                <a class="sidebar-link" href="{{ route('admin.setting.wifi.index') }}">WiFi</a>
                            </li>
                            <li class="sidebar-item admin__setting__ethernet">
                                <a class="sidebar-link"
                                    href="{{ route('admin.setting.ethernet.index') }}">Ethernet</a>
                            </li>
                            <li class="sidebar-item admin__setting__user">
                                <a class="sidebar-link" href="{{ route('admin.setting.users.index') }}">User</a>
                            </li>
                        </ul>
                    </li>
                    {{-- SideBar Setting: End --}}

                    {{-- Interface: End --}}
                </ul>
            </div>
        </nav>

        <div class="main">
            <nav class="navbar navbar-expand navbar-light navbar-bg">
                <a class="sidebar-toggle js-sidebar-toggle">
                    <i class="hamburger align-self-center"></i>
                </a>

                <form class="d-none d-sm-inline-block">
                    <div class="input-group input-group-navbar">
                        <input type="text" class="form-control" placeholder="Search…" aria-label="Search">
                        <button class="btn" type="button">
                            <i class="align-middle" data-feather="search"></i>
                        </button>
                    </div>
                </form>


                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav navbar-align">
                        <li class="nav-item">
                            <div class="position-relative">
                                <div id="zone_joystick" class="inactive_controller"></div>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-icon js-fullscreen d-none d-lg-block" href="#">
                                <div class="position-relative">
                                    <i class="align-middle" data-feather="maximize"></i>
                                </div>
                            </a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <span
                                    class="mr-2 d-none d-lg-inline text-gray-400 small position-relative">{{ Auth::user()->name }}</span>
                                <img src="{{ asset('admins') }}/img/avatars/undraw_profile.svg"
                                    class="avatar img-fluid rounded" alt="Charles Hall">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                    data-bs-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Logout Modal: Start-->
                <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title" id="exampleModalLabel">Ready to Leave?</h3>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">Select "Logout" below if you are ready to end your current session.
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button"
                                    data-bs-dismiss="modal">Cancel</button>
                                <a class="btn btn-primary" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
									document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                            </div>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Logout Modal: End-->
            </nav>

            <main class="content" style="margin-top: -20px;">
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; MViBot HiTech 2022</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
        </div>
    </div>

    <script src="{{ asset('admins') }}/js/app.js"></script>

    {{-- Rosjs library: Start  --}}
    <script src="{{ asset('admins') }}/roslib/roslib.min.js"></script>
    <script src="{{ asset('admins') }}/roslib/roslib.js"></script>
    <script src="{{ asset('admins') }}/roslib/ros3d.js"></script>
    <script src="{{ asset('admins') }}/roslib/ros3d.min.js"></script>
    <script src="{{ asset('admins') }}/roslib/three.min.js"></script>
    <script src="{{ asset('admins') }}/roslib/three.js"></script>
    <script src="{{ asset('admins') }}/roslib/ColladaLoader.js"></script>
    <script src="{{ asset('admins') }}/ip.js"></script>
    {{-- Rosjs library: Start  --}}

    @yield('script')

    {{-- Connect ros and insert data to database: Start --}}
    <script>
        appAmin = {
            connecting: function() {
                return new Promise(function(resolve) {
                    var ros = new ROSLIB.Ros({
                        url: 'ws://' + ipServer + ':9090'
                    });
                    ros.on('connection', function() {
                        resolve(ros);
                        // alert("Connect");
                    });
                    ros.on('close', function() {
                        alert("Disconnected");
                    });
                })
            },

            getValue: function(ros) {
                //Get value Robot with API: Start
                return new Promise(function(resolve) {
                    fetch(`{{ route('statusRobots.indexApi') }}`)
                        .then(function(response) {
                            return response.json();
                        })
                        .then((dataRobots) => {
                            resolve([ros, dataRobots]);
                        })
                })
            },

            listenRobots: function(dataGet) {
                var iam_listener = new ROSLIB.Topic({
                    ros: dataGet[0],
                    name: "/IAM", //name Topic robot send to web
                    messageType: 'std_msgs/String',
                    queue_size: 1000,
                });

                iam_listener.subscribe(function(message) {
                    // console.log(message.data);
                    // Thêm hoặc cập nhật dữ liệu đã có
                    let index = dataGet[1].findIndex(function(item) {
                        return item.serial === message.data.split('|')[0];
                    });

                    let dataPost = {
                        "serial": message.data.split('|')[0],
                        "mode": message.data.split('|')[1],
                        "volt_pin": message.data.split('|')[2],
                        "percent_pin": message.data.split('|')[3],
                        "radar1": message.data.split('|')[4],
                        "radar2": message.data.split('|')[5],
                        "camera1": message.data.split('|')[6],
                        "camera2": message.data.split('|')[7],
                        "I": message.data.split('|')[8],
                        "charging": message.data.split('|')[9],
                        "cell": message.data.split('|')[10],
                        "option": message.data.split('|')[11]
                    };

                    if (index < 0) {
                        dataGet[1].push(dataPost);
                    } else {
                        dataGet[1].splice(index, 1, dataPost);
                    }

                    // console.log(dataGet[1]);
                    // Get value Robot with API: End
                    dataGet[1].map((dataRe) => {
                        let dataUpdate = {
                            "_token": "{{ csrf_token() }}",
                            "serial": dataRe.serial,
                            "mode": dataRe.mode,
                            "volt_pin": dataRe.volt_pin,
                            "percent_pin": dataRe.percent_pin,
                            "radar1": dataRe.radar1,
                            "radar2": dataRe.radar2,
                            "camera1": dataRe.camera1,
                            "camera2": dataRe.camera2,
                            "I": dataRe.I,
                            "charging": dataRe.charging,
                            "cell": dataRe.cell,
                            "option": dataRe.option
                        };

                        jQuery.ajax({
                            type: 'GET',
                            url: `{{ route('admin.status.addRobot') }}`,
                            data: dataUpdate,
                            contentType: "application/json; charset=utf-8",
                            dataType: "json",
                            cache: false,

                            success: function(data) {
                                // alert(data);
                            },
                        });
                    })
                })

            },

            start: function() {
                this.connecting()
                    .then(this.getValue)
                    .then(this.listenRobots)
            }
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        jQuery(document).ready(function() {
            appAmin.start();
        });
    </script>
    {{-- Connect ros and insert data to database: End --}}
</body>

</html>
