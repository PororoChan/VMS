<div class="main-sidebar" id="sidebar-menu">

    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="<?= base_url('beranda') ?>">Visit Monitoring System</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="<?= base_url('beranda') ?>">VMS</a>
        </div>
        <ul class="sidebar-menu">
            <?php foreach ($sidebar as $sd) { ?>
                <?php if ($menuside->checkMenu($sd['menuid'])->countAllResults() > 0) { ?>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link has-dropdown"><i class="<?= $sd['menuicon'] ?>"></i><span><?= $sd['menuname'] ?></span></a>
                        <ul class="dropdown-menu">
                            <?php foreach ($menuside->checkMenu_sidebar($sd['menuid'])->get()->getResultArray() as $submenu) { ?>
                                <li><a class="nav-link" href="<?= base_url($submenu['menulink']) ?>"><?= $submenu['menuname'] ?></a></li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } else { ?>
                    <li class="nav-item dropdown">
                        <a href="<?= base_url($sd['menulink']) ?>" class="nav-link"><i class="<?= $sd['menuicon'] ?>"></i><span><?= $sd['menuname'] ?></span></a>
                    </li>
                <?php } ?>
            <?php } ?>
        </ul>
        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="<?= base_url('logout') ?>" class="btn btn-success btn-lg btn-block btn-icon-split" style="background-color: #ED9DOB;">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </aside>
</div>