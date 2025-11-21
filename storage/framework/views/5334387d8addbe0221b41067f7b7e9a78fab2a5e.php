<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('front.index.banner', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('front.index.services', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('front.index.about', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <section class="section section-padding-2 bg-reb">
        <div class="container">
            <div class="section-heading heading-left mb--40">
                <span class="subtitle"><?php echo e(__('front.portfolio.portfolio_description')); ?></span>
                <h2 class="title"><?php echo e(__('PortfolioProject')); ?></h2>
            </div>
            <?php echo $__env->make('front.inc.portfolio', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <ul class="shape-group-7 list-unstyled">
            <li class="shape shape-1"><img src="<?php echo e(asset('assets/media/others/circle-2.png')); ?>" alt="circle"></li>
            <li class="shape shape-2"><img src="<?php echo e(asset('assets/media/others/bubble-2.png')); ?>" alt="Line"></li>
            <li class="shape shape-3"><img src="<?php echo e(asset('assets/media/others/bubble-1.png')); ?>" alt="Line"></li>
        </ul>
    </section>


    <?php echo $__env->make('front.index.clients', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('front.index.posts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('front.inc.worck_togather', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\chalang\resources\views/front/index/index.blade.php ENDPATH**/ ?>