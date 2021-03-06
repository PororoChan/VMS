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
            <li class="dropdown">
            <li>
                <a title="Branch" class="nav-link" href="<?= base_url('branch'); ?>"><i class="fas fa-code-branch"></i><span>Branch</span></a>
            </li>
            <li>
                <a title="Conversions" class="nav-link" href="<?= base_url('convers'); ?>"><i class="fas fa-dollar-sign"></i><span>Conversions</span></a>
            </li>
            <li>
                <a title="Brand" class="nav-link" href="<?= base_url('brand'); ?>"><i class="fas fa-box-open"></i><span>Link Item Brand</span></a>
            </li>
            <li>
                <a title="Security User" class="nav-link" href="<?= base_url('user'); ?>"><i class="fas fa-user-lock"></i><span>Security User</span></a>
            </li>
            <li>
                <a title="User" class="nav-link" href="<?= base_url('msuser'); ?>"><i class="fas fa-user"></i><span>User</span></a>
            </li>
            <li>
                <a title="Usergroup" class="nav-link" href="<?= base_url('usergroup'); ?>"><i class="fas fa-users"></i><span>Usergroup</span></a>
            </li>
        </ul>
        <ul class="sidebar-menu">
            <li class="menu-header">Menu</li>
            <li>
                <a title="Menu" class="nav-link" href="<?= base_url('menu'); ?>"><i class="fas fa-list"></i><span>Menu</span></a>
            </li>
        </ul>
        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="<?= base_url('logout') ?>" class="btn btn-success btn-lg btn-block btn-icon-split" style="background-color: #ED9DOB;">
                <i class="fas fa-sign-out-alt"></i> Log Out
            </a>
        </div>
    </aside>
</div>