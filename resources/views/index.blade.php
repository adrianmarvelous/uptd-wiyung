<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>UPTB Wiyung</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="{{ asset('templetes/kaiadmin-lite/assets/img/kaiadmin/favicon.ico') }}"
        type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="{{ asset('templetes/kaiadmin-lite/assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["assets/css/fonts.min.css"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('templetes/kaiadmin-lite/assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('templetes/kaiadmin-lite/assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('templetes/kaiadmin-lite/assets/css/kaiadmin.min.css') }}" />

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="{{ asset('templetes/kaiadmin-lite/assets/css/demo.css') }}" />
    <style>
        .bg-gradient-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .bg-gradient-success { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }
        .rounded-4 { border-radius: 1rem !important; }
    </style>
</head>

<body>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                confirmButtonText: 'OK' // tulisan tombol
            });
        </script>
    @endif


    {{-- ❌ Error dari session (catch di controller) --}}
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
            });
        </script>
    @endif

    {{-- ⚠️ Error dari Laravel validation --}}
    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal!',
                html: `{!! implode('<br>', $errors->all()) !!}`, // tampilkan semua error dalam 1 popup
            });
        </script>
    @endif

    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar sidebar-style-2 text-white"  data-background-color="dark">
            <div class="sidebar-logo">
                <!-- Logo Header -->
                <div class="logo-header" data-background-color="dark">
                    <a href="/" class="logo text-white">
                        UPTB Wiyung
                    </a>
                    <div class="nav-toggle">
                        <button class="btn btn-toggle toggle-sidebar">
                            <i class="gg-menu-right"></i>
                        </button>
                        <button class="btn btn-toggle sidenav-toggler">
                            <i class="gg-menu-left"></i>
                        </button>
                    </div>
                    <button class="topbar-toggler more">
                        <i class="gg-more-vertical-alt"></i>
                    </button>
                </div>
                <!-- End Logo Header -->
            </div>
            <div class="sidebar-wrapper scrollbar scrollbar-inner text-whi">
                <div class="sidebar-content">
                    <ul class="nav nav-secondary">
                        {{-- <li class="nav-item">
                <a
                  data-bs-toggle="collapse"
                  href="#dashboard"
                  class="collapsed"
                  aria-expanded="false"
                >
                  <i class="fas fa-home"></i>
                  <p>Dashboard</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="dashboard">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="../demo1/index.html">
                        <span class="sub-item">Dashboard 1</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li> --}}
                        <li class="nav-section">
                            <span class="sidebar-mini-icon">
                                <i class="fa fa-ellipsis-h"></i>
                            </span>
                            <h4 class="text-section text-white">Main Menu</h4>
                        </li>
                        {{-- <li class="nav-item">
                <a data-bs-toggle="collapse" href="#base">
                  <i class="fas fa-layer-group"></i>
                  <p>Base</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="base">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="components/avatars.html">
                        <span class="sub-item">Avatars</span>
                      </a>
                    </li>
                    <li>
                      <a href="components/buttons.html">
                        <span class="sub-item">Buttons</span>
                      </a>
                    </li>
                    <li>
                      <a href="components/gridsystem.html">
                        <span class="sub-item">Grid System</span>
                      </a>
                    </li>
                    <li>
                      <a href="components/panels.html">
                        <span class="sub-item">Panels</span>
                      </a>
                    </li>
                    <li>
                      <a href="components/notifications.html">
                        <span class="sub-item">Notifications</span>
                      </a>
                    </li>
                    <li>
                      <a href="components/sweetalert.html">
                        <span class="sub-item">Sweet Alert</span>
                      </a>
                    </li>
                    <li>
                      <a href="components/font-awesome-icons.html">
                        <span class="sub-item">Font Awesome Icons</span>
                      </a>
                    </li>
                    <li>
                      <a href="components/simple-line-icons.html">
                        <span class="sub-item">Simple Line Icons</span>
                      </a>
                    </li>
                    <li>
                      <a href="components/typography.html">
                        <span class="sub-item">Typography</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item active submenu">
                <a data-bs-toggle="collapse" href="#sidebarLayouts">
                  <i class="fas fa-th-list"></i>
                  <p>Sidebar Layouts</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse show" id="sidebarLayouts">
                  <ul class="nav nav-collapse">
                    <li class="active">
                      <a href="sidebar-style-2.html">
                        <span class="sub-item">Sidebar Style 2</span>
                      </a>
                    </li>
                    <li>
                      <a href="icon-menu.html">
                        <span class="sub-item">Icon Menu</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li> --}}
                        <li class="nav-item">
                            <a href="{{ route('berita_acara', ['jenis' => 'OP']) }}">
                                {{-- <i class="fa fa-desktop"></i> --}}
                                <p class="text-white">Berita Acara PBJT</p>
                                {{-- <span class="badge badge-success">4</span> --}}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('berita_acara', ['jenis' => 'pbb']) }}">
                                {{-- <i class="fa fa-desktop"></i> --}}
                                <p class="text-white">Berita Acara PBB</p>
                                {{-- <span class="badge badge-success">4</span> --}}
                            </a>
                        </li>
                        @if (auth()->user()->role === 'admin')
                            <li class="nav-item">
                                <a href="{{ route('berita_acara.petugas') }}">
                                    {{-- <i class="fa fa-desktop"></i> --}}
                                    <p class="text-white">By Nama Petugas</p>
                                    {{-- <span class="badge badge-success">4</span> --}}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('berita_acara.wp', ['jenis' => 'pbjt']) }}">
                                    {{-- <i class="fa fa-desktop"></i> --}}
                                    <p class="text-white">By Wajib Pajak PBJT</p>
                                    {{-- <span class="badge badge-success">4</span> --}}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('berita_acara.wp', ['jenis' => 'pbb']) }}">
                                    {{-- <i class="fa fa-desktop"></i> --}}
                                    <p class="text-white">By Wajib Pajak PBB</p>
                                    {{-- <span class="badge badge-success">4</span> --}}
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <!-- End Sidebar -->

        <div class="main-panel">
            <div class="main-header">
                <div class="main-header-logo">
                    <!-- Logo Header -->
                    <div class="logo-header" data-background-color="dark">
                        <a href="index.html" class="logo">
                            <img src="{{ asset('templetes/kaiadmin-lite/assets/img/kaiadmin/logo_light.svg') }}"
                                alt="navbar brand" class="navbar-brand" height="20" />
                        </a>
                        <div class="nav-toggle">
                            <button class="btn btn-toggle toggle-sidebar">
                                <i class="gg-menu-right"></i>
                            </button>
                            <button class="btn btn-toggle sidenav-toggler">
                                <i class="gg-menu-left"></i>
                            </button>
                        </div>
                        <button class="topbar-toggler more">
                            <i class="gg-more-vertical-alt"></i>
                        </button>
                    </div>
                    <!-- End Logo Header -->
                </div>
                <!-- Navbar Header -->
                <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
                    <div class="container-fluid">
                        <nav
                            class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="submit" class="btn btn-search pe-1">
                                        <i class="fa fa-search search-icon"></i>
                                    </button>
                                </div>
                                <input type="text" placeholder="Search ..." class="form-control" />
                            </div>
                        </nav>

                        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                            {{-- <li
                  class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none"
                >
                  <a
                    class="nav-link dropdown-toggle"
                    data-bs-toggle="dropdown"
                    href="#"
                    role="button"
                    aria-expanded="false"
                    aria-haspopup="true"
                  >
                    <i class="fa fa-search"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-search animated fadeIn">
                    <form class="navbar-left navbar-form nav-search">
                      <div class="input-group">
                        <input
                          type="text"
                          placeholder="Search ..."
                          class="form-control"
                        />
                      </div>
                    </form>
                  </ul>
                </li>
                <li class="nav-item topbar-icon dropdown hidden-caret">
                  <a
                    class="nav-link dropdown-toggle"
                    href="#"
                    id="messageDropdown"
                    role="button"
                    data-bs-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                  >
                    <i class="fa fa-envelope"></i>
                  </a>
                  <ul
                    class="dropdown-menu messages-notif-box animated fadeIn"
                    aria-labelledby="messageDropdown"
                  >
                    <li>
                      <div
                        class="dropdown-title d-flex justify-content-between align-items-center"
                      >
                        Messages
                        <a href="#" class="small">Mark all as read</a>
                      </div>
                    </li>
                    <li>
                      <div class="message-notif-scroll scrollbar-outer">
                        <div class="notif-center">
                          <a href="#">
                            <div class="notif-img">
                              <img
                                src="{{ asset('templetes/kaiadmin-lite/assets/img/jm_denis.jpg')}}"
                                alt="Img Profile"
                              />
                            </div>
                            <div class="notif-content">
                              <span class="subject">Jimmy Denis</span>
                              <span class="block"> How are you ? </span>
                              <span class="time">5 minutes ago</span>
                            </div>
                          </a>
                          <a href="#">
                            <div class="notif-img">
                              <img
                                src="{{ asset('templetes/kaiadmin-lite/assets/img/chadengle.jpg')}}"
                                alt="Img Profile"
                              />
                            </div>
                            <div class="notif-content">
                              <span class="subject">Chad</span>
                              <span class="block"> Ok, Thanks ! </span>
                              <span class="time">12 minutes ago</span>
                            </div>
                          </a>
                          <a href="#">
                            <div class="notif-img">
                              <img
                                src="{{ asset('templetes/kaiadmin-lite/assets/img/mlane.jpg')}}"
                                alt="Img Profile"
                              />
                            </div>
                            <div class="notif-content">
                              <span class="subject">Jhon Doe</span>
                              <span class="block">
                                Ready for the meeting today...
                              </span>
                              <span class="time">12 minutes ago</span>
                            </div>
                          </a>
                          <a href="#">
                            <div class="notif-img">
                              <img
                                src="{{ asset('templetes/kaiadmin-lite/assets/img/talha.jpg')}}"
                                alt="Img Profile"
                              />
                            </div>
                            <div class="notif-content">
                              <span class="subject">Talha</span>
                              <span class="block"> Hi, Apa Kabar ? </span>
                              <span class="time">17 minutes ago</span>
                            </div>
                          </a>
                        </div>
                      </div>
                    </li>
                    <li>
                      <a class="see-all" href="javascript:void(0);"
                        >See all messages<i class="fa fa-angle-right"></i>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="nav-item topbar-icon dropdown hidden-caret">
                  <a
                    class="nav-link dropdown-toggle"
                    href="#"
                    id="notifDropdown"
                    role="button"
                    data-bs-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                  >
                    <i class="fa fa-bell"></i>
                    <span class="notification">4</span>
                  </a>
                  <ul
                    class="dropdown-menu notif-box animated fadeIn"
                    aria-labelledby="notifDropdown"
                  >
                    <li>
                      <div class="dropdown-title">
                        You have 4 new notification
                      </div>
                    </li>
                    <li>
                      <div class="notif-scroll scrollbar-outer">
                        <div class="notif-center">
                          <a href="#">
                            <div class="notif-icon notif-primary">
                              <i class="fa fa-user-plus"></i>
                            </div>
                            <div class="notif-content">
                              <span class="block"> New user registered </span>
                              <span class="time">5 minutes ago</span>
                            </div>
                          </a>
                          <a href="#">
                            <div class="notif-icon notif-success">
                              <i class="fa fa-comment"></i>
                            </div>
                            <div class="notif-content">
                              <span class="block">
                                Rahmad commented on Admin
                              </span>
                              <span class="time">12 minutes ago</span>
                            </div>
                          </a>
                          <a href="#">
                            <div class="notif-img">
                              <img
                                src="assets/img/profile2.jpg"
                                alt="Img Profile"
                              />
                            </div>
                            <div class="notif-content">
                              <span class="block">
                                Reza send messages to you
                              </span>
                              <span class="time">12 minutes ago</span>
                            </div>
                          </a>
                          <a href="#">
                            <div class="notif-icon notif-danger">
                              <i class="fa fa-heart"></i>
                            </div>
                            <div class="notif-content">
                              <span class="block"> Farrah liked Admin </span>
                              <span class="time">17 minutes ago</span>
                            </div>
                          </a>
                        </div>
                      </div>
                    </li>
                    <li>
                      <a class="see-all" href="javascript:void(0);"
                        >See all notifications<i class="fa fa-angle-right"></i>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="nav-item topbar-icon dropdown hidden-caret">
                  <a
                    class="nav-link"
                    data-bs-toggle="dropdown"
                    href="#"
                    aria-expanded="false"
                  >
                    <i class="fas fa-layer-group"></i>
                  </a>
                  <div class="dropdown-menu quick-actions animated fadeIn">
                    <div class="quick-actions-header">
                      <span class="title mb-1">Quick Actions</span>
                      <span class="subtitle op-7">Shortcuts</span>
                    </div>
                    <div class="quick-actions-scroll scrollbar-outer">
                      <div class="quick-actions-items">
                        <div class="row m-0">
                          <a class="col-6 col-md-4 p-0" href="#">
                            <div class="quick-actions-item">
                              <div class="avatar-item bg-danger rounded-circle">
                                <i class="far fa-calendar-alt"></i>
                              </div>
                              <span class="text">Calendar</span>
                            </div>
                          </a>
                          <a class="col-6 col-md-4 p-0" href="#">
                            <div class="quick-actions-item">
                              <div
                                class="avatar-item bg-warning rounded-circle"
                              >
                                <i class="fas fa-map"></i>
                              </div>
                              <span class="text">Maps</span>
                            </div>
                          </a>
                          <a class="col-6 col-md-4 p-0" href="#">
                            <div class="quick-actions-item">
                              <div class="avatar-item bg-info rounded-circle">
                                <i class="fas fa-file-excel"></i>
                              </div>
                              <span class="text">Reports</span>
                            </div>
                          </a>
                          <a class="col-6 col-md-4 p-0" href="#">
                            <div class="quick-actions-item">
                              <div
                                class="avatar-item bg-success rounded-circle"
                              >
                                <i class="fas fa-envelope"></i>
                              </div>
                              <span class="text">Emails</span>
                            </div>
                          </a>
                          <a class="col-6 col-md-4 p-0" href="#">
                            <div class="quick-actions-item">
                              <div
                                class="avatar-item bg-primary rounded-circle"
                              >
                                <i class="fas fa-file-invoice-dollar"></i>
                              </div>
                              <span class="text">Invoice</span>
                            </div>
                          </a>
                          <a class="col-6 col-md-4 p-0" href="#">
                            <div class="quick-actions-item">
                              <div
                                class="avatar-item bg-secondary rounded-circle"
                              >
                                <i class="fas fa-credit-card"></i>
                              </div>
                              <span class="text">Payments</span>
                            </div>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </li> --}}

                            <li class="nav-item topbar-user dropdown hidden-caret">
                                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#"
                                    aria-expanded="false">
                                    {{-- <div class="avatar-sm">
                                        <img src="{{ asset('templetes/kaiadmin-lite/assets/img/profile.jpg') }}"
                                            alt="..." class="avatar-img rounded-circle" />
                                    </div> --}}
                                    <span class="profile-username">
                                        <span class="op-7">Hi,</span>
                                        <span class="fw-bold">UPTB Wiyung</span>
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-user animated fadeIn">
                                    <div class="dropdown-user-scroll scrollbar-outer">
                                        <li>
                                            <div class="user-box">
                                                {{-- <div class="avatar-lg">
                                                    <img src="{{ asset('templetes/kaiadmin-lite/assets/img/profile.jpg') }}"
                                                        alt="image profile" class="avatar-img rounded" />
                                                </div>
                                                <div class="u-text">
                                                    <h4>UPTB Wiyung</h4>
                                                    <p class="text-muted">hello@example.com</p>
                                                    <a href="profile.html"
                                                        class="btn btn-xs btn-secondary btn-sm">View
                                                        Profile</a>
                                                </div> --}}
                                            </div>
                                        </li>
                                        <li>
                                            {{-- <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">My Profile</a>
                                            <a class="dropdown-item" href="#">My Balance</a>
                                            <a class="dropdown-item" href="#">Inbox</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Account Setting</a>
                                            <div class="dropdown-divider"></div> --}}

                                            <form action="{{ route('logout') }}" method="POST">
                                                @csrf
                                                <button type="submit" class="dropdown-item">Logout</button>
                                            </form>

                                        </li>
                                    </div>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
                <!-- End Navbar -->
            </div>

            <div class="container">
                <div class="page-inner">
                    {{-- <div
              class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4"
            >
              <div>
                <h3 class="fw-bold mb-3">Dashboard</h3>
                <h6 class="op-7 mb-2">Free Bootstrap 5 Admin Dashboard</h6>
              </div>
              <div class="ms-md-auto py-2 py-md-0">
                <a href="#" class="btn btn-label-info btn-round me-2">Manage</a>
                <a href="#" class="btn btn-primary btn-round">Add Customer</a>
              </div>
            </div> --}}

                    @if (Route::current()->getName() == 'dashboard')
                        @if (auth()->user()->role != 'admin')
                            <div class="card p-3">
                                <h1 class="mb-4">Main Menu</h1>
                                <div class="row justify-content-center g-4">
                                    <div class="col-lg-5 col-md-6">
                                        <a href="{{ route('berita_acara', ['jenis' => 'OP']) }}"
                                            class="text-white text-decoration-none">
                                            <div class="card bg-gradient-primary text-white shadow-lg border-0 rounded-4 h-100">
                                                <div class="card-body text-center py-5">
                                                    <i class="bi bi-file-earmark-text" style="font-size: 3rem;"></i>
                                                    <h3 class="text-white mt-3 fw-bold">Berita Acara PBJT</h3>
                                                    <p class="opacity-75 mb-0">Total: {{ $totalAll ?? 0 }}</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-lg-5 col-md-6">
                                        <a href="{{ route('berita_acara', ['jenis' => 'pbb']) }}"
                                            class="text-white text-decoration-none">
                                            <div class="card bg-gradient-success text-white shadow-lg border-0 rounded-4 h-100">
                                                <div class="card-body text-center py-5">
                                                    <i class="bi bi-building" style="font-size: 3rem;"></i>
                                                    <h3 class="text-white mt-3 fw-bold">Berita Acara PBB</h3>
                                                    <p class="opacity-75 mb-0">Total: {{ $totalAll ?? 0 }}</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @else
                            {{-- STAT CARDS ROW --}}
                            <div class="row g-3 mb-4">
                                <div class="col-xl-3 col-md-6">
                                    <div class="card border-0 shadow-sm rounded-4 h-100" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                        <div class="card-body text-white d-flex align-items-center justify-content-between p-4">
                                            <div>
                                                <h6 class="text-white-50 mb-1">Hari Ini</h6>
                                                <h2 class="text-white fw-bold mb-0">{{ $todayCount }}</h2>
                                                <small class="text-white-50">Berita Acara</small>
                                            </div>
                                            <i class="bi bi-calendar-check" style="font-size: 3rem; opacity: 0.5;"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="card border-0 shadow-sm rounded-4 h-100" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                                        <div class="card-body text-white d-flex align-items-center justify-content-between p-4">
                                            <div>
                                                <h6 class="text-white-50 mb-1">Minggu Ini</h6>
                                                <h2 class="text-white fw-bold mb-0">{{ $thisWeekCount }}</h2>
                                                <small class="text-white-50">Berita Acara</small>
                                            </div>
                                            <i class="bi bi-calendar-week" style="font-size: 3rem; opacity: 0.5;"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="card border-0 shadow-sm rounded-4 h-100" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                                        <div class="card-body text-white d-flex align-items-center justify-content-between p-4">
                                            <div>
                                                <h6 class="text-white-50 mb-1">Bulan Ini</h6>
                                                <h2 class="text-white fw-bold mb-0">{{ $thisMonthCount }}</h2>
                                                <small class="text-white-50">Berita Acara</small>
                                            </div>
                                            <i class="bi bi-calendar-month" style="font-size: 3rem; opacity: 0.5;"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="card border-0 shadow-sm rounded-4 h-100" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                                        <div class="card-body text-white d-flex align-items-center justify-content-between p-4">
                                            <div>
                                                <h6 class="text-white-50 mb-1">Total</h6>
                                                <h2 class="text-white fw-bold mb-0">{{ $totalAll }}</h2>
                                                <small class="text-white-50">Semua Berita Acara</small>
                                            </div>
                                            <i class="bi bi-folder" style="font-size: 3rem; opacity: 0.5;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- MINI STATS ROW-2 --}}
                            <div class="row g-3 mb-4">
                                <div class="col-xl-3 col-md-6">
                                    <div class="card border-0 shadow-sm rounded-4 h-100" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                                        <div class="card-body text-white d-flex align-items-center justify-content-between p-4">
                                            <div>
                                                <h6 class="text-white-50 mb-1">Wajib Pajak</h6>
                                                <h2 class="text-white fw-bold mb-0">{{ $totalWp }}</h2>
                                                <small class="text-white-50">Terdaftar</small>
                                            </div>
                                            <i class="bi bi-people" style="font-size: 3rem; opacity: 0.5;"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="card border-0 shadow-sm rounded-4 h-100" style="background: linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%);">
                                        <div class="card-body text-white d-flex align-items-center justify-content-between p-4">
                                            <div>
                                                <h6 class="text-white-50 mb-1">Petugas</h6>
                                                <h2 class="text-white fw-bold mb-0">{{ $totalPegawai }}</h2>
                                                <small class="text-white-50">Total</small>
                                            </div>
                                            <i class="bi bi-person-badge" style="font-size: 3rem; opacity: 0.5;"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="card border-0 shadow-sm rounded-4 h-100" style="background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);">
                                        <div class="card-body d-flex align-items-center justify-content-between p-4">
                                            <div>
                                                <h6 class="text-muted mb-1">PBB</h6>
                                                <h2 class="fw-bold mb-0">{{ $pbbCount ?? 0 }}</h2>
                                                <small class="text-muted">Tahun {{ date('Y') }}</small>
                                            </div>
                                            <i class="bi bi-house-door" style="font-size: 3rem; opacity: 0.4;"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="card border-0 shadow-sm rounded-4 h-100" style="background: linear-gradient(135deg, #a1c4fd 0%, #c2e9fb 100%);">
                                        <div class="card-body d-flex align-items-center justify-content-between p-4">
                                            <div>
                                                <h6 class="text-muted mb-1">PBJT</h6>
                                                <h2 class="fw-bold mb-0">{{ $pbjtCount ?? 0 }}</h2>
                                                <small class="text-muted">Tahun {{ date('Y') }}</small>
                                            </div>
                                            <i class="bi bi-shop" style="font-size: 3rem; opacity: 0.4;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- CHARTS ROW --}}
                            <div class="row g-4 mb-4">
                                <div class="col-lg-8">
                                    <div class="card border-0 shadow-sm rounded-4">
                                        <div class="card-header bg-white border-0 rounded-top-4 pt-4 pb-0">
                                            <h5 class="fw-bold mb-0"><i class="bi bi-bar-chart-fill me-2 text-primary"></i>Perbandingan PBB & PBJT per Bulan</h5>
                                        </div>
                                        <div class="card-body">
                                            <canvas id="beritaChart" height="280"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="card border-0 shadow-sm rounded-4 h-100">
                                        <div class="card-header bg-white border-0 rounded-top-4 pt-4 pb-0">
                                            <h5 class="fw-bold mb-0"><i class="bi bi-pie-chart-fill me-2 text-info"></i>Distribusi</h5>
                                        </div>
                                        <div class="card-body d-flex align-items-center justify-content-center">
                                            <canvas id="pieChart" height="250"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- TOP PETUGAS CHART --}}
                            <div class="row g-4 mb-4">
                                <div class="col-lg-6">
                                    <div class="card border-0 shadow-sm rounded-4">
                                        <div class="card-header bg-white border-0 rounded-top-4 pt-4 pb-0">
                                            <h5 class="fw-bold mb-0"><i class="bi bi-trophy-fill me-2 text-warning"></i>Top 5 Petugas Teraktif</h5>
                                        </div>
                                        <div class="card-body">
                                            <canvas id="petugasChart" height="220"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="card border-0 shadow-sm rounded-4">
                                        <div class="card-header bg-white border-0 rounded-top-4 pt-4 pb-0">
                                            <h5 class="fw-bold mb-0"><i class="bi bi-table me-2 text-secondary"></i>Ringkasan</h5>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-borderless mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td><i class="bi bi-calendar-check text-primary me-2"></i>Hari Ini</td>
                                                        <td class="text-end fw-bold">{{ $todayCount }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><i class="bi bi-calendar-week text-danger me-2"></i>Minggu Ini</td>
                                                        <td class="text-end fw-bold">{{ $thisWeekCount }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><i class="bi bi-calendar-month text-success me-2"></i>Bulan Ini</td>
                                                        <td class="text-end fw-bold">{{ $thisMonthCount }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><i class="bi bi-folder text-info me-2"></i>Total</td>
                                                        <td class="text-end fw-bold">{{ $totalAll }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><i class="bi bi-house-door text-warning me-2"></i>PBB</td>
                                                        <td class="text-end fw-bold">{{ $pbbCount ?? 0 }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><i class="bi bi-shop text-secondary me-2"></i>PBJT</td>
                                                        <td class="text-end fw-bold">{{ $pbjtCount ?? 0 }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                    @yield('content')
                </div>
            </div>

            <footer class="footer">
                <div class="container-fluid d-flex justify-content-between text-center">
                    <div class="copyright">
                        UPTB Wiyung
                    </div>
                </div>
            </footer>
        </div>

        <!-- End Custom template -->
    </div>
    @if (isset($months) && isset($counts))
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // ===== DATA =====
            const months     = @json($months);
            const pbbMonthly = @json($pbbMonthly ?? []);
            const pbjtMonthly = @json($pbjtMonthly ?? []);
            const pbbCount   = {{ $pbbCount ?? 0 }};
            const pbjtCount  = {{ $pbjtCount ?? 0 }};
            const topPetugas = @json($topPetugas ?? []);

            // ===== 1. GROUPED BAR CHART =====
            const ctx1 = document.getElementById('beritaChart').getContext('2d');
            new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: months,
                    datasets: [
                        {
                            label: 'PBB',
                            data: pbbMonthly,
                            backgroundColor: 'rgba(54, 162, 235, 0.7)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1,
                            borderRadius: 4,
                        },
                        {
                            label: 'PBJT',
                            data: pbjtMonthly,
                            backgroundColor: 'rgba(255, 159, 64, 0.7)',
                            borderColor: 'rgba(255, 159, 64, 1)',
                            borderWidth: 1,
                            borderRadius: 4,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'top' },
                    },
                    scales: {
                        y: { beginAtZero: true, stepSize: 1, grid: { drawBorder: false } },
                        x: { grid: { display: false } }
                    }
                }
            });

            // ===== 2. DOUGHNUT CHART =====
            const ctx2 = document.getElementById('pieChart').getContext('2d');
            new Chart(ctx2, {
                type: 'doughnut',
                data: {
                    labels: ['PBB', 'PBJT'],
                    datasets: [{
                        data: [pbbCount, pbjtCount],
                        backgroundColor: ['rgba(54, 162, 235, 0.8)', 'rgba(255, 159, 64, 0.8)'],
                        borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 159, 64, 1)'],
                        borderWidth: 2,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'bottom' },
                    },
                    cutout: '65%',
                }
            });

            // ===== 3. TOP PETUGAS BAR CHART =====
            const ctx3 = document.getElementById('petugasChart').getContext('2d');
            if (topPetugas.length) {
                const labels = topPetugas.map(p => p.nama_pegawai.length > 15 ? p.nama_pegawai.substring(0, 15) + '...' : p.nama_pegawai);
                const data   = topPetugas.map(p => p.jumlah);
                new Chart(ctx3, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah BA',
                            data: data,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.7)',
                                'rgba(54, 162, 235, 0.7)',
                                'rgba(255, 206, 86, 0.7)',
                                'rgba(75, 192, 192, 0.7)',
                                'rgba(153, 102, 255, 0.7)',
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                            ],
                            borderWidth: 1,
                            borderRadius: 4,
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        plugins: {
                            legend: { display: false },
                        },
                        scales: {
                            x: { beginAtZero: true, stepSize: 1, grid: { drawBorder: false } },
                            y: { grid: { display: false } }
                        }
                    }
                });
            } else {
                document.getElementById('petugasChart').parentElement.innerHTML =
                    '<div class="text-center text-muted py-5"><i class="bi bi-inbox" style="font-size: 2rem;"></i><p class="mt-2">Belum ada data tahun ini</p></div>';
            }
        </script>
    @endif
    <!--   Core JS Files   -->
    <script src="{{ asset('templetes/kaiadmin-lite/assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('templetes/kaiadmin-lite/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('templetes/kaiadmin-lite/assets/js/core/bootstrap.min.js') }}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('templetes/kaiadmin-lite/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}">
    </script>

    <!-- Chart JS -->
    <script src="{{ asset('templetes/kaiadmin-lite/assets/js/plugin/chart.js/chart.min.js') }}"></script>

    <!-- jQuery Sparkline -->
    <script src="{{ asset('templetes/kaiadmin-lite/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}">
    </script>

    <!-- Chart Circle -->
    <script src="{{ asset('templetes/kaiadmin-lite/assets/js/plugin/chart-circle/circles.min.js') }}"></script>

    <!-- Datatables -->
    <script src="{{ asset('templetes/kaiadmin-lite/assets/js/plugin/datatables/datatables.min.js') }}"></script>

    <!-- Bootstrap Notify -->
    <script src="{{ asset('templetes/kaiadmin-lite/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}">
    </script>

    <!-- jQuery Vector Maps -->
    <script src="{{ asset('templetes/kaiadmin-lite/assets/js/plugin/jsvectormap/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('templetes/kaiadmin-lite/assets/js/plugin/jsvectormap/world.js') }}"></script>

    <!-- Sweet Alert -->
    <script src="{{ asset('templetes/kaiadmin-lite/assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

    <!-- Kaiadmin JS -->
    <script src="{{ asset('templetes/kaiadmin-lite/assets/js/kaiadmin.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
    <script>
        $(function() {
            $('#summernote').summernote({
                height: 200,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['table']],
                    ['view', ['codeview']]
                ]
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $("#basic-datatables").DataTable({});

            $("#multi-filter-select").DataTable({
                pageLength: 5,
                initComplete: function() {
                    this.api()
                        .columns()
                        .every(function() {
                            var column = this;
                            var select = $(
                                    '<select class="form-select"><option value=""></option></select>'
                                )
                                .appendTo($(column.footer()).empty())
                                .on("change", function() {
                                    var val = $.fn.dataTable.util.escapeRegex($(this).val());

                                    column
                                        .search(val ? "^" + val + "$" : "", true, false)
                                        .draw();
                                });

                            column
                                .data()
                                .unique()
                                .sort()
                                .each(function(d, j) {
                                    select.append(
                                        '<option value="' + d + '">' + d + "</option>"
                                    );
                                });
                        });
                },
            });

            // Add Row
            $("#add-row").DataTable({
                pageLength: 5,
            });

            var action =
                '<td> <div class="form-button-action"> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

            $("#addRowButton").click(function() {
                $("#add-row")
                    .dataTable()
                    .fnAddData([
                        $("#addName").val(),
                        $("#addPosition").val(),
                        $("#addOffice").val(),
                        action,
                    ]);
                $("#addRowModal").modal("hide");
            });
        });
    </script>
</body>

</html>
