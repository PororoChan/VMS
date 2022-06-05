<div class="main-sidebar" id="sidebar-menu">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="#">Visit Monitoring System</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="#">VMS</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Master</li>
            <li class="nav-item">
                <a title="User" class="nav-link" href="<?= base_url('user'); ?>"><i class="fas fa-user"></i><span>User</span></a>
            </li>
            <li class="nav-item">
                <a title="Usergroup" class="nav-link" href="<?= base_url('usergroup'); ?>"><i class="fas fa-users"></i><span>Usergroup</span></a>
            </li>
            <li class="nav-item">
                <a title="Branch" class="nav-link" href="<?= base_url('branch'); ?>"><i class="fas fa-code-branch"></i><span>Branch</span></a>
            </li>
            <li class="nav-item">
                <a title="Brand" class="nav-link" href="<?= base_url('brand'); ?>"><i class="fas fa-box"></i><span>Brand</span></a>
            </li>
        </ul>
        <ul class="sidebar-menu">
            <li class="menu-header">Menu</li>
            <li class="nav-item">
                <a title="Menu" class="nav-link" href="<?= base_url('menu'); ?>"><i class="fas fa-list"></i><span>Menu</span></a>
            </li>
        </ul>
        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="<?= base_url('logout') ?>" class="btn btn-success btn-lg btn-block btn-icon-split" style="background-color: #ED9DOB;">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </aside>
</div>