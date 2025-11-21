<section class="section section-padding-equal bg-color-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6" data-sal="slide-up" data-sal-duration="800">
                <div class="about-us">
                    <div class="section-heading heading-left mb-0">
                        <span class="subtitle"><?php echo e(__('front.about.subtitle')); ?></span>
                        <h2 class="title mb--40"><?php echo e(__('front.about.title')); ?></h2>
                        <p><?php echo e(__('front.about.description_1')); ?></p>
                        <p><?php echo e(__('front.about.description_2')); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-xl-5 col-lg-6 offset-xl-1" data-sal="slide-up" data-sal-duration="800" data-sal-delay="100">
                <div class="contact-form-box">
                    <h3 class="title"><?php echo e(__('front.about.contact_title')); ?></h3>
                    <?php echo $__env->make('front.inc.form', ['type' => 'main'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div>
    </div>
    <ul class="shape-group-6 list-unstyled">
        <li class="shape shape-1"><img src="<?php echo e(asset('assets/media/others/bubble-7.png')); ?>" alt="Bubble"></li>
        <li class="shape shape-2"><img src="<?php echo e(asset('assets/media/others/line-4.png')); ?>" alt="line"></li>
        <li class="shape shape-3"><img src="<?php echo e(asset('assets/media/others/line-5.png')); ?>" alt="line"></li>
    </ul>
</section>
<?php /**PATH C:\xampp\htdocs\chalang\resources\views/front/index/about.blade.php ENDPATH**/ ?>