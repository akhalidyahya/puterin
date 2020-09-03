<!-- Brand Logo -->
<a href="index3.html" class="brand-link">
    <img src="{{asset('assets/lte/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Admin Page</span>
</a>

<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="{{asset('assets/lte/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="#" class="d-block">{{Session::get('name')}}</a>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <!-- <li class="nav-item active">
                <a href="{{route('dashboard.index')}}" class="nav-link @if($bigmenu == 'dashboard') active @endif">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        Dashboard
                    </p>
                </a>
            </li> -->
            <li class="nav-item has-treeview @if($bigmenu == 'transaksi') menu-open @endif">
                <a href="#" class="nav-link @if($bigmenu == 'transaksi') active @endif">
                    <i class="nav-icon fas fa-handshake"></i>
                    <p>
                        Transactions
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{route('transaksi.index')}}" class="nav-link @if($sidebar == 'all') active @endif">
                            <i class="far fa-circle nav-icon"></i>
                            <p>All Transactions</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('transaksi.uploaded.bukti.index')}}" class="nav-link @if($sidebar == 'bukti') active @endif">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Uploaded Bukti</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('transaksi.ready.index')}}" class="nav-link @if($sidebar == 'ready') active @endif">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Ready to Process</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('transaksi.done.index')}}" class="nav-link @if($sidebar == 'done') active @endif">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Done</p>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->