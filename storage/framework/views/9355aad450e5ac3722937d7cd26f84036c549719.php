<div class="widget widget-categories">
    <h4 class="widget-title">Kateqoriya</h4>
    <ul class="category-list list-unstyled">
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><a href="blog-category.html"><?php echo e($category->name); ?></a></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</div>
<?php /**PATH C:\xampp\htdocs\chalang\resources\views/front/blogs/category.blade.php ENDPATH**/ ?>