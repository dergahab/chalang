<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="<?php echo e(route('/')); ?>" class="logo logo-dark">
            <img src="<?php echo e(asset('admin/assets/images/logo-dark.png')); ?>" alt="" height="22">
            <span class="logo-sm">
                <img src="<?php echo e(asset('admin/assets/images/logo-dark.png')); ?>" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="<?php echo e(asset('admin/assets/images/logo-white.png')); ?>" alt="" height="17">
            </span>
        </a>

        <!-- Light Logo-->
        <a href="/" class="logo logo-light">
            <span class="logo-sm">
                <img src="<?php echo e(asset('admin/assets/images/logo-sm.png')); ?>" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="<?php echo e(asset('admin/assets/images/logo-white.png')); ?>" alt="" height="17">
            </span>
        </a>

        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu"></div>
            <ul class="navbar-nav" id="navbar-nav">

                <?php $__currentLoopData = $sidebarItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <?php if(!$item->get('route') && $item->get('inner') === null): ?>
                        <li class="menu-title">
                            <span data-key="t-menu"><?php echo e($item->get('title')); ?></span>
                        </li>

                    <?php elseif($item->get('route') && !is_array($item->get('inner'))): ?>
                        <li class="nav-item">
                            <a class="nav-link menu-link"
                                href="<?php echo e(route($item->get('route'), $item->get('params') ?? [])); ?>"
                                aria-expanded="false"
                                aria-controls="sidebarDashboards<?php echo e($loop->iteration); ?>">
                                <?php echo $item->get('icon'); ?>

                                <span><?php echo e($item->get('title')); ?></span>
                            </a>
                        </li>

                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link menu-link <?php if($item->get('is_active_route')): ?> active <?php endif; ?>"
                                href="#sidebarDashboards<?php echo e($loop->iteration); ?>" data-bs-toggle="collapse"
                                role="button" aria-expanded="false"
                                aria-controls="sidebarDashboards<?php echo e($loop->iteration); ?>">
                                <?php echo $item->get('icon'); ?>

                                <span data-key="t-dashboards"><?php echo e($item->get('title')); ?></span>
                            </a>
                            <div class="collapse menu-dropdown"
                                id="sidebarDashboards<?php echo e($loop->iteration); ?>">
                                <ul class="nav nav-sm flex-column">
                                    <?php $__currentLoopData = $item->get('inner'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="nav-item">
                                            <a href="<?php echo e(route($inner->get('route'), $inner->get('params') ?? [])); ?>"
                                                class="nav-link <?php if($item->get('is_active_route')): ?> active <?php endif; ?>"
                                                data-key="t-analytics">
                                                <?php echo $inner->get('icon'); ?>

                                                <span><?php echo e($inner->get('title')); ?></span>
                                            </a>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        </li>
                    <?php endif; ?>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </ul>
        </div>
    </div>

    <div class="sidebar-background"></div>
</div>
<?php /**PATH C:\xampp\htdocs\chalang\resources\views/admin/inc/left_sidebar.blade.php ENDPATH**/ ?>