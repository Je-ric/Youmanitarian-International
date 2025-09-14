<?php $__env->startSection('content'); ?>
    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['icon' => 'bx-group','title' => 'Manage Team Members','desc' => 'View, add, and update your organization\'s team members in one place.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'bx-group','title' => 'Manage Team Members','desc' => 'View, add, and update your organization\'s team members in one place.']); ?>

        <?php if (isset($component)) { $__componentOriginale67687e3e4e61f963b25a6bcf3983629 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale67687e3e4e61f963b25a6bcf3983629 = $attributes; } ?>
<?php $component = App\View\Components\Button::resolve(['variant' => 'add-create'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['onclick' => 'document.getElementById(\'addTeamMemberModal\').showModal(); return false;']); ?>
            <i class='bx bx-plus-circle mr-2'></i> Add Team Member
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

    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-base sm:text-lg text-gray-600 font-medium leading-relaxed">
            The details you add here will be displayed on the
            <span class="font-semibold text-gray-800">Team Members</span> page of the website.
        </h2>


        <?php echo $__env->make('content.dynamic.manageTeamMemberModal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <?php $__currentLoopData = $teamMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category => $members): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="mb-8">
                <h3 class="text-xl sm:text-2xl font-semibold text-gray-800 mb-4 capitalize">
                    <?php echo e($category); ?>

                </h3>

                <div class="grid gap-4 sm:gap-5 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5">
                    <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-white rounded-xl shadow-md p-4 text-center border border-gray-100 hover:shadow-lg transition-all duration-200 relative group"
                            draggable="true" data-id="<?php echo e($member->id); ?>">
                            <div class="absolute top-2 right-2">
                                <?php if (isset($component)) { $__componentOriginala31a0527394ddcdc63fabbed2d94514c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala31a0527394ddcdc63fabbed2d94514c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.feedback-status.status-indicator','data' => ['status' => $member->is_active ? 'success' : 'danger','label' => $member->is_active ? 'Displayed' : 'Not Displayed']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('feedback-status.status-indicator'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($member->is_active ? 'success' : 'danger'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($member->is_active ? 'Displayed' : 'Not Displayed')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala31a0527394ddcdc63fabbed2d94514c)): ?>
<?php $attributes = $__attributesOriginala31a0527394ddcdc63fabbed2d94514c; ?>
<?php unset($__attributesOriginala31a0527394ddcdc63fabbed2d94514c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala31a0527394ddcdc63fabbed2d94514c)): ?>
<?php $component = $__componentOriginala31a0527394ddcdc63fabbed2d94514c; ?>
<?php unset($__componentOriginala31a0527394ddcdc63fabbed2d94514c); ?>
<?php endif; ?>
                            </div>

                            <div class="w-20 h-20 sm:w-24 sm:h-24 mx-auto mb-3 relative">
                                <img src="<?php echo e(asset('storage/' . $member->photo_url)); ?>" alt="<?php echo e($member->name); ?>"
                                    class="w-full h-full object-cover rounded-full border-3 border-primary-custom shadow-sm">
                            </div>

                            <h3 class="text-lg font-bold text-gray-800 leading-tight"><?php echo e($member->name); ?></h3>
                            <p class="text-gray-500 text-xs sm:text-sm mb-2 leading-tight"><?php echo e($member->position); ?></p>

                            <?php if($member->bio): ?>
                                <p class="mt-2 text-gray-600 text-xs leading-relaxed line-clamp-2"><?php echo e($member->bio); ?></p>
                            <?php endif; ?>

                            <div class="flex justify-center space-x-3 mt-2">
                                <?php if($member->facebook_url): ?>
                                    <a href="<?php echo e($member->facebook_url); ?>" target="_blank" rel="noopener"
                                        aria-label="Facebook" class="text-blue-600 hover:text-blue-700 text-sm">
                                        <i class="bx bxl-facebook"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if($member->linkedin_url): ?>
                                    <a href="<?php echo e($member->linkedin_url); ?>" target="_blank" rel="noopener"
                                        aria-label="LinkedIn" class="text-blue-700 hover:text-blue-800 text-sm">
                                        <i class="bx bxl-linkedin"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if($member->twitter_url): ?>
                                    <a href="<?php echo e($member->twitter_url); ?>" target="_blank" rel="noopener" aria-label="Twitter"
                                        class="text-sky-500 hover:text-sky-600 text-sm">
                                        <i class="bx bxl-twitter"></i>
                                    </a>
                                <?php endif; ?>
                            </div>

                            <div class="flex justify-center space-x-2 mt-3">
                                <button type="button"
                                    onclick="document.getElementById('editTeamMemberModal_<?php echo e($member->id); ?>').showModal(); return false;"
                                    class="text-yellow-500 hover:text-yellow-600 text-sm p-1">
                                    <i class="bx bx-edit-alt"></i>
                                </button>
                                <form method="POST" action="<?php echo e(route('content.teamMembers.destroy', $member->id)); ?>">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="text-red-600 hover:text-red-700 text-sm p-1">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <?php echo $__env->make('content.dynamic.manageTeamMemberModal', [
                            'isUpdate' => true,
                            'member' => $member,
                            'modalId' => 'editTeamMemberModal_' . $member->id,
                        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.sidebar_final', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/content/dynamic/teamMembers.blade.php ENDPATH**/ ?>