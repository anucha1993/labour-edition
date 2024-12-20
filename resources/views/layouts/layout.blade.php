<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>DataTables | Gentelella</title>

    <!-- Bootstrap -->
    <link href="cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link href="{{ URL::asset('vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awme -->
    <link href="{{ URL::asset('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ URL::asset('vendors/nprogress/nprogress.css') }}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{ URL::asset('vendors/iCheck/skins/flat/green.css') }}" rel="stylesheet">
    <!-- Datatables -->
    <link href="{{ URL::asset('vendors/switchery/dist/switchery.min.css') }}" rel="stylesheet">

    <link href="{{ URL::asset('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}"
        rel="stylesheet">
    <link href="{{ URL::asset('vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}"
        rel="stylesheet">
    <link href="{{ URL::asset('vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Custom Theme Style -->
    <link href="{{ URL::asset('build/css/custom.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css" />

    <script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .select2 {
            font-size: 16px;

        }
    </style>



</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="{{ route('labour.index') }}" class="site_title">
                            <span>TheFirst Labours</span></a>
                    </div>

                    <div class="clearfix"></div>

                    <!-- menu profile quick info -->
                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <img src="{{ URL::asset('images/logo-tfg.png') }}" class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                            <h2>{{ Auth::user()->name }}</h2>
                        </div>
                    </div>
                    <!-- /menu profile quick info -->

                    <br />

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <h3>General</h3>



                            <ul class="nav side-menu">

                                <li><a href="{{ route('/') }}"><i
                                            class="fa fa-bell text-danger"></i>เตือนเอกสารหมดอายุ </i></a>

                                </li>

                                <li><a><i class="fa fa-university"></i> ข้อมูลนายจ้าง <span
                                            class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="{{ route('customer.index') }}">ข้อมูลนายจ้าง</a></li>
                                        {{-- <li><a href="tables_dynamic.html">Table Dynamic</a></li> --}}
                                    </ul>
                                </li>

                                <li><a><i class="fa fa-table"></i> ข้อมูลคนต่างด้าว <span
                                            class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="{{ route('labour.index') }}">ข้อมูลคนต่างด้าว</a></li>
                                        {{-- <li><a href="tables_dynamic.html">Table Dynamic</a></li> --}}
                                    </ul>
                                </li>
                                
                                <li><a><i class="fa fa-group"></i>กลุ่มนำเข้าแรงงานต่างด้าว<span
                                            class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="{{ route('importgroup.index') }}">กลุ่มนำเข้า</a></li>
                                    </ul>
                                </li>

                                <li><a><i class="fa fa-bar-chart-o"></i>รายงาน<span
                                            class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="{{ route('report.reportAll') }}">รายงานข้อมูลคนต่างด้าวทั้งหมด</a>
                                        <li><a href="{{ route('report.cpf') }}">รายงานข้อมูลคนต่างด้าว CPF </a>
                                        <li><a href="{{ route('report.customer') }}">รายงานข้อมูลนายจ้าง </a>
                                        <li><a href="{{ route('expire.index') }}">คำนวนข้อมูลล่วงหน้า </a>
                                        <li><a href="{{ route('report.total.index') }}">รายงานข้อมูลจำนวนแรงงานแยกบริษัท </a>
                                        </li>
                                    </ul>
                                </li>
                                @if (Auth::user()->type != 3) 
                                <li><a><i class="fa fa-file-excel-o"></i>นำเข้าข้อมูล<span
                                            class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="{{ route('customFormImport.index') }}">นำเข้าข้อมูลแบบกำหนดเอง</a></li>
                                        <li><a href="{{ route('excelImport.labour') }}">นำเข้าข้อมูลคนต่างด้าว</a></li>
                                        <li><a href="{{ route('department.employee.id') }}">นำเข้าข้อมูล แผนก &
                                                รหัสพนักงาน</a></li>
                                        <li><a href="{{ route('import.update90day') }}">นำเข้าข้อมูล 90 วัน</a></li>
                                        <li><a href="{{ route('addressLabour.index') }}">นำเข้าข้อมูล ที่อยู่แรงงาน</a>
                                        </li>
                                    </ul>
                                </li>
                                @endif
                                {{-- @if (Auth::user()->type == '1') --}}
                                    <li><a><i class="fa fa-file-text-o"></i>LogFile<span
                                                class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a href="{{ route('logfile.labour') }}">LabourLog</a></li>

                                        </ul>
                                    </li>
                                {{-- @endif --}}



                                {{-- <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="index.html">Dashboard</a></li>
                      <li><a href="index2.html">Dashboard2</a></li>
                      <li><a href="index3.html">Dashboard3</a></li>
                    </ul>
                  </li>
                  
                  <li><a><i class="fa fa-edit"></i> Forms <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="form.html">General Form</a></li>
                      <li><a href="form_advanced.html">Advanced Components</a></li>
                      <li><a href="form_validation.html">Form Validation</a></li>
                      <li><a href="form_wizards.html">Form Wizard</a></li>
                      <li><a href="form_upload.html">Form Upload</a></li>
                      <li><a href="form_buttons.html">Form Buttons</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-desktop"></i> UI Elements <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="general_elements.html">General Elements</a></li>
                      <li><a href="media_gallery.html">Media Gallery</a></li>
                      <li><a href="typography.html">Typography</a></li>
                      <li><a href="icons.html">Icons</a></li>
                      <li><a href="glyphicons.html">Glyphicons</a></li>
                      <li><a href="widgets.html">Widgets</a></li>
                      <li><a href="invoice.html">Invoice</a></li>
                      <li><a href="inbox.html">Inbox</a></li>
                      <li><a href="calendar.html">Calendar</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-table"></i> Tables <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="tables.html">Tables</a></li>
                      <li><a href="tables_dynamic.html">Table Dynamic</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-bar-chart-o"></i> Data Presentation <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="chartjs.html">Chart JS</a></li>
                      <li><a href="chartjs2.html">Chart JS2</a></li>
                      <li><a href="morisjs.html">Moris JS</a></li>
                      <li><a href="echarts.html">ECharts</a></li>
                      <li><a href="other_charts.html">Other Charts</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-clone"></i>Layouts <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="fixed_sidebar.html">Fixed Sidebar</a></li>
                      <li><a href="fixed_footer.html">Fixed Footer</a></li>
                    </ul>
                  </li>
                </ul>
              </div>
              <div class="menu_section">
                <h3>Live On</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-bug"></i> Additional Pages <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="e_commerce.html">E-commerce</a></li>
                      <li><a href="projects.html">Projects</a></li>
                      <li><a href="project_detail.html">Project Detail</a></li>
                      <li><a href="contacts.html">Contacts</a></li>
                      <li><a href="profile.html">Profile</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-windows"></i> Extras <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="page_403.html">403 Error</a></li>
                      <li><a href="page_404.html">404 Error</a></li>
                      <li><a href="page_500.html">500 Error</a></li>
                      <li><a href="plain_page.html">Plain Page</a></li>
                      <li><a href="login.html">Login Page</a></li>
                      <li><a href="pricing_tables.html">Pricing Tables</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-sitemap"></i> Multilevel Menu <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="#level1_1">Level One</a>
                        <li><a>Level One<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li class="sub_menu"><a href="level2.html">Level Two</a>
                            </li>
                            <li><a href="#level2_1">Level Two</a>
                            </li>
                            <li><a href="#level2_2">Level Two</a>
                            </li>
                          </ul>
                        </li>
                        <li><a href="#level1_2">Level One</a>
                        </li>
                    </ul>
                  </li>                  
                  <li><a href="javascript:void(0)"><i class="fa fa-laptop"></i> Landing Page <span class="label label-success pull-right">Coming Soon</span></a></li> --}}
                            </ul>
                        </div>

                    </div>
                    <!-- /sidebar menu -->

                    <!-- /menu footer buttons -->
                    <div class="sidebar-footer hidden-small">
                        <a data-toggle="tooltip" data-placement="top" title="Settings">
                            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                            <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Lock">
                            <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                        </a>
                    </div>
                    <!-- /menu footer buttons -->
                </div>
            </div>

            <!-- top navigation -->
            <div class="top_nav">
                <div class="nav_menu">
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>
                    <nav class="nav navbar-nav">
                        <ul class=" navbar-right">
                            <li class="nav-item dropdown open" style="padding-left: 15px;">
                                <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true"
                                    id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ URL::asset('images/logo-tfg.png') }}" alt="">
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-usermenu pull-right"
                                    aria-labelledby="navbarDropdown">
                                    {{-- <a class="dropdown-item"  href="javascript:;"> Profile</a>
                        <a class="dropdown-item"  href="javascript:;">
                          <span class="badge bg-red pull-right">50%</span>
                          <span>Settings</span>
                        </a>
                    <a class="dropdown-item"  href="javascript:;">Help</a>  --}}
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit(); localStorage.removeItem('hasAlerted');"><i
                                            class="fa fa-sign-out pull-right"></i> Log Out</a>

                                    {{-- <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="fa fa-sign-out pull-right"></i>
                                        {{ __('Logout') }}
                                    </a> --}}

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>

                            <li role="presentation" class="nav-item dropdown open">
                                <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1"
                                    data-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-envelope-o"></i>
                                    <span class="badge bg-green">6</span>
                                </a>
                                <ul class="dropdown-menu list-unstyled msg_list" role="menu"
                                    aria-labelledby="navbarDropdown1">
                                    <li class="nav-item">
                                        <a class="dropdown-item">
                                            <span class="image"><img src="{{ URL::asset('images/logo-tfg.png') }}"
                                                    alt="Profile Image" /></span>
                                            <span>
                                                <span>John Smith</span>
                                                <span class="time">3 mins ago</span>
                                            </span>
                                            <span class="message">
                                                Film festivals used to be do-or-die moments for movie makers. They were
                                                where...
                                            </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="dropdown-item">
                                            <span class="image"><img src="{{ URL::asset('images/logo-tfg.png') }}"
                                                    alt="Profile Image" /></span>
                                            <span>
                                                <span>John Smith</span>
                                                <span class="time">3 mins ago</span>
                                            </span>
                                            <span class="message">
                                                Film festivals used to be do-or-die moments for movie makers. They were
                                                where...
                                            </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="dropdown-item">
                                            <span class="image"><img src="{{ URL::asset('images/img.jpg') }}"
                                                    alt="Profile Image" /></span>
                                            <span>
                                                <span>John Smith</span>
                                                <span class="time">3 mins ago</span>
                                            </span>
                                            <span class="message">
                                                Film festivals used to be do-or-die moments for movie makers. They were
                                                where...
                                            </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="dropdown-item">
                                            <span class="image"><img src="{{ URL::asset('images/img.jpg') }}"
                                                    alt="Profile Image" /></span>
                                            <span>
                                                <span>John Smith</span>
                                                <span class="time">3 mins ago</span>
                                            </span>
                                            <span class="message">
                                                Film festivals used to be do-or-die moments for movie makers. They were
                                                where...
                                            </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <div class="text-center">
                                            <a class="dropdown-item">
                                                <strong>See All Alerts</strong>
                                                <i class="fa fa-angle-right"></i>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- /top navigation -->

            <!-- page content -->
            <div class="right_col" role="main">
                <div class="">
                    <div class="page-title">
                        <div class="title_left">
                            {{-- <h3>โปรแกรม <small>บันทึกข้อมูลคนงานต่างด้าว</small></h3> --}}
                        </div>
                        {{-- 
              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-secondary" type="button">Go!</button>
                    </span>
                  </div>
                </div>
              </div> --}}
                    </div>

                    <div class="clearfix"></div>

                    {{-- <div class="row">
              <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Default Example <small>Users</small></h2>
        
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                      <div class="row">
                          <div class="col-sm-12">
                            <div class="card-box table-responsive">
                    <p class="text-muted font-13 m-b-30">
                      DataTables has most features enabled by default, so all you need to do to use it with your own tables is to call the construction function: <code>$().DataTable();</code>
                    </p>
                   
					
					
                  </div>
                </div>
              </div>
            </div>
                </div>
              </div>
            </div> --}}

                    @yield('content')


                </div>
            </div>
            <!-- /page content -->

            <!-- footer content -->
            <footer>
                <div class="pull-right">
                    Foreign Worker Employment Agency The First Good Man Group Company Limited <a
                        href="https://colorlib.com">Mr.Anucha Yothanan</a>
                </div>
                <div class="clearfix"></div>
            </footer>
            <!-- /footer content -->
        </div>
    </div>

    <!-- jQuery -->

    {{-- <script src="{{URL::asset('vendors/jquery/dist/jquery.min.js')}}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Bootstrap -->
    <script src="{{ URL::asset('vendors/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ URL::asset('vendors/fastclick/lib/fastclick.js') }}"></script>
    <!-- NProgress -->
    <script src="{{ URL::asset('vendors/nprogress/nprogress.js') }}"></script>
    <!-- iCheck -->
    <script src="{{ URL::asset('vendors/iCheck/icheck.min.js') }}"></script>
    <!-- Datatables -->
    <script src="{{ URL::asset('vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js') }}"></script>
    <script src="{{ URL::asset('vendors/datatables.net-scroller/js/dataTables.scroller.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/jszip/dist/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('vendors/dropzone/dist/min/dropzone.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/nprogress/nprogress.js') }}"></script>
    <script src="{{ URL::asset('vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/switchery/dist/switchery.min.js') }}"></script>

    <!-- Custom Theme Scripts -->
    <script src="{{ URL::asset('build/js/custom.min.js') }}"></script>

    {{-- <script>
        // เริ่มตรวจสอบ session timeout ทุกๆ 1 นาที
        var sessionCheckInterval = setInterval(function() {
            // ตรวจสอบเงื่อนไข session timeout จากค่าที่คุณตั้งใน Laravel
            if ( /* เงื่อนไข session timeout */ ) {
                clearInterval(sessionCheckInterval); // หยุดการตรวจสอบเมื่อ session timeout
                window.location.href = '/login'; // เด้งไปหน้า login
            }
        }, 60000); // 1 นาที = 60000 มิลลิวินาที
    </script> --}}

    <script>
      $(document).ready(function() {
    // ตรวจสอบว่าแจ้งเตือนได้ถูกแสดงไปแล้วหรือไม่
    var hasAlerted = localStorage.getItem('hasAlerted');
    if (!hasAlerted) {
        $.ajax({
            url: "{{ route('dashboard.alertNotifyAction') }}",
            type: "GET",
            success: function(response) {
                // ดึงข้อมูลจาก response
                var TotalExpirePassport = response.TotalExpirePassport.toLocaleString(); 
            var TotalExpireVisa = response.TotalExpireVisa.toLocaleString();
            var TotalExpireWork = response.TotalExpireWork.toLocaleString();
            var TotalExpire90day = response.TotalExpire90day.toLocaleString();
                // แสดงแจ้งเตือน Swal.fire โดยใช้ข้อมูลที่ดึงมา
                Swal.fire({
                    title: "เอกสารหมดอายุ",
                    html: "<span class='text-left text-danger'>พาสปอร์ตหมดอายุ :</span><br>" + TotalExpirePassport + " คน <br>"+
                          "<span class='text-left text-danger'>วีซ่าหมดอายุ :</span><br>" + TotalExpireVisa + " คน <br>"+
                          "<span class='text-left text-danger'>ใบอนุญาตทำงานหมดอายุ :</span><br>" + TotalExpireWork + " คน <br>"+
                          "<span class='text-left text-danger'>90วันหมดอายุ :</span><br>" + TotalExpire90day + " คน <br>",

                    icon: "warning",
                    confirmButtonText: "รับทราบข้อมูล"
                });

                // บันทึกสถานะการแจ้งเตือนไว้ใน localStorage เพื่อไม่ให้แสดงซ้ำ
                localStorage.setItem('hasAlerted', true);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
});


    </script>
    
</body>

</html>
