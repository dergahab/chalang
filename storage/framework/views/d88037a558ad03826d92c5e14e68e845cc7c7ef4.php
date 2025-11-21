<section class="section section-padding-equal bg-color-dark">
    <div class="container">
        <div class="section-heading heading-light-left">
            <span class="subtitle"><?php echo e(__('front.services.subtitle')); ?></span>
            <h2 class="title"><?php echo e(__('front.services.title')); ?></h2>
            <p class="opacity-50"><?php echo e(__('front.services.description')); ?></p>
        </div>
        <div class="row">
            <?php $__currentLoopData = $main_services ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-4 col-md-6 sal-animate" data-sal="slide-up" data-sal-duration="800"
                    data-sal-delay="100">
                    <div class="services-grid">
                        <div class="thumbnail">
                            
                            <?php if($service?->icon ): ?>
                            <img src="<?php echo e(asset(Storage::url('/public/'.$service->icon))); ?>" alt="icon" width="300" height="300">
                            <?php endif; ?>
                        </div>
                        <div class="content">
                            <h5 class="title"> <a
                                    href="<?php echo e(route('services')); ?>#<?php echo e($service?->name ?? ''); ?>"><?php echo e($service?->name ?? ''); ?></a></h5>
                         <p><?php echo e(\Illuminate\Support\Str::limit($service?->description ?? '', 152, '...')); ?></p>
                            
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <ul class="list-unstyled shape-group-10">
        <li class="shape shape-1"><img src="<?php echo e(asset('assets/media/others/circle-1.png')); ?>" alt="Circle"></li>
        <li class="shape shape-2"><img src="<?php echo e(asset('assets/media/others/line-3.png')); ?>" alt="Circle"></li>
        <li class="shape shape-3"><img src="<?php echo e(asset('assets/media/others/bubble-5.png')); ?>" alt="Circle"></li>
    </ul>
</section>
<?php /**PATH C:\xampp\htdocs\chalang\resources\views/front/index/services.blade.php ENDPATH**/ ?>