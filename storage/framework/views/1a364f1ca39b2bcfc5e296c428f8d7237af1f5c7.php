<div class="widget widge-social-share">
    <div class="blog-share">
        <h5 class="title"><?php echo e(__('front.follow')); ?></h5>
        <ul class="social-list list-unstyled">
            <?php $__currentLoopData = $socialmedia; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                    <a href="<?php echo e($item->url); ?>" target="_blank">
                        <i class="<?php echo e($item->icon); ?>"></i>
                    </a>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\chalang\resources\views/front/blogs/follow.blade.php ENDPATH**/ ?>