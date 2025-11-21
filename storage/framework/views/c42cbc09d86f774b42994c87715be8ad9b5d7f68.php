<div class="axil-isotope-wrapper">
    <div class="isotope-button isotope-project-btn">
        <button data-filter="all" class="is-checked filter-button"><span class="filter-text"><?php echo e(__("All")); ?></span></button>

        <?php $__currentLoopData = $portfolio_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <button data-filter="<?php echo e(Str::slug($pcategory->name, '')); ?>" class="filter-button"><span
                    class="filter-text"><?php echo e($pcategory->name); ?></span></button>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <div class="row isotope-list">
        <?php $__currentLoopData = $portfolios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $portfolio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div
                class="col-xl-3 col-lg-4 col-md-6 filter <?php $__currentLoopData = $portfolio->pcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subtitle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e(Str::slug($subtitle->name, '')); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>">
                <div class="project-grid">
                    <div class="thumbnail">
                        <a href="<?php echo e(route('portfolio.single', $portfolio->slug)); ?>">
                            <img src="<?php echo e(asset(Storage::url('/public/'.$portfolio->image))); ?>" class="image" alt="project">
                            <div class="middle">
                                <i class="fas fa-eye"></i>
                            </div>
                        </a>
                    </div>
                    <div class="content">
                        <h5 class="title"><a
                                href="<?php echo e(route('portfolio.single', $portfolio->slug)); ?>"><?php echo e($portfolio->title); ?></a>
                        </h5>
                        <span class="subtitle">
                            <?php $__currentLoopData = $portfolio->pcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subtitle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php echo e($subtitle->name); ?>

                                <?php if(!$loop->last): ?>
                                    ,
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </span>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <div class="more-project-btn">
        <a href="<?php echo e(route('portfolio')); ?>" class="axil-btn btn-large btn-fill-white" ><?php echo e(__('front.more')); ?></a>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\chalang\resources\views/front/inc/portfolio.blade.php ENDPATH**/ ?>