<?php $__env->startSection('content'); ?>
    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['icon' => 'bx-calendar-event','title' => 'Programs','desc' => 'View and manage all programs.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'bx-calendar-event','title' => 'Programs','desc' => 'View and manage all programs.']); ?>
        <?php if(Auth::user()->hasRole('Program Coordinator') || Auth::user()->hasRole('Admin')): ?>
            <?php if (isset($component)) { $__componentOriginale67687e3e4e61f963b25a6bcf3983629 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale67687e3e4e61f963b25a6bcf3983629 = $attributes; } ?>
<?php $component = App\View\Components\Button::resolve(['variant' => 'primary'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('programs.create')).'']); ?>
                <i class='bx bx-plus-circle mr-2'></i> Create Program
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
        <?php endif; ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e)): ?>
<?php $attributes = $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e; ?>
<?php unset($__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e)): ?>
<?php $component = $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e; ?>
<?php unset($__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e); ?>
<?php endif; ?>

    <div x-data="{
            openModal(id) {
                document.getElementById('modal_' + id).showModal();
            }
        }">

        <?php
            $tabs = [
                ['id' => 'all', 'label' => 'All Programs', 'icon' => 'bx-list-ul']
            ];

            if (Auth::user()->hasRole('Volunteer')) {
                $tabs[] = ['id' => 'joined', 'label' => 'Joined Programs', 'icon' => 'bx-user-check'];
            }

            if (Auth::user()->hasRole('Program Coordinator') || Auth::user()->hasRole('Admin')) {
                $tabs[] = ['id' => 'my', 'label' => 'My Programs', 'icon' => 'bx-cog'];
            }
        ?>

        <?php if (isset($component)) { $__componentOriginal1480261582d61bdc5590b84114c27bf4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1480261582d61bdc5590b84114c27bf4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.navigation-layout.tabs-modern','data' => ['tabs' => $tabs,'defaultTab' => 'all']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('navigation-layout.tabs-modern'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tabs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tabs),'default-tab' => 'all']); ?>
             <?php $__env->slot('slot_all', null, []); ?> 
                <div id="slot_all">
                    <?php echo $__env->make('programs.partials.programsTable', ['programs' => $allPrograms, 'tab' => 'all'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
             <?php $__env->endSlot(); ?>

            <?php if(Auth::user()->hasRole('Volunteer')): ?>
                 <?php $__env->slot('slot_joined', null, []); ?> 
                    <div id="slot_joined">
                        <?php echo $__env->make('programs.partials.programsTable', ['programs' => $joinedPrograms, 'tab' => 'joined'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                 <?php $__env->endSlot(); ?>
            <?php endif; ?>

            <?php if(Auth::user()->hasRole('Program Coordinator') || Auth::user()->hasRole('Admin')): ?>
                 <?php $__env->slot('slot_my', null, []); ?> 
                    <div id="slot_my">
                        <?php echo $__env->make('programs.partials.programsTable', ['programs' => $myPrograms, 'tab' => 'my'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                 <?php $__env->endSlot(); ?>
            <?php endif; ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1480261582d61bdc5590b84114c27bf4)): ?>
<?php $attributes = $__attributesOriginal1480261582d61bdc5590b84114c27bf4; ?>
<?php unset($__attributesOriginal1480261582d61bdc5590b84114c27bf4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1480261582d61bdc5590b84114c27bf4)): ?>
<?php $component = $__componentOriginal1480261582d61bdc5590b84114c27bf4; ?>
<?php unset($__componentOriginal1480261582d61bdc5590b84114c27bf4); ?>
<?php endif; ?>

        <?php
            $uniquePrograms = collect($allPrograms->items())
                ->merge(optional($joinedPrograms)->items())
                ->merge(optional($myPrograms)->items())
                ->unique('id');
        ?>

        
        
        

        <div>
            <?php $__currentLoopData = $allPrograms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo $__env->make('programs.modals.program-modal', 
                            ['program' => $program], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php if(Auth::user()->hasRole('Volunteer')): ?>
                <?php $__currentLoopData = $joinedPrograms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $__env->make('programs.modals.program-modal', 
                            ['program' => $program], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
            <?php if(Auth::user()->hasRole('Program Coordinator') || Auth::user()->hasRole('Admin')): ?>
                <?php $__currentLoopData = $myPrograms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(Auth::id() === $program->created_by): ?>
                        <?php echo $__env->make('programs.modals.deleteProgramModal', 
                            ['program' => $program, 
                            'modalId' => 'delete-program-modal-' . $program->id], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
$(document).on('submit', '.delete-program-form', function(e) {
    e.preventDefault();

    const form = $(this);
    const modalId = form.data('modal-id');

    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: form.serialize() + '&_method=DELETE',
        success: function(response) {
            if (!response.success) return;

            const programId = response.program_id ?? form.data('program-id');

            // 1) Remove any row with this program id across all tabs
            const $rows = $(`.program-row[data-program-id="${programId}"]`);
            if ($rows.length) {
                $rows.fadeOut(200, function() { $(this).remove(); });
            }

            // 2) Optionally refresh only the active tab’s content (to update pagination/count)
            // const activeTabEl = document.querySelector('[role="tab"][aria-selected="true"]');
            // const tabId = activeTabEl?.dataset?.tab || 'all';
            // const slotId = `#slot_${tabId}`;
            // if (document.querySelector(slotId)) {
            //     $(slotId).load(location.href + ` ${slotId} > *`);
            // }
            ['all','joined','my'].forEach(tabId => {
                const slotId = `#slot_${tabId}`;
                if (document.querySelector(slotId)) {
                    $(slotId).load(location.href + ` ${slotId} > *`);
                }
            });
            
            // 3) Close modal
            if (modalId) {
                const dlg = document.getElementById(modalId);
                if (dlg?.close) dlg.close();
            }

            console.log('Program deleted successfully.');
        },
        error: function() {
            console.error('Failed to delete program. Please try again.');
        }
    });
});
</script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.sidebar_final', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/programs/index.blade.php ENDPATH**/ ?>