<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4 sidebar-dark-teal">
   <!-- Brand Logo -->
   <a href="index3.html" class="brand-link">
      <img src="{{asset('image/logo.png')}}" alt="{{config('app.name')}}" class="brand-image img-circle elevation-3"
         style="opacity: .8">
      <span class="brand-text font-weight-light">Railway Service</span>
   </a>

   <!-- Sidebar -->
   <div class="sidebar">

      <!-- Sidebar Menu -->
      <nav class="mt-2">
         <ul class="nav nav-pills nav-sidebar flex-column nav-legacy" data-widget="treeview" role="menu"
            data-accordion="false">
            <li class="nav-item">
               <a href="{{route('dashboard')}}" class="nav-link">
                  <i class="nav-icon fas fa-th"></i>
                  <p>
                     Dashboard
                  </p>
               </a>
            </li>
            <li class="nav-item">
               <a href="{{route('admin-user.index')}}" class="nav-link @yield('admin-user-page-active')">
                  <i class="nav-icon fas fa-user"></i>
                  <p>
                     Admin User
                  </p>
               </a>
            </li>
            <li class="nav-item">
               <a href="{{route('user.index')}}" class="nav-link @yield('user-page-active')">
                  <i class="nav-icon fas fa-user"></i>
                  <p>
                     User
                  </p>
               </a>
            </li>
            <li class="nav-item">
               <a href="{{route('wallet.index')}}" class="nav-link @yield('wallet-page-active')">
                  <i class="nav-icon fas fa-wallet"></i>
                  <p>
                     Wallet
                  </p>
               </a>
            </li>
            <li class="nav-item">
               <a href="{{route('ticket-inspector.index')}}" class="nav-link @yield('ticket-inspector-page-active')">
                  <i class="nav-icon fas fa-user"></i>
                  <p>
                     Ticket Inspector
                  </p>
               </a>
            </li>
            {{-- <li class="nav-item">
               <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>
                     Layout Options
                     <i class="fas fa-angle-left right"></i>
                     <span class="badge badge-info right">6</span>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="pages/layout/top-nav.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Top Navigation</p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="pages/layout/top-nav-sidebar.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Top Navigation + Sidebar</p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="pages/layout/boxed.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Boxed</p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="pages/layout/fixed-sidebar.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Fixed Sidebar</p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="pages/layout/fixed-sidebar-custom.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Fixed Sidebar <small>+ Custom Area</small></p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="pages/layout/fixed-topnav.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Fixed Navbar</p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="pages/layout/fixed-footer.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Fixed Footer</p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="pages/layout/collapsed-sidebar.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Collapsed Sidebar</p>
                     </a>
                  </li>
               </ul>
            </li> --}}
         </ul>
      </nav>
      <!-- /.sidebar-menu -->
   </div>
   <!-- /.sidebar -->
</aside>