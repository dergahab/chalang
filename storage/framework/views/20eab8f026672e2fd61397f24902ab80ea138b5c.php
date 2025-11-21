<section class="section section-padding bg-color-dark">
    <div class="container">
        <div class="section-heading heading-light-left">
            <span class="subtitle"><?php echo e(__('front.clients.subtitle')); ?></span>
            <h2 class="title"><?php echo e(__('front.clients.title')); ?></h2>
            <p><?php echo e(__('front.clients.description')); ?></p>
        </div>
        <div class="row">
            <?php $__currentLoopData = $companies ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-3 col-6" data-sal="slide-up" data-sal-duration="500">
                    <div class="brand-grid active">
                        <img src="<?php echo e($company?->image ?? ''); ?>" alt="<?php echo e($company?->name ?? ''); ?>">
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <ul class="shape-group-2 list-unstyled">
        <li class="shape shape-1"><img src="<?php echo e(asset('assets/media/others/circle-1.png')); ?>" alt="circle"></li>
        <li class="shape shape-2"><img src="<?php echo e(asset('assets/media/others/line-3.png')); ?>" alt="circle"></li>
        <li class="shape shape-3"><img src="<?php echo e(asset('assets/media/others/bubble-3.png')); ?>" alt="circle"></li>
    </ul>
</section>
<?php /**PATH C:\xampp\htdocs\chalang\resources\views/front/index/clients.blade.php ENDPATH**/ ?>