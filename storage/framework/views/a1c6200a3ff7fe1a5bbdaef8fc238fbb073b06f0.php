<?php $__env->startSection('content'); ?>
 <!--=====================================-->
        <!--=       Breadcrumb Area Start       =-->
        <!--=====================================-->
        <div class="breadcrum-area breadcrumb-banner">
            <div class="container">
                <div class="section-heading heading-left" data-sal="slide-right" data-sal-duration="1000" data-sal-delay="300">
                    <h1 class="title h2"><?php echo e(__("ServiceTitle")); ?></h1>
                    <p><?php echo e(__("ServiceDesctioption")); ?></p>
                </div>
                <div class="banner-thumbnail" data-sal="slide-up" data-sal-duration="1000" data-sal-delay="400">
                    <img class="paralax-image" src="assets/media/banner/banner-thumb-4.png" alt="Illustration">
                </div>
            </div>
            <ul class="shape-group-8 list-unstyled">
                <li class="shape shape-1" data-sal="slide-right" data-sal-duration="500" data-sal-delay="100">
                    <img src="assets/media/others/bubble-9.png" alt="Bubble">
                </li>
                <li class="shape shape-2" data-sal="slide-left" data-sal-duration="500" data-sal-delay="200">
                    <img src="assets/media/others/bubble-21.png" alt="Bubble">
                </li>
                <li class="shape shape-3" data-sal="slide-up" data-sal-duration="500" data-sal-delay="300">
                    <img src="assets/media/others/line-4.png" alt="Line">
                </li>
            </ul>
        </div>

        <div class="service-scroll-navigation-area">
            <nav id="onepagenav" class="service-scroll-nav navbar onepagefixed">
                <div class="container">
                    <ul class="nav nav-pills">
                        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="nav-item">
                            <a class="nav-link" href="#<?php echo e($item->name); ?>"><?php echo e($item->name); ?></a>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </nav>
          <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="section section-padding" id="<?php echo e($item->name); ?>">
            <div class="container">
                <div class="section-heading heading-left">
                    <h2 class="title"><?php echo e($item->name); ?></h2>
                </div>
                <div class="row">
                    <?php $__currentLoopData = $item->childs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-4 col-md-6" data-sal="slide-up" data-sal-duration="800" data-sal-delay="100">
                        <div class="services-grid service-style-2">
                            <div class="thumbnail">
                                <img src="<?php echo e(asset(Storage::url( '/public/'.$child->icon))); ?>" alt="icon">
                            </div>
                            <div class="content">
                                <h5 class="title"> <a href="<?php echo e(route('service.single',$child->slug)); ?>"><?php echo e($child->name); ?></a></h5>
                                <p><?php echo e($child->content); ?></p>
                                <a href="<?php echo e(route('service.single',$child->slug)); ?>" class="more-btn">Find out more</a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
           </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
<?php echo $__env->make('front.inc.worck_togather', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\chalang\resources\views/front/services/services.blade.php ENDPATH**/ ?>