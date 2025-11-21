<?php $__env->startSection('content'); ?>
<div class="breadcrum-area breadcrumb-banner">
    <div class="container">
        <div class="section-heading heading-left" data-sal="slide-right" data-sal-duration="1000" data-sal-delay="300">
            <h1 class="title h2"><?php echo e(__('portfolio_title')); ?></h1>
            <p><?php echo e(__("portfolio_subtitle")); ?></p>
        </div>
        <div class="banner-thumbnail" data-sal="slide-up" data-sal-duration="1000" data-sal-delay="400">
            <img class="paralax-image" src="assets/media/banner/banner-thumb-1.png" alt="Illustration">
        </div>
    </div>
    <ul class="shape-group-8 list-unstyled">
        <li class="shape shape-1" data-sal="slide-right" data-sal-duration="500" data-sal-delay="100">
            <img src="assets/media/others/bubble-9.png" alt="Bubble">
        </li>
        <li class="shape shape-2" data-sal="slide-left" data-sal-duration="500" data-sal-delay="200">
            <img src="assets/media/others/bubble-20.png" alt="Bubble">
        </li>
        <li class="shape shape-3" data-sal="slide-up" data-sal-duration="500" data-sal-delay="300">
            <img src="assets/media/others/line-4.png" alt="Line">
        </li>
    </ul>
</div>
<section class="section section-padding-equal project-column-4 pt--200 pt_md--80 pt_sm--60">
    <div class="container">
        <div class="section-heading heading-left">
            <span class="subtitle"><?php echo e(__("Our Work")); ?></span>
            <h2 class="title"><?php echo e(__('Discover the projects we’ve crafted.')); ?></h2>
        </div>
        <?php echo $__env->make('front.inc.portfolio', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <ul class="shape-group-7 list-unstyled">
        <li class="shape shape-1"><img src="assets/media/others/circle-2.png" alt="circle"></li>
        <li class="shape shape-2"><img src="assets/media/others/bubble-2.png" alt="Line"></li>
        <li class="shape shape-3"><img src="assets/media/others/bubble-1.png" alt="Line"></li>
    </ul>
</section>
<?php echo $__env->make('front.inc.worck_togather', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\chalang\resources\views/front/portfolio/portfolio.blade.php ENDPATH**/ ?>