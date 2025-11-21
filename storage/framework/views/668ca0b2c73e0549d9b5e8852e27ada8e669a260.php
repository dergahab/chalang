<?php $__env->startSection('content'); ?>
    <!--=====================================-->
    <!--=       Breadcrumb Area Start       =-->
    <!--=====================================-->
    <div class="breadcrum-area">
        <div class="container">
            <div class="breadcrumb">
                <ul class="list-unstyled">
                    <li><a href="<?php echo e(route('/')); ?>">Əsas Səhifə</a></li>
                    <li class="active">Bloq</li>
                </ul>
                <h1 class="title h2">Bloq</h1>
            </div>
        </div>
        <ul class="shape-group-8 list-unstyled">
            <li class="shape shape-1" data-sal="slide-right" data-sal-duration="500" data-sal-delay="100"><img
                    src="assets/media/others/bubble-9.png" alt="Bubble"></li>
            <li class="shape shape-2" data-sal="slide-left" data-sal-duration="500" data-sal-delay="200"><img
                    src="assets/media/others/bubble-10.png" alt="Bubble"></li>
            <li class="shape shape-3" data-sal="slide-up" data-sal-duration="500" data-sal-delay="300"><img
                    src="assets/media/others/line-4.png" alt="Line"></li>
        </ul>
    </div>
    <!--=====================================-->
    <!--=        Blog Area Start       	    =-->
    <!--=====================================-->
    <section class="section-padding-equal">
        <div class="container">
            <div class="row row-40">
                <div class="col-lg-8">
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="blog-grid">
                            <h3 class="title"><a href="single-blog.html"><?php echo e($blog->title); ?></a></h3>
                            
                            <div class="post-thumbnail">
                                <a href="<?php echo e(route('blog', $blog->slug)); ?>"><img
                                        src="<?php echo e(asset(Storage::url($blog->big_image))); ?>" alt="Blog"></a>
                            </div>
                            <p><?php echo Illuminate\Support\Str::limit($blog->content, 200); ?></p>
                            <a href="<?php echo e(route('blog', $blog->slug)); ?>" class="axil-btn btn-borderd btn-large">Read
                                Ətraflı</a>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <div class="pagination">
                        <ul>
                            <?php if($data->onFirstPage()): ?>
                                <li><span class="prev page-numbers disabled"><i class="fal fa-arrow-left"></i></span></li>
                            <?php else: ?>
                                <li><a class="prev page-numbers" href="<?php echo e($data->previousPageUrl()); ?>"><i
                                            class="fal fa-arrow-left"></i></a></li>
                            <?php endif; ?>

                            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><a href="#"
                                        class="page-numbers <?php echo e($data->currentPage() === $loop->iteration ? 'current' : ''); ?>"><?php echo e($loop->iteration); ?></a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <?php if($data->hasMorePages()): ?>
                                <li><a class="next page-numbers" href="<?php echo e($data->nextPageUrl()); ?>"><i
                                            class="fal fa-arrow-right"></i></a></li>
                            <?php else: ?>
                                <li><span class="next page-numbers disabled"><i class="fal fa-arrow-right"></i></span></li>
                            <?php endif; ?>
                        </ul>
                    </div>


                </div>
                <div class="col-lg-4">
                    <div class="axil-sidebar">
                        <div class="widget widget-search">
                            <h4 class="widget-title">Axtarış</h4>
                            <form action="#" class="blog-search">
                                <input type="text" placeholder="Axtarış...">
                                <button class="search-button"><i class="fal fa-search"></i></button>
                            </form>
                        </div>
                        <?php echo $__env->make('front.blogs.category', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php echo $__env->make('front.blogs.follow', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php echo $__env->make('front.blogs.resently', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <div class="widget widget-banner-ad">
                            <a href="#">
                                <img src="<?php echo e(asset('assets/media/banner/widget-banner.png')); ?>" alt="banner">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php echo $__env->make('front.inc.worck_togather', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\chalang\resources\views/front/blogs/blog.blade.php ENDPATH**/ ?>