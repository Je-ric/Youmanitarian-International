<?php if (isset($component)) { $__componentOriginal6eb288a80e68f6f6b1755bcc863df159 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6eb288a80e68f6f6b1755bcc863df159 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal.dialog','data' => ['id' => 'programRequest-' . $req->id,'maxWidth' => 'lg:max-w-2xl w-full']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal.dialog'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('programRequest-' . $req->id),'maxWidth' => 'lg:max-w-2xl w-full']); ?>
    <?php if (isset($component)) { $__componentOriginalbe09faad1c8b3f6fb64e0c479030b4cf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbe09faad1c8b3f6fb64e0c479030b4cf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal.header','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal.header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
        <div class="flex items-start gap-3">
            <div class="shrink-0 w-10 h-10 flex items-center justify-center rounded-lg bg-[#ffb51b]/10">
                <i class='bx bx-bulb text-[#ffb51b] text-2xl'></i>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-[#1a2235] leading-tight">
                    <?php echo e($req->title); ?>

                </h2>
                <p class="text-xs text-gray-500">
                    Submitted <?php echo e($req->created_at->diffForHumans()); ?>

                </p>
            </div>
        </div>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbe09faad1c8b3f6fb64e0c479030b4cf)): ?>
<?php $attributes = $__attributesOriginalbe09faad1c8b3f6fb64e0c479030b4cf; ?>
<?php unset($__attributesOriginalbe09faad1c8b3f6fb64e0c479030b4cf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbe09faad1c8b3f6fb64e0c479030b4cf)): ?>
<?php $component = $__componentOriginalbe09faad1c8b3f6fb64e0c479030b4cf; ?>
<?php unset($__componentOriginalbe09faad1c8b3f6fb64e0c479030b4cf); ?>
<?php endif; ?>

    <?php if (isset($component)) { $__componentOriginal0ad23ec26c64eb1a0d6e4c82d27f0428 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0ad23ec26c64eb1a0d6e4c82d27f0428 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal.body','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal.body'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
        <div class="space-y-6 text-sm">

            <!-- Info Grid -->
            <div class="grid sm:grid-cols-2 gap-6">
                <div>
                    <p class="text-[11px] uppercase text-gray-500 tracking-wide">Submitted By</p>
                    <p class="mt-1 font-medium text-[#1a2235]"><?php echo e($req->name); ?></p>
                </div>
                <div>
                    <p class="text-[11px] uppercase text-gray-500 tracking-wide">Target Audience</p>
                    <p class="mt-1 text-gray-700"><?php echo e($req->target_audience ?: '—'); ?></p>
                </div>
                <div>
                    <p class="text-[11px] uppercase text-gray-500 tracking-wide">Location</p>
                    <p class="mt-1 text-gray-700"><?php echo e($req->location ?: '—'); ?></p>
                </div>
                <div>
                    <p class="text-[11px] uppercase text-gray-500 tracking-wide">Proposed Date</p>
                    <p class="mt-1">
                        <span class="inline-flex px-2 py-0.5 rounded bg-[#1a2235]/10 text-[#1a2235] font-medium">
                            <?php echo e($req->proposed_date ? \Carbon\Carbon::parse($req->proposed_date)->format('M j, Y') : 'TBD'); ?>

                        </span>
                    </p>
                </div>
            </div>

            <!-- Divider -->
            <div class="border-t border-gray-200"></div>

            <!-- Description -->
            <div>
                <p class="text-[11px] uppercase text-gray-500 tracking-wide mb-2">Description</p>
                <div class="text-gray-700 leading-relaxed whitespace-pre-line text-sm">
                    <?php echo nl2br(e($req->description)); ?>

                </div>
            </div>

        </div>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0ad23ec26c64eb1a0d6e4c82d27f0428)): ?>
<?php $attributes = $__attributesOriginal0ad23ec26c64eb1a0d6e4c82d27f0428; ?>
<?php unset($__attributesOriginal0ad23ec26c64eb1a0d6e4c82d27f0428); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0ad23ec26c64eb1a0d6e4c82d27f0428)): ?>
<?php $component = $__componentOriginal0ad23ec26c64eb1a0d6e4c82d27f0428; ?>
<?php unset($__componentOriginal0ad23ec26c64eb1a0d6e4c82d27f0428); ?>
<?php endif; ?>

    <?php if (isset($component)) { $__componentOriginalf6cca9f771ea92c42bfffab22cf7806c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf6cca9f771ea92c42bfffab22cf7806c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal.footer','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal.footer'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
        <div class="flex flex-col sm:flex-row justify-end gap-2 w-full">
            <?php if (isset($component)) { $__componentOriginaled059d8d932fd09048df3e5a42bf4f05 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaled059d8d932fd09048df3e5a42bf4f05 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal.close-button','data' => ['modalId' => 'programRequest-' . $req->id,'text' => 'Close']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal.close-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['modalId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('programRequest-' . $req->id),'text' => 'Close']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaled059d8d932fd09048df3e5a42bf4f05)): ?>
<?php $attributes = $__attributesOriginaled059d8d932fd09048df3e5a42bf4f05; ?>
<?php unset($__attributesOriginaled059d8d932fd09048df3e5a42bf4f05); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaled059d8d932fd09048df3e5a42bf4f05)): ?>
<?php $component = $__componentOriginaled059d8d932fd09048df3e5a42bf4f05; ?>
<?php unset($__componentOriginaled059d8d932fd09048df3e5a42bf4f05); ?>
<?php endif; ?>
            <form action="<?php echo e(route('program_requests.destroy', $req)); ?>" method="POST"
                  onsubmit="return confirm('Delete this request?');">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit"
                        class="inline-flex items-center gap-1 px-3 py-2 rounded-lg bg-red-50 text-red-600 text-xs font-medium hover:bg-red-100 transition">
                    <i class='bx bx-trash text-sm'></i> Delete
                </button>
            </form>
        </div>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf6cca9f771ea92c42bfffab22cf7806c)): ?>
<?php $attributes = $__attributesOriginalf6cca9f771ea92c42bfffab22cf7806c; ?>
<?php unset($__attributesOriginalf6cca9f771ea92c42bfffab22cf7806c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf6cca9f771ea92c42bfffab22cf7806c)): ?>
<?php $component = $__componentOriginalf6cca9f771ea92c42bfffab22cf7806c; ?>
<?php unset($__componentOriginalf6cca9f771ea92c42bfffab22cf7806c); ?>
<?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6eb288a80e68f6f6b1755bcc863df159)): ?>
<?php $attributes = $__attributesOriginal6eb288a80e68f6f6b1755bcc863df159; ?>
<?php unset($__attributesOriginal6eb288a80e68f6f6b1755bcc863df159); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6eb288a80e68f6f6b1755bcc863df159)): ?>
<?php $component = $__componentOriginal6eb288a80e68f6f6b1755bcc863df159; ?>
<?php unset($__componentOriginal6eb288a80e68f6f6b1755bcc863df159); ?>
<?php endif; ?>
<?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/program_requests/modals/programRequestDetails.blade.php ENDPATH**/ ?>