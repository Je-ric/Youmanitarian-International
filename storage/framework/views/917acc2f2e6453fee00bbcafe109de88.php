<?php if($volunteer->application): ?>
    <?php if (isset($component)) { $__componentOriginal5047e3a08dc66ef13a024f32c8319cd0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5047e3a08dc66ef13a024f32c8319cd0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.overview.card','data' => ['title' => 'Application Form Details','icon' => 'bx-file-text','variant' => 'default']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('overview.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Application Form Details','icon' => 'bx-file-text','variant' => 'default']); ?>
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div class="bg-gradient-to-br from-slate-50 to-gray-50 rounded-xl p-4 border border-gray-200">
                        <label class="block text-sm font-semibold text-[#1a2235] mb-2">Why Volunteer:</label>
                        <p class="text-gray-700 leading-relaxed"><?php echo e($volunteer->application->why_volunteer ?? 'Not specified'); ?></p>
                    </div>
                    <div class="bg-gradient-to-br from-slate-50 to-gray-50 rounded-xl p-4 border border-gray-200">
                        <label class="block text-sm font-semibold text-[#1a2235] mb-2">Interested Programs:</label>
                        <p class="text-gray-700 leading-relaxed"><?php echo e($volunteer->application->interested_programs ?? 'Not specified'); ?></p>
                    </div>
                    <div class="bg-gradient-to-br from-slate-50 to-gray-50 rounded-xl p-4 border border-gray-200">
                        <label class="block text-sm font-semibold text-[#1a2235] mb-2">Skills & Experience:</label>
                        <p class="text-gray-700 leading-relaxed"><?php echo e($volunteer->application->skills_experience ?? 'Not specified'); ?></p>
                    </div>
                    <div class="bg-gradient-to-br from-slate-50 to-gray-50 rounded-xl p-4 border border-gray-200">
                        <label class="block text-sm font-semibold text-[#1a2235] mb-2">Availability:</label>
                        <p class="text-gray-700 leading-relaxed"><?php echo e($volunteer->application->availability ?? 'Not specified'); ?></p>
                    </div>
                    <div class="bg-gradient-to-br from-slate-50 to-gray-50 rounded-xl p-4 border border-gray-200">
                        <label class="block text-sm font-semibold text-[#1a2235] mb-2">Commitment Hours:</label>
                        <p class="text-gray-700 leading-relaxed"><?php echo e($volunteer->application->commitment_hours ?? 'Not specified'); ?></p>
                    </div>
                </div>
                <div class="space-y-6">
                    <div class="bg-gradient-to-br from-slate-50 to-gray-50 rounded-xl p-4 border border-gray-200">
                        <label class="block text-sm font-semibold text-[#1a2235] mb-2">Physical Limitations:</label>
                        <p class="text-gray-700 leading-relaxed"><?php echo e($volunteer->application->physical_limitations ?? 'None specified'); ?></p>
                    </div>
                    <div class="bg-gradient-to-br from-slate-50 to-gray-50 rounded-xl p-4 border border-gray-200">
                        <label class="block text-sm font-semibold text-[#1a2235] mb-2">Emergency Contact:</label>
                        <p class="text-gray-700 leading-relaxed"><?php echo e($volunteer->application->emergency_contact ?? 'Not specified'); ?></p>
                    </div>
                    <div class="bg-gradient-to-br from-slate-50 to-gray-50 rounded-xl p-4 border border-gray-200">
                        <label class="block text-sm font-semibold text-[#1a2235] mb-2">Short Bio:</label>
                        <p class="text-gray-700 leading-relaxed"><?php echo e($volunteer->application->short_bio ?? 'Not specified'); ?></p>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-4 border border-blue-200 text-center">
                            <div class="text-sm font-medium text-blue-700 mb-1">Contact Consent</div>
                            <?php if (isset($component)) { $__componentOriginala31a0527394ddcdc63fabbed2d94514c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala31a0527394ddcdc63fabbed2d94514c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.feedback-status.status-indicator','data' => ['status' => $volunteer->application->contact_consent === 'yes' ? 'success' : 'danger','label' => ucfirst($volunteer->application->contact_consent)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('feedback-status.status-indicator'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($volunteer->application->contact_consent === 'yes' ? 'success' : 'danger'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(ucfirst($volunteer->application->contact_consent))]); ?>
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

                        <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-4 border border-green-200 text-center">
                            <div class="text-sm font-medium text-green-700 mb-1">Volunteered Before</div>
                            <?php if (isset($component)) { $__componentOriginala31a0527394ddcdc63fabbed2d94514c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala31a0527394ddcdc63fabbed2d94514c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.feedback-status.status-indicator','data' => ['status' => $volunteer->application->volunteered_before === 'yes' ? 'success' : 'neutral','label' => ucfirst($volunteer->application->volunteered_before)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('feedback-status.status-indicator'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($volunteer->application->volunteered_before === 'yes' ? 'success' : 'neutral'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(ucfirst($volunteer->application->volunteered_before))]); ?>
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

                        <div class="bg-gradient-to-br from-amber-50 to-yellow-50 rounded-xl p-4 border border-amber-200 text-center col-span-2">
                            <div class="text-sm font-medium text-amber-700 mb-1">Outdoor Activities OK</div>
                            <?php if (isset($component)) { $__componentOriginala31a0527394ddcdc63fabbed2d94514c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala31a0527394ddcdc63fabbed2d94514c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.feedback-status.status-indicator','data' => ['status' => $volunteer->application->outdoor_ok === 'yes' ? 'success' : ($volunteer->application->outdoor_ok === 'depends' ? 'warning' : 'danger'),'label' => ucfirst($volunteer->application->outdoor_ok)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('feedback-status.status-indicator'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($volunteer->application->outdoor_ok === 'yes' ? 'success' : ($volunteer->application->outdoor_ok === 'depends' ? 'warning' : 'danger')),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(ucfirst($volunteer->application->outdoor_ok))]); ?>
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
                    </div>
                </div>
            </div>
            
            <div class="mt-8 pt-6 border-t border-gray-200">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 text-sm">

                    <div class="flex items-center gap-2">
                        <span class="text-gray-600">Application Status:</span>
                        <?php if (isset($component)) { $__componentOriginala31a0527394ddcdc63fabbed2d94514c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala31a0527394ddcdc63fabbed2d94514c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.feedback-status.status-indicator','data' => ['status' => $volunteer->application->is_active ? 'success' : 'danger','label' => $volunteer->application->is_active ? 'Active' : 'Inactive']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('feedback-status.status-indicator'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($volunteer->application->is_active ? 'success' : 'danger'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($volunteer->application->is_active ? 'Active' : 'Inactive')]); ?>
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

                    <div class="flex items-center gap-2 text-gray-500">
                        <i class='bx bx-calendar'></i>
                        <span>Submitted: <?php echo e($volunteer->application->submitted_at ? \Carbon\Carbon::parse($volunteer->application->submitted_at)->format('M d, Y') : 'Not specified'); ?></span>
                    </div>
                </div>
            </div>
        </div>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5047e3a08dc66ef13a024f32c8319cd0)): ?>
<?php $attributes = $__attributesOriginal5047e3a08dc66ef13a024f32c8319cd0; ?>
<?php unset($__attributesOriginal5047e3a08dc66ef13a024f32c8319cd0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5047e3a08dc66ef13a024f32c8319cd0)): ?>
<?php $component = $__componentOriginal5047e3a08dc66ef13a024f32c8319cd0; ?>
<?php unset($__componentOriginal5047e3a08dc66ef13a024f32c8319cd0); ?>
<?php endif; ?>
<?php else: ?>
    <?php if (isset($component)) { $__componentOriginal5047e3a08dc66ef13a024f32c8319cd0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5047e3a08dc66ef13a024f32c8319cd0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.overview.card','data' => ['title' => 'Application Form Details','icon' => 'bx-file-text','variant' => 'default']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('overview.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Application Form Details','icon' => 'bx-file-text','variant' => 'default']); ?>
        <div class="p-12 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class='bx bx-file-text text-gray-400 text-2xl'></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-1">No Application Data</h3>
            <p class="text-gray-500">This User hasn't submitted an application form yet.</p>
        </div>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5047e3a08dc66ef13a024f32c8319cd0)): ?>
<?php $attributes = $__attributesOriginal5047e3a08dc66ef13a024f32c8319cd0; ?>
<?php unset($__attributesOriginal5047e3a08dc66ef13a024f32c8319cd0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5047e3a08dc66ef13a024f32c8319cd0)): ?>
<?php $component = $__componentOriginal5047e3a08dc66ef13a024f32c8319cd0; ?>
<?php unset($__componentOriginal5047e3a08dc66ef13a024f32c8319cd0); ?>
<?php endif; ?>
<?php endif; ?> <?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/volunteers/partials/applicationProfile.blade.php ENDPATH**/ ?>