<section class="banner banner-style-4">
    <div class="container">
        <div class="banner-content">
            <h1 class="title" data-sal="slide-up" data-sal-duration="1000" data-sal-delay="100"><?php echo e($banner?->title ?? ''); ?></h1>
            <p data-sal="slide-up" data-sal-duration="1000"><?php echo $banner?->content ?? ''; ?></p>
            <div data-sal="slide-up" data-sal-duration="1000" data-sal-delay="200">
                <?php if($banner?->url): ?>
                      <a href="<?php echo e($banner?->url); ?>" class="axil-btn btn-fill-primary btn-large"><?php echo e(__('Contact')); ?></a>
                <?php endif; ?>
            </div>
        </div>
        <div class="banner-thumbnail">
            <div class="large-thumb" data-sal="slide-left" data-sal-duration="800" data-sal-delay="400">
                <?php if($banner?->image): ?>
                    <img class="paralax-image" src="<?php echo e(asset(Storage::url('/public/'.$banner->image))); ?> " alt="Shape">
                <?php endif; ?>            </div>
        </div>
        <div class="banner-social" data-sal="slide-up" data-sal-duration="800">
            <div class="border-line"></div>
            <ul class="list-unstyled social-icon">
                <?php $__currentLoopData = $socialmedia ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $media): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><a href="<?php echo e($media?->link ?? '#'); ?>"><i class="<?php echo e($media?->icon ?? ''); ?>"></i> <?php echo e($media?->name ?? ''); ?></a></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>

    <ul class="list-unstyled shape-group-19">
        <li class="shape shape-1" data-sal="slide-down" data-sal-duration="500" data-sal-delay="100">
            <img src="assets/media/others/bubble-29.png" alt="Bubble">
        </li>
        <li class="shape shape-2" data-sal="slide-left" data-sal-duration="500" data-sal-delay="200">
            <img src="assets/media/others/line-7.png" alt="Bubble">
        </li>
    </ul>
</section>
<?php /**PATH C:\xampp\htdocs\chalang\resources\views/front/index/banner.blade.php ENDPATH**/ ?>