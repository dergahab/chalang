<?php $__env->startSection('heading_title', 'Xidmətlər'); ?>

<?php $__env->startSection('heading_buttons'); ?>
        <a href="<?php echo e(route('admin.service.create')); ?>" class="btn btn-primary dropdown-toggle arrow-none waves-effect waves-light">
            <i class="fas fa-layer-group mr-2"></i> Əlavə et
        </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">Xidmətlər List</h4>
                    
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Ad</th>
                                <?php if(!Request::get('parent')): ?>
                                    <th>Alt xidmət</th>
                                <?php endif; ?>
                                <th>Əsas Səhifədə</th>
                                <th>Əməliyyat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e($item->name); ?></td>
                                    <?php if(!Request::get('parent')): ?>
                                        <td>
                                            <a class="btn btn-sm btn-info" href="?parent=<?php echo e($item->id); ?>">
                                                Alt servis (<?php echo e($item->childs()->count()); ?>)
                                            </a>
                                        </td>
                                    <?php endif; ?>
                                    <td>
                                        <?php if($item->in_main): ?>
                                            <i class="fas fa-check text-success"></i>
                                        <?php else: ?>
                                            <i class="fas fa-times text-danger"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo $__env->make('admin.pages.service.table_actions', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="text-center">Xidmət yoxdu</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
            </div>
        </div>
        <!-- end col -->
    </div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\chalang\resources\views/admin/pages/service/index.blade.php ENDPATH**/ ?>