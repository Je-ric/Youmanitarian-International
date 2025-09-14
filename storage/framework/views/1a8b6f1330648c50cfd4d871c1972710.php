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

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <?php if (isset($component)) { $__componentOriginal879d72999cba16bc59a433a99b6fe39e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal879d72999cba16bc59a433a99b6fe39e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.feedback-status.alert','data' => ['variant' => 'flexible','icon' => 'bx bx-info-circle','bgColor' => 'bg-blue-50','textColor' => 'text-gray-700','borderColor' => 'border-blue-200','iconColor' => 'text-blue-500','message' => 'The details you add here will be displayed on the <span class=\'font-semibold text-gray-800\'>Team Members</span> page of the website.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('feedback-status.alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'flexible','icon' => 'bx bx-info-circle','bgColor' => 'bg-blue-50','textColor' => 'text-gray-700','borderColor' => 'border-blue-200','iconColor' => 'text-blue-500','message' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('The details you add here will be displayed on the <span class=\'font-semibold text-gray-800\'>Team Members</span> page of the website.')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal879d72999cba16bc59a433a99b6fe39e)): ?>
<?php $attributes = $__attributesOriginal879d72999cba16bc59a433a99b6fe39e; ?>
<?php unset($__attributesOriginal879d72999cba16bc59a433a99b6fe39e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal879d72999cba16bc59a433a99b6fe39e)): ?>
<?php $component = $__componentOriginal879d72999cba16bc59a433a99b6fe39e; ?>
<?php unset($__componentOriginal879d72999cba16bc59a433a99b6fe39e); ?>
<?php endif; ?>

        <?php echo $__env->make('content.dynamic.manageTeamMemberModal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <?php $__currentLoopData = $teamMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category => $members): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="mb-10 last:mb-0">
                <div class="mb-6">
                    <h3 class="text-2xl sm:text-3xl font-bold text-[#1a2235] mb-2 capitalize tracking-tight">
                        <?php echo e($category); ?>

                    </h3>
                    <div class="w-16 h-1 bg-[#ffb51b] rounded-full"></div>
                </div>

                <div class="grid gap-6 sm:gap-8 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
                    <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl p-6 text-center border border-[#ffb51b] hover:border-[#ffb51b]/20 transition-all duration-300 relative group transform hover:-translate-y-1"
                            data-id="<?php echo e($member->id); ?>">

                            <div class="absolute top-4 right-4 z-10">
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

                            <div class="w-24 h-24 sm:w-28 sm:h-28 mx-auto mb-4 relative">
                                <img src="<?php echo e(asset('storage/' . $member->photo_url)); ?>" alt="<?php echo e($member->name); ?>"
                                    class="w-full h-full object-cover rounded-full border-4 border-[#ffb51b] shadow-lg ring-4 ring-[#ffb51b]/10">
                                <div class="absolute inset-0 rounded-full bg-gradient-to-t from-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>

                            <div class="space-y-3">
                                <h3 class="text-xl font-bold text-[#1a2235] leading-tight"><?php echo e($member->name); ?></h3>
                                <p class="text-gray-600 text-sm font-medium bg-gray-50 px-3 py-1 rounded-full inline-block"><?php echo e($member->position); ?></p>

                                <?php if($member->bio): ?>
                                    <p class="text-gray-600 text-sm leading-relaxed line-clamp-3 px-2"><?php echo e($member->bio); ?></p>
                                <?php endif; ?>
                            </div>

                            <?php if($member->facebook_url || $member->linkedin_url || $member->twitter_url): ?>
                                <div class="flex justify-center space-x-4 mt-5 pt-4 border-t border-gray-100">
                                    <?php if($member->facebook_url): ?>
                                        <a href="<?php echo e($member->facebook_url); ?>" target="_blank" rel="noopener"
                                            aria-label="Facebook" class="w-8 h-8 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white rounded-full flex items-center justify-center transition-all duration-200">
                                            <i class="bx bxl-facebook text-lg"></i>
                                        </a>
                                    <?php endif; ?>
                                    <?php if($member->linkedin_url): ?>
                                        <a href="<?php echo e($member->linkedin_url); ?>" target="_blank" rel="noopener"
                                            aria-label="LinkedIn" class="w-8 h-8 bg-blue-50 text-blue-700 hover:bg-blue-700 hover:text-white rounded-full flex items-center justify-center transition-all duration-200">
                                            <i class="bx bxl-linkedin text-lg"></i>
                                        </a>
                                    <?php endif; ?>
                                    <?php if($member->twitter_url): ?>
                                        <a href="<?php echo e($member->twitter_url); ?>" target="_blank" rel="noopener" aria-label="Twitter"
                                            class="w-8 h-8 bg-sky-50 text-sky-500 hover:bg-sky-500 hover:text-white rounded-full flex items-center justify-center transition-all duration-200">
                                            <i class="bx bxl-twitter text-lg"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <div class="flex justify-center space-x-3 mt-6 pt-4 border-t border-gray-100">
                                <button type="button"
                                    onclick="document.getElementById('editTeamMemberModal_<?php echo e($member->id); ?>').showModal(); return false;"
                                    class="w-9 h-9 bg-[#ffb51b]/10 text-[#ffb51b] hover:bg-[#ffb51b] hover:text-white rounded-full flex items-center justify-center transition-all duration-200 hover:scale-110">
                                    <i class="bx bx-edit-alt text-lg"></i>
                                </button>
                                <form method="POST" action="<?php echo e(route('content.teamMembers.destroy', $member->id)); ?>" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="w-9 h-9 bg-red-50 text-red-500 hover:bg-red-500 hover:text-white rounded-full flex items-center justify-center transition-all duration-200 hover:scale-110">
                                        <i class="bx bx-trash text-lg"></i>
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