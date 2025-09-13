<div class="space-y-6">
    
    <div class="relative bg-gradient-to-br from-white via-slate-50 to-gray-50 rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
        
        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-[#ffb51b]/10 to-[#1a2235]/5 rounded-full -translate-y-16 translate-x-16"></div>
        <div class="absolute bottom-0 left-0 w-24 h-24 bg-gradient-to-tr from-[#1a2235]/5 to-[#ffb51b]/10 rounded-full translate-y-12 -translate-x-12"></div>
        
        <div class="relative p-6 sm:p-8">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 sm:gap-6">
                    
                    <div class="relative">
                        <?php
                            $userModel = $volunteer->user;
                            $profilePic = $userModel->profile_pic; // stored as 'storage/uploads/profile_photo/...' or external URL
                            $legacyPic = $userModel->profile_photo_path; // jetstream style (optional)
                        ?>

                        <?php if($profilePic): ?>
                            <img src="<?php echo e(asset($profilePic)); ?>"
                                 alt="Profile Photo"
                                 class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl object-cover border-4 border-white shadow-lg">
                        <?php elseif($legacyPic): ?>
                            <img src="<?php echo e(asset('storage/' . $legacyPic)); ?>"
                                 alt="Profile Photo"
                                 class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl object-cover border-4 border-white shadow-lg">
                        <?php else: ?>
                            <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl bg-gradient-to-br from-[#ffb51b] to-[#e6a017] flex items-center justify-center border-4 border-white shadow-lg">
                                <i class='bx bx-user text-white text-3xl sm:text-4xl'></i>
                            </div>
                        <?php endif; ?>

                        <?php if(Auth::id() === $userModel->id): ?>
                            <form action="<?php echo e(route('profile.photo.update')); ?>" method="POST" enctype="multipart/form-data"
                                  class="absolute -bottom-2 -right-2">
                                <?php echo csrf_field(); ?>
                                <input
                                    id="profilePicInput-<?php echo e($volunteer->id); ?>"
                                    type="file"
                                    name="profile_pic"
                                    accept="image/*"
                                    class="hidden"
                                    onchange="this.form.submit();">
                                <button type="button"
                                        onclick="document.getElementById('profilePicInput-<?php echo e($volunteer->id); ?>').click();"
                                        class="w-9 h-9 rounded-xl bg-white border border-gray-200 shadow flex items-center justify-center text-gray-600 hover:text-[#1a2235] hover:border-[#1a2235] transition"
                                        title="Change Photo">
                                    <i class='bx bx-camera text-lg'></i>
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                    
                    
                    <div class="space-y-2">
                        <h1 class="text-2xl sm:text-3xl font-bold text-[#1a2235] tracking-tight"><?php echo e($volunteer->user->name); ?></h1>
                        <p class="text-gray-600 text-sm sm:text-base"><?php echo e($volunteer->user->email); ?></p>
                    </div>
                </div>
                
                
                <div class="flex flex-col items-start sm:items-end gap-3">
                    
                    <?php if (isset($component)) { $__componentOriginala31a0527394ddcdc63fabbed2d94514c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala31a0527394ddcdc63fabbed2d94514c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.feedback-status.status-indicator','data' => ['status' => $volunteer->application_status,'label' => ucfirst($volunteer->application_status)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('feedback-status.status-indicator'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($volunteer->application_status),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(ucfirst($volunteer->application_status))]); ?>
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
                    
                
                    <div class="flex gap-4 text-center">
                        <div class="text-center">
                            <div class="text-lg sm:text-xl font-bold text-[#1a2235]"><?php echo e($volunteer->calculated_total_hours); ?></div>
                            <div class="text-xs text-gray-500">Hours</div>
                        </div>
                        
                        <div class="text-center">
                            <div class="text-lg sm:text-xl font-bold text-[#1a2235]"><?php echo e($volunteer->attendanceLogs->count()); ?></div>
                            <div class="text-xs text-gray-500">Programs</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        
        <?php if (isset($component)) { $__componentOriginal5047e3a08dc66ef13a024f32c8319cd0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5047e3a08dc66ef13a024f32c8319cd0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.overview.card','data' => ['title' => 'User Information','icon' => 'bx-user-circle','variant' => 'default']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('overview.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'User Information','icon' => 'bx-user-circle','variant' => 'default']); ?>
            <div class="space-y-4">
                <div class="grid grid-cols-1 gap-4">
                    
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="font-medium text-gray-700 text-sm">Full Name</span>
                        <span class="text-gray-900 font-medium"><?php echo e($volunteer->user->name); ?></span>
                    </div>
                    
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="font-medium text-gray-700 text-sm">Email Address</span>
                        <span class="text-gray-900 text-sm"><?php echo e($volunteer->user->email); ?></span>
                    </div>
                    
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="font-medium text-gray-700 text-sm">Email Verified</span>
                        <span class="text-sm">
                            <?php if($volunteer->user->email_verified_at): ?>
                                <?php if (isset($component)) { $__componentOriginala31a0527394ddcdc63fabbed2d94514c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala31a0527394ddcdc63fabbed2d94514c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.feedback-status.status-indicator','data' => ['status' => 'verified','label' => 'Verified']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('feedback-status.status-indicator'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => 'verified','label' => 'Verified']); ?>
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
                            <?php else: ?>
                                <?php if (isset($component)) { $__componentOriginala31a0527394ddcdc63fabbed2d94514c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala31a0527394ddcdc63fabbed2d94514c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.feedback-status.status-indicator','data' => ['status' => 'not_verified','label' => 'Not Verified']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('feedback-status.status-indicator'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => 'not_verified','label' => 'Not Verified']); ?>
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
                            <?php endif; ?>
                        </span>
                    </div>
                    
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="font-medium text-gray-700 text-sm">Account Created</span>
                        <span class="text-gray-900 text-sm"><?php echo e($volunteer->user->created_at->format('M d, Y')); ?></span>
                    </div>
                    
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="font-medium text-gray-700 text-sm">Google Account</span>
                        <span class="text-sm">
                            <?php if($volunteer->user->google_id): ?>
                                <?php if (isset($component)) { $__componentOriginala31a0527394ddcdc63fabbed2d94514c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala31a0527394ddcdc63fabbed2d94514c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.feedback-status.status-indicator','data' => ['status' => 'connected','label' => 'Connected']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('feedback-status.status-indicator'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => 'connected','label' => 'Connected']); ?>
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
                            <?php else: ?>
                                <?php if (isset($component)) { $__componentOriginala31a0527394ddcdc63fabbed2d94514c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala31a0527394ddcdc63fabbed2d94514c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.feedback-status.status-indicator','data' => ['status' => 'not_connected','label' => 'Not Connected']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('feedback-status.status-indicator'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => 'not_connected','label' => 'Not Connected']); ?>
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
                            <?php endif; ?>
                        </span>
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

        
        <?php if (isset($component)) { $__componentOriginal5047e3a08dc66ef13a024f32c8319cd0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5047e3a08dc66ef13a024f32c8319cd0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.overview.card','data' => ['title' => 'Volunteer Information','icon' => 'bx-heart','variant' => 'gradient']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('overview.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Volunteer Information','icon' => 'bx-heart','variant' => 'gradient']); ?>
            <div class="space-y-4">
                <div class="grid grid-cols-1 gap-4">
                    
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="font-medium text-gray-700 text-sm">Application Status</span>
                        <?php if (isset($component)) { $__componentOriginala31a0527394ddcdc63fabbed2d94514c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala31a0527394ddcdc63fabbed2d94514c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.feedback-status.status-indicator','data' => ['status' => $volunteer->application_status,'label' => ucfirst($volunteer->application_status)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('feedback-status.status-indicator'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($volunteer->application_status),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(ucfirst($volunteer->application_status))]); ?>
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
                    
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="font-medium text-gray-700 text-sm">Total Hours</span>
                        <span class="text-gray-900 font-bold text-lg"><?php echo e($volunteer->calculated_total_hours); ?>h</span>
                    </div>
                    
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="font-medium text-gray-700 text-sm">Joined Date</span>
                        <span class="text-gray-900 text-sm">
                            <?php if($volunteer->joined_at): ?>
                                <?php echo e(\Carbon\Carbon::parse($volunteer->joined_at)->format('M d, Y')); ?>

                            <?php else: ?>
                                <span class="text-gray-500">Not specified</span>
                            <?php endif; ?>
                        </span>
                    </div>
                    
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="font-medium text-gray-700 text-sm">Volunteer Since</span>
                        <span class="text-gray-900 text-sm"><?php echo e($volunteer->created_at->format('M d, Y')); ?></span>
                    </div>
                    
                    <div class="flex justify-between items-center py-3">
                        <span class="font-medium text-gray-700 text-sm">User Roles</span>
                        <div class="flex flex-wrap gap-2">
                            <?php if($volunteer->user->roles && $volunteer->user->roles->count() > 0): ?>
                                <?php $__currentLoopData = $volunteer->user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $variant = match($role->role_name) {
                                            'Volunteer' => 'volunteer',
                                            'Admin' => 'admin',
                                            'Program Coordinator' => 'program-coordinator',
                                            'Financial Coordinator' => 'financial-coordinator',
                                            'Content Manager' => 'content-manager',
                                            'Member' => 'member',
                                            default => 'role'
                                        };
                                    ?>
                                    <?php if (isset($component)) { $__componentOriginala31a0527394ddcdc63fabbed2d94514c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala31a0527394ddcdc63fabbed2d94514c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.feedback-status.status-indicator','data' => ['label' => $role->role_name,'status' => $variant]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('feedback-status.status-indicator'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($role->role_name),'status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($variant)]); ?>
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
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <span class="text-gray-500 text-sm">No roles assigned</span>
                            <?php endif; ?>
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
    </div>

    
    <?php if($volunteer->member): ?>
        <?php if (isset($component)) { $__componentOriginal5047e3a08dc66ef13a024f32c8319cd0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5047e3a08dc66ef13a024f32c8319cd0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.overview.card','data' => ['title' => 'Member Information','icon' => 'bx-crown','variant' => 'bordered']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('overview.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Member Information','icon' => 'bx-crown','variant' => 'bordered']); ?>
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    
                    <div class="space-y-4">
                        
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="font-medium text-gray-700 text-sm">Membership Type</span>
                            <?php if (isset($component)) { $__componentOriginala31a0527394ddcdc63fabbed2d94514c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala31a0527394ddcdc63fabbed2d94514c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.feedback-status.status-indicator','data' => ['status' => $volunteer->member->membership_type === 'full_pledge' ? 'success' : 'info','label' => ucwords(str_replace('_', ' ', $volunteer->member->membership_type))]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('feedback-status.status-indicator'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($volunteer->member->membership_type === 'full_pledge' ? 'success' : 'info'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(ucwords(str_replace('_', ' ', $volunteer->member->membership_type)))]); ?>
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
                        
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="font-medium text-gray-700 text-sm">Membership Status</span>
                            <?php if (isset($component)) { $__componentOriginala31a0527394ddcdc63fabbed2d94514c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala31a0527394ddcdc63fabbed2d94514c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.feedback-status.status-indicator','data' => ['status' => $volunteer->member->membership_status,'label' => ucfirst($volunteer->member->membership_status)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('feedback-status.status-indicator'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($volunteer->member->membership_status),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(ucfirst($volunteer->member->membership_status))]); ?>
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
                        
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="font-medium text-gray-700 text-sm">Invitation Status</span>
                            <?php if (isset($component)) { $__componentOriginala31a0527394ddcdc63fabbed2d94514c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala31a0527394ddcdc63fabbed2d94514c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.feedback-status.status-indicator','data' => ['status' => $volunteer->member->invitation_status,'label' => ucfirst($volunteer->member->invitation_status)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('feedback-status.status-indicator'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($volunteer->member->invitation_status),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(ucfirst($volunteer->member->invitation_status))]); ?>
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

                    <div class="space-y-4">

                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="font-medium text-gray-700 text-sm">Start Date</span>
                            <span class="text-gray-900 text-sm">
                                <?php if($volunteer->member->start_date): ?>
                                    <?php echo e(\Carbon\Carbon::parse($volunteer->member->start_date)->format('M d, Y')); ?>

                                <?php else: ?>
                                    <span class="text-gray-500">Not specified</span>
                                <?php endif; ?>
                            </span>
                        </div>

                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="font-medium text-gray-700 text-sm">Invited At</span>
                            <span class="text-gray-900 text-sm">
                                <?php if($volunteer->member->invited_at): ?>
                                    <?php echo e(\Carbon\Carbon::parse($volunteer->member->invited_at)->format('M d, Y')); ?>

                                <?php else: ?>
                                    <span class="text-gray-500">Not specified</span>
                                <?php endif; ?>
                            </span>
                        </div>

                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="font-medium text-gray-700 text-sm">Invited By</span>
                            <span class="text-gray-900 text-sm">
                                <?php if($volunteer->member->invited_by): ?>
                                    <?php echo e(\App\Models\User::find($volunteer->member->invited_by)->name ?? 'Unknown'); ?>

                                <?php else: ?>
                                    <span class="text-gray-500">Not specified</span>
                                <?php endif; ?>
                            </span>
                        </div>
                    </div>
                </div>

                
                <?php if($volunteer->member->payments && $volunteer->member->payments->count() > 0): ?>
                    <div class="pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-semibold text-[#1a2235] mb-4 flex items-center">
                            <i class='bx bx-credit-card text-purple-600 mr-2'></i>
                            Payment Summary
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            
                            <div class="bg-gradient-to-br from-emerald-50 to-green-50 p-4 rounded-xl border border-emerald-200">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="text-sm text-emerald-700 font-medium">Total Payments</div>
                                        <div class="text-2xl font-bold text-emerald-800"><?php echo e($volunteer->member->payments->count()); ?></div>
                                    </div>
                                    <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                                        <i class='bx bx-receipt text-emerald-600'></i>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-4 rounded-xl border border-blue-200">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="text-sm text-blue-700 font-medium">Total Amount</div>
                                        <div class="text-2xl font-bold text-blue-800">₱<?php echo e(number_format($volunteer->member->payments->sum('amount'), 2)); ?></div>
                                    </div>
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i class='bx bx-money text-blue-600'></i>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gradient-to-br from-purple-50 to-violet-50 p-4 rounded-xl border border-purple-200">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="text-sm text-purple-700 font-medium">Latest Payment</div>
                                        <?php
                                            $latestPayment = $volunteer->member->payments->sortByDesc('payment_date')->first();
                                        ?>
                                        <div class="text-sm font-bold text-purple-800">
                                            <?php if($latestPayment): ?>
                                                <?php echo e(\Carbon\Carbon::parse($latestPayment->payment_date)->format('M d, Y')); ?>

                                            <?php else: ?>
                                                <span class="text-gray-500">None</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                        <i class='bx bx-calendar text-purple-600'></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
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
    <?php endif; ?>
</div><?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/volunteers/partials/overviewProfile.blade.php ENDPATH**/ ?>