<section class="section section-padding related-blog-area">
    <div class="container">
        <div class="section-heading heading-left">
            <h3 class="title"><?php echo e(__('front.blog.title')); ?></h3>
        </div>
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <?php $__currentLoopData = $blogs ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="swiper-slide">
                        <div class="blog-list blog-bg">
                            <div class="post-thumbnail">
                                <a href="<?php echo e(route('blog', $blog?->slug ?? '')); ?>" tabindex="-1">
                                    <img src="<?php echo e($blog?->image ? asset(Storage::url($blog->image)) : ''); ?>" alt="<?php echo e($blog?->title ?? ''); ?>">
                                </a>
                            </div>
                            <div class="post-content">
                                <h5 class="title">
                                    <a href="<?php echo e(route('blog', $blog?->slug ?? '')); ?>" tabindex="-1"><?php echo e($blog?->title ?? ''); ?></a>
                                </h5>
                                <?php echo Illuminate\Support\Str::limit($blog?->content ?? '', $limit = 100, $end = '...'); ?>

                                <a href="<?php echo e(route('blog', $blog?->slug ?? '')); ?>" class="more-btn" tabindex="-1">
                                    <?php echo e(__('front.blog.read_more')); ?><i class="far fa-angle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>
<?php /**PATH C:\xampp\htdocs\chalang\resources\views/front/index/posts.blade.php ENDPATH**/ ?>