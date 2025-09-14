<?php
    $modalId = 'programRequest-' . $req->id;
?>

<?php if (isset($component)) { $__componentOriginal6eb288a80e68f6f6b1755bcc863df159 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6eb288a80e68f6f6b1755bcc863df159 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal.dialog','data' => ['id' => $modalId,'maxWidth' => '2xl:max-w-4xl xl:max-w-3xl lg:max-w-2xl md:max-w-xl sm:max-w-lg max-w-md','width' => 'w-full','maxHeight' => 'max-h-[90vh]']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal.dialog'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($modalId),'maxWidth' => '2xl:max-w-4xl xl:max-w-3xl lg:max-w-2xl md:max-w-xl sm:max-w-lg max-w-md','width' => 'w-full','maxHeight' => 'max-h-[90vh]']); ?>

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
        <h2 class="text-lg sm:text-xl font-bold text-[#1a2235] flex items-center gap-2">
            <i class='bx bx-bulb text-[#ffb51b] text-2xl'></i>
            <span class="leading-tight"><?php echo e($req->title); ?></span>
        </h2>
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
        <div class="space-y-6">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <?php if (isset($component)) { $__componentOriginal306f477fe089d4f950325a3d0a498c1c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal306f477fe089d4f950325a3d0a498c1c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form.label','data' => ['variant' => 'user','class' => 'text-[11px] tracking-wide']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'user','class' => 'text-[11px] tracking-wide']); ?>Submitted By <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal306f477fe089d4f950325a3d0a498c1c)): ?>
<?php $attributes = $__attributesOriginal306f477fe089d4f950325a3d0a498c1c; ?>
<?php unset($__attributesOriginal306f477fe089d4f950325a3d0a498c1c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal306f477fe089d4f950325a3d0a498c1c)): ?>
<?php $component = $__componentOriginal306f477fe089d4f950325a3d0a498c1c; ?>
<?php unset($__componentOriginal306f477fe089d4f950325a3d0a498c1c); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginale8ccace371c3ab0f80db986aafdfb091 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale8ccace371c3ab0f80db986aafdfb091 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form.readonly','data' => ['class' => 'text-sm font-semibold text-[#1a2235] bg-gray-100']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.readonly'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'text-sm font-semibold text-[#1a2235] bg-gray-100']); ?>
                        <?php echo e($req->name); ?>

                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale8ccace371c3ab0f80db986aafdfb091)): ?>
<?php $attributes = $__attributesOriginale8ccace371c3ab0f80db986aafdfb091; ?>
<?php unset($__attributesOriginale8ccace371c3ab0f80db986aafdfb091); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale8ccace371c3ab0f80db986aafdfb091)): ?>
<?php $component = $__componentOriginale8ccace371c3ab0f80db986aafdfb091; ?>
<?php unset($__componentOriginale8ccace371c3ab0f80db986aafdfb091); ?>
<?php endif; ?>
                </div>

                <div>
                    <?php if (isset($component)) { $__componentOriginal306f477fe089d4f950325a3d0a498c1c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal306f477fe089d4f950325a3d0a498c1c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form.label','data' => ['variant' => 'date','class' => 'text-[11px] tracking-wide']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'date','class' => 'text-[11px] tracking-wide']); ?>Submitted <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal306f477fe089d4f950325a3d0a498c1c)): ?>
<?php $attributes = $__attributesOriginal306f477fe089d4f950325a3d0a498c1c; ?>
<?php unset($__attributesOriginal306f477fe089d4f950325a3d0a498c1c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal306f477fe089d4f950325a3d0a498c1c)): ?>
<?php $component = $__componentOriginal306f477fe089d4f950325a3d0a498c1c; ?>
<?php unset($__componentOriginal306f477fe089d4f950325a3d0a498c1c); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginale8ccace371c3ab0f80db986aafdfb091 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale8ccace371c3ab0f80db986aafdfb091 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form.readonly','data' => ['class' => 'text-sm font-medium text-[#1a2235] bg-gray-100']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.readonly'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'text-sm font-medium text-[#1a2235] bg-gray-100']); ?>
                        <?php echo e($req->created_at->diffForHumans()); ?>

                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale8ccace371c3ab0f80db986aafdfb091)): ?>
<?php $attributes = $__attributesOriginale8ccace371c3ab0f80db986aafdfb091; ?>
<?php unset($__attributesOriginale8ccace371c3ab0f80db986aafdfb091); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale8ccace371c3ab0f80db986aafdfb091)): ?>
<?php $component = $__componentOriginale8ccace371c3ab0f80db986aafdfb091; ?>
<?php unset($__componentOriginale8ccace371c3ab0f80db986aafdfb091); ?>
<?php endif; ?>
                </div>

                <div>
                    <?php if (isset($component)) { $__componentOriginal306f477fe089d4f950325a3d0a498c1c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal306f477fe089d4f950325a3d0a498c1c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form.label','data' => ['variant' => 'user','class' => 'text-[11px] tracking-wide']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'user','class' => 'text-[11px] tracking-wide']); ?>Target Audience <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal306f477fe089d4f950325a3d0a498c1c)): ?>
<?php $attributes = $__attributesOriginal306f477fe089d4f950325a3d0a498c1c; ?>
<?php unset($__attributesOriginal306f477fe089d4f950325a3d0a498c1c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal306f477fe089d4f950325a3d0a498c1c)): ?>
<?php $component = $__componentOriginal306f477fe089d4f950325a3d0a498c1c; ?>
<?php unset($__componentOriginal306f477fe089d4f950325a3d0a498c1c); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginale8ccace371c3ab0f80db986aafdfb091 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale8ccace371c3ab0f80db986aafdfb091 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form.readonly','data' => ['class' => 'text-sm text-[#1a2235] bg-gray-100']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.readonly'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'text-sm text-[#1a2235] bg-gray-100']); ?>
                        <?php echo e($req->target_audience ?: 'Not specified'); ?>

                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale8ccace371c3ab0f80db986aafdfb091)): ?>
<?php $attributes = $__attributesOriginale8ccace371c3ab0f80db986aafdfb091; ?>
<?php unset($__attributesOriginale8ccace371c3ab0f80db986aafdfb091); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale8ccace371c3ab0f80db986aafdfb091)): ?>
<?php $component = $__componentOriginale8ccace371c3ab0f80db986aafdfb091; ?>
<?php unset($__componentOriginale8ccace371c3ab0f80db986aafdfb091); ?>
<?php endif; ?>
                </div>

                <div>
                    <?php if (isset($component)) { $__componentOriginal306f477fe089d4f950325a3d0a498c1c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal306f477fe089d4f950325a3d0a498c1c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form.label','data' => ['variant' => 'location','class' => 'text-[11px] tracking-wide']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'location','class' => 'text-[11px] tracking-wide']); ?>Proposed Location <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal306f477fe089d4f950325a3d0a498c1c)): ?>
<?php $attributes = $__attributesOriginal306f477fe089d4f950325a3d0a498c1c; ?>
<?php unset($__attributesOriginal306f477fe089d4f950325a3d0a498c1c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal306f477fe089d4f950325a3d0a498c1c)): ?>
<?php $component = $__componentOriginal306f477fe089d4f950325a3d0a498c1c; ?>
<?php unset($__componentOriginal306f477fe089d4f950325a3d0a498c1c); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginale8ccace371c3ab0f80db986aafdfb091 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale8ccace371c3ab0f80db986aafdfb091 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form.readonly','data' => ['class' => 'text-sm text-[#1a2235] bg-gray-100']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.readonly'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'text-sm text-[#1a2235] bg-gray-100']); ?>
                        <?php echo e($req->location ?: 'Not specified'); ?>

                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale8ccace371c3ab0f80db986aafdfb091)): ?>
<?php $attributes = $__attributesOriginale8ccace371c3ab0f80db986aafdfb091; ?>
<?php unset($__attributesOriginale8ccace371c3ab0f80db986aafdfb091); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale8ccace371c3ab0f80db986aafdfb091)): ?>
<?php $component = $__componentOriginale8ccace371c3ab0f80db986aafdfb091; ?>
<?php unset($__componentOriginale8ccace371c3ab0f80db986aafdfb091); ?>
<?php endif; ?>
                </div>
            </div>

            <div class="border-t border-gray-200"></div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <?php if (isset($component)) { $__componentOriginal306f477fe089d4f950325a3d0a498c1c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal306f477fe089d4f950325a3d0a498c1c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form.label','data' => ['variant' => 'date','class' => 'text-[11px] tracking-wide']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'date','class' => 'text-[11px] tracking-wide']); ?>Proposed Date <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal306f477fe089d4f950325a3d0a498c1c)): ?>
<?php $attributes = $__attributesOriginal306f477fe089d4f950325a3d0a498c1c; ?>
<?php unset($__attributesOriginal306f477fe089d4f950325a3d0a498c1c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal306f477fe089d4f950325a3d0a498c1c)): ?>
<?php $component = $__componentOriginal306f477fe089d4f950325a3d0a498c1c; ?>
<?php unset($__componentOriginal306f477fe089d4f950325a3d0a498c1c); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginale8ccace371c3ab0f80db986aafdfb091 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale8ccace371c3ab0f80db986aafdfb091 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form.readonly','data' => ['class' => 'text-sm font-medium text-[#1a2235] bg-gray-100']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.readonly'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'text-sm font-medium text-[#1a2235] bg-gray-100']); ?>
                        <?php echo e($req->proposed_date ? \Carbon\Carbon::parse($req->proposed_date)->format('M j, Y') : 'To Be Determined'); ?>

                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale8ccace371c3ab0f80db986aafdfb091)): ?>
<?php $attributes = $__attributesOriginale8ccace371c3ab0f80db986aafdfb091; ?>
<?php unset($__attributesOriginale8ccace371c3ab0f80db986aafdfb091); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale8ccace371c3ab0f80db986aafdfb091)): ?>
<?php $component = $__componentOriginale8ccace371c3ab0f80db986aafdfb091; ?>
<?php unset($__componentOriginale8ccace371c3ab0f80db986aafdfb091); ?>
<?php endif; ?>
                </div>
            </div>

            <div class="border-t border-gray-200"></div>

            <div>
                <?php if (isset($component)) { $__componentOriginal306f477fe089d4f950325a3d0a498c1c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal306f477fe089d4f950325a3d0a498c1c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form.label','data' => ['variant' => 'description','class' => 'text-[11px] tracking-wide mb-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'description','class' => 'text-[11px] tracking-wide mb-1']); ?>
                    Description
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal306f477fe089d4f950325a3d0a498c1c)): ?>
<?php $attributes = $__attributesOriginal306f477fe089d4f950325a3d0a498c1c; ?>
<?php unset($__attributesOriginal306f477fe089d4f950325a3d0a498c1c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal306f477fe089d4f950325a3d0a498c1c)): ?>
<?php $component = $__componentOriginal306f477fe089d4f950325a3d0a498c1c; ?>
<?php unset($__componentOriginal306f477fe089d4f950325a3d0a498c1c); ?>
<?php endif; ?>
                <div class="rounded-lg border border-gray-200 bg-white p-4">
                    <div class="text-sm leading-relaxed text-gray-700 whitespace-pre-line">
                        <?php echo nl2br(e($req->description)); ?>

                    </div>
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
        <div class="flex flex-col sm:flex-row justify-end items-center gap-4 w-full">
            <?php if (isset($component)) { $__componentOriginaled059d8d932fd09048df3e5a42bf4f05 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaled059d8d932fd09048df3e5a42bf4f05 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal.close-button','data' => ['modalId' => 'programRequest-' . $req->id,'text' => 'Cancel']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal.close-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['modalId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('programRequest-' . $req->id),'text' => 'Cancel']); ?>
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
                        onsubmit="return confirm('Are you sure you want to delete this request? This action cannot be undone.');">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <?php if (isset($component)) { $__componentOriginale67687e3e4e61f963b25a6bcf3983629 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale67687e3e4e61f963b25a6bcf3983629 = $attributes; } ?>
<?php $component = App\View\Components\Button::resolve(['variant' => 'delete'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit']); ?>
                        <i class='bx bx-trash'></i> Delete Request
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale67687e3e4e61f963b25a6bcf3983629)): ?>
<?php $attributes = $__attributesOriginale67687e3e4e61f963b25a6bcf3983629; ?>
<?php unset($__attributesOriginale67687e3e4e61f963b25a6bcf3983629); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale67687e3e4e61f963b25a6bcf3983629)): ?>
<?php $component = $__componentOriginale67687e3e4e61f963b25a6bcf3983629; ?>
<?php unset($__componentOriginale67687e3e4e61f963b25a6bcf3983629); ?>
<?php endif; ?>
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