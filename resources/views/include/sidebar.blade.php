   <!-- main left menu -->
   <div id="left-sidebar" class="sidebar">
       <button type="button" class="btn-toggle-offcanvas"><i class="fa fa-arrow-left"></i></button>
       <div class="sidebar-scroll">
           <div class="user-account">
               <img src="{{ asset('assets/images/user.png') }}" class="rounded-circle user-photo" alt="User Profile Picture">
               <div class="dropdown">
                   <span>Welcome,</span>
                   @auth
                   <a href="javascript:void(0);" class="dropdown-toggle user-name" data-toggle="dropdown">
                        <strong>
                            {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
                        </strong>
                   </a>
                   <ul class="dropdown-menu dropdown-menu-right account">
                       <li><a href="page-profile2.html"><i class="icon-user"></i>My Profile</a></li>
                       <li><a href="app-inbox.html"><i class="icon-envelope-open"></i>Messages</a></li>
                       <li><a href="javascript:void(0);"><i class="icon-settings"></i>Settings</a></li>
                       <li class="divider"></li>
                       <li><a href="/logout"><i class="fa fa-users"></i> LOG OUT </a></li>
                   </ul>
                   @endauth

                   @guest
                   <a href="/login" class="dropdown-toggle user-name" data-toggle="dropdown"><strong>Login</strong></a>
                   @endguest
               </div>
               <hr>

           </div>
           <!-- Nav tabs -->
           <ul class="nav nav-tabs">
               <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#menu">Menu</a></li>
               <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Chat"><i class="icon-book-open"></i></a></li>
               <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#setting"><i class="icon-settings"></i></a></li>
               <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#question"><i class="icon-question"></i></a></li>
           </ul>

           <!-- Tab panes -->
           <div class="tab-content padding-0">
               <div class="tab-pane active" id="menu">
                @if (env('DEVELOPMENT', false))
                       <nav id="left-sidebar-nav" class="sidebar-nav">
                           <ul id="main-menu" class="metismenu animation-li-delay">
                               @php
                                   $permissions = session('menu');
                               @endphp
                               @foreach ($permissions as $items)
                                   @if (isset($items['menu']))
                                       @php
                                           $list_menu = array_column($items['menu'], 1);
                                       @endphp
                                       <li
                                           class="{{ collect($list_menu)->contains(fn($p) => Request::is($p)) ? 'active' : '' }}">
                                           <a href="/{{ $items['modul'][0][1] }}" class="has-arrow"><i
                                                   class="fa {{ $items['modul'][0][2] }}"></i><span>{{ $items['modul'][0][0] }}</span></a>
                                           <ul>
                                               @foreach ($items['menu'] as $item)
                                                   <li class="{{ Request::is($item[1]) ? 'active' : '' }}"><a
                                                           href="/{{ $item[1] }}">{{ $item[0] }}</a></li>
                                               @endforeach
                                           </ul>
                                       </li>
                                   @else
                                       <li class="{{ Request::is($items['modul'][0][1], '/') ? 'active' : '' }}">
                                           <a href="/{{ $items['modul'][0][1] == '/' ? '' : $items['modul'][0][1] }}">
                                               <i
                                                   class="fa {{ $items['modul'][0][2] }}"></i><span>{{ $items['modul'][0][0] }}</span>
                                           </a>
                                       </li>
                                   @endif
                               @endforeach
                           </ul>
                       </nav>
                @else
                   <nav id="left-sidebar-nav" class="sidebar-nav">
                       <ul id="main-menu" class="metismenu li_animation_delay">
                           <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                               <a href="#" class="has-arrow"><i class="fa fa-area-chart"></i><span>DASHBOARD</span></a>
                               <ul>
                                   <li><a href="/dashboard">Dashboard MUJ</a></li>
                                   <li><a href="/dashboard-list-divisi">List Resiko MUJ</a></li>

                               </ul>
                           </li>
                           <li>
                               <a href="#App" class="has-arrow"><i class="fa fa-th-large"></i><span>RISK REGISTER</span></a>
                               <ul>
                                   <li><a href="/dashboard-divisi">Dashboard Divisi</a></li>
                                   <li><a href="/input-risk">Input Resiko Divisi</a></li>
                               </ul>
                           </li>
                           <li>
                               <a href="#App" class="has-arrow"><i class="fa fa-th-large"></i><span>APPROVAL</span></a>
                               <ul>
                                   <li><a href="/input-approval">Approval Divisi</a></li>
                               </ul>
                           </li>
                           <li>
                               <a href="#App" class="has-arrow"><i class="fa fa-th-large"></i><span>APPROVAL MR</span></a>
                               <ul>
                                   <li><a href="/input-approval-mr">Approval Manrisk</a></li>
                               </ul>
                           </li>

                           <li>
                               <a href="#App" class="has-arrow"><i class="fa fa-gears"></i><span>MASTER</span></a>
                               <ul>

                                   <li class="{{ Request::is('kemungkinan') ? 'active' : '' }}"><a href="/input-kemungkinan">Kemungkinan</a></li>
                                   <li class="{{ Request::is('kategori') ? 'active' : '' }}"><a href="/input-kategori">Kategori</a></li>
                                   <li class="{{ Request::is('dampak') ? 'active' : '' }}"><a href="/input-dampak">Dampak</a></li>
                                   <li class="{{ Request::is('divisi') ? 'active' : '' }}"><a href="/input-bobot">Bobot</a></li>

                               </ul>
                           </li>

                       </ul>
                   </nav>
                @endif
               </div>

               <div class="tab-pane" id="Chat">
                   <form>
                       <div class="input-group m-b-20">
                           <div class="input-group-prepend">
                               <span class="input-group-text"><i class="icon-magnifier"></i></span>
                           </div>
                           <input type="text" class="form-control" placeholder="Search...">
                       </div>
                   </form>

               </div>
               <div class="tab-pane" id="setting">
                   <h6>Choose Skin</h6>
                   <ul class="choose-skin list-unstyled">
                       <li data-theme="purple">
                           <div class="purple"></div>
                       </li>
                       <li data-theme="blue">
                           <div class="blue"></div>
                       </li>
                       <li data-theme="cyan" class="active">
                           <div class="cyan"></div>
                       </li>
                       <li data-theme="green">
                           <div class="green"></div>
                       </li>
                       <li data-theme="orange">
                           <div class="orange"></div>
                       </li>
                       <li data-theme="blush">
                           <div class="blush"></div>
                       </li>
                       <li data-theme="red">
                           <div class="red"></div>
                       </li>
                   </ul>

                   <ul class="list-unstyled font_setting mt-3">
                       <li>
                           <label class="custom-control custom-radio custom-control-inline">
                               <input type="radio" class="custom-control-input" name="font" value="font-nunito" checked="">
                               <span class="custom-control-label">Nunito Google Font</span>
                           </label>
                       </li>
                       <li>
                           <label class="custom-control custom-radio custom-control-inline">
                               <input type="radio" class="custom-control-input" name="font" value="font-ubuntu">
                               <span class="custom-control-label">Ubuntu Font</span>
                           </label>
                       </li>
                       <li>
                           <label class="custom-control custom-radio custom-control-inline">
                               <input type="radio" class="custom-control-input" name="font" value="font-raleway">
                               <span class="custom-control-label">Raleway Google Font</span>
                           </label>
                       </li>
                       <li>
                           <label class="custom-control custom-radio custom-control-inline">
                               <input type="radio" class="custom-control-input" name="font" value="font-IBMplex">
                               <span class="custom-control-label">IBM Plex Google Font</span>
                           </label>
                       </li>
                   </ul>

                   <ul class="list-unstyled mt-3">
                       <li class="d-flex align-items-center mb-2">
                           <label class="toggle-switch theme-switch">
                               <input type="checkbox">
                               <span class="toggle-switch-slider"></span>
                           </label>
                           <span class="ml-3">Enable Dark Mode!</span>
                       </li>
                       <li class="d-flex align-items-center mb-2">
                           <label class="toggle-switch theme-rtl">
                               <input type="checkbox">
                               <span class="toggle-switch-slider"></span>
                           </label>
                           <span class="ml-3">Enable RTL Mode!</span>
                       </li>
                       <li class="d-flex align-items-center mb-2">
                           <label class="toggle-switch theme-high-contrast">
                               <input type="checkbox">
                               <span class="toggle-switch-slider"></span>
                           </label>
                           <span class="ml-3">Enable High Contrast Mode!</span>
                       </li>
                   </ul>
               </div>

               <div class="tab-pane" id="question">
                   <form>
                       <div class="input-group">
                           <div class="input-group-prepend">
                               <span class="input-group-text"><i class="icon-magnifier"></i></span>
                           </div>
                           <input type="text" class="form-control" placeholder="Search...">
                       </div>
                   </form>

               </div>
           </div>
       </div>
   </div>