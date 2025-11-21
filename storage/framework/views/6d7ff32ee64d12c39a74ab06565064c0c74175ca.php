
<button <?php if($item->childs()->count() > 0): ?> disabled  <?php endif; ?> class=' btn btn-danger destroy ' title='Sil' data-id="<?php echo e($item->id); ?>" route="<?php echo e(route('admin.service.destroy','destroy')); ?>"><i class=' ri-delete-bin-2-line'></i></button>
<a href="<?php echo e(route('admin.service.edit',$item->id)); ?>" class='btn btn-info ' title='Düzənlə' data-route="" ><i class='fas fa-pen'></i></a>
                                 <?php /**PATH C:\xampp\htdocs\chalang\resources\views/admin/pages/service/table_actions.blade.php ENDPATH**/ ?>