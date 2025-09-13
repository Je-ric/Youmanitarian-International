<?php if($hours->isNotEmpty()): ?>
    <ul class="space-y-2">
        <?php $__currentLoopData = $hours; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
                <a href="<?php echo e(route('consultation-chats.start', $h->professional->id)); ?>"
                    class="group p-2 rounded-lg bg-gray-50 border border-gray-100 flex items-center justify-between hover:bg-white hover:shadow-sm transition">
                    <div>
                        <p class="font-medium text-gray-800 text-xs group-hover:text-[#1a2235]">
                            <?php echo e($h->specialization ?? ''); ?>

                        </p>
                        <p class="text-[11px] text-gray-500">
                            <?php echo e($h->day ?? ''); ?>

                        </p>
                    </div>
                    <span
                        class="text-[11px] font-medium text-[#1a2235] bg-white px-2 py-0.5 rounded border border-gray-200">
                        <?php echo e(\Carbon\Carbon::parse($h->start_time)->format('g:i A')); ?> –
                        <?php echo e(\Carbon\Carbon::parse($h->end_time)->format('g:i A')); ?>

                    </span>
                </a>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
<?php else: ?>
    <div class="p-3 text-xs text-gray-500 bg-gray-50 rounded-lg">
        No active consultation hours.
    </div>
<?php endif; ?>
<?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/programs_chats/partials/consultationHours.blade.php ENDPATH**/ ?>