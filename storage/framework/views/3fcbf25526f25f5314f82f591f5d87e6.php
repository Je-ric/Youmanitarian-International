<div class="p-6">
    <h1 class="text-2xl font-bold text-[#1a2235] mb-6">Programs & Attendance</h1>
    <?php if($volunteer->programs->isNotEmpty()): ?>
    
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            <?php $__currentLoopData = $volunteer->programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $attendance = $volunteer->attendanceLogs->where('program_id', $program->id)->first();
                    $hasAttendance = $attendance !== null;
                ?>
                
                <div class="bg-gradient-to-br from-white to-slate-50 border border-gray-200 rounded-xl p-5 hover:shadow-lg transition-all duration-200">
                
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg font-semibold text-[#1a2235] truncate">
                                <?php echo e($program->title); ?>

                            </h3>

                            <div class="flex items-center gap-2 mt-1">
                                <?php if (isset($component)) { $__componentOriginaldb789b1f3ae90a14ac4fd71bcdfeda69 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldb789b1f3ae90a14ac4fd71bcdfeda69 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.feedback-status.programProgress','data' => ['program' => $program]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('feedback-status.programProgress'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['program' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($program)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldb789b1f3ae90a14ac4fd71bcdfeda69)): ?>
<?php $attributes = $__attributesOriginaldb789b1f3ae90a14ac4fd71bcdfeda69; ?>
<?php unset($__attributesOriginaldb789b1f3ae90a14ac4fd71bcdfeda69); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldb789b1f3ae90a14ac4fd71bcdfeda69)): ?>
<?php $component = $__componentOriginaldb789b1f3ae90a14ac4fd71bcdfeda69; ?>
<?php unset($__componentOriginaldb789b1f3ae90a14ac4fd71bcdfeda69); ?>
<?php endif; ?>
                                <?php if($hasAttendance): ?>
                                    <?php if (isset($component)) { $__componentOriginala31a0527394ddcdc63fabbed2d94514c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala31a0527394ddcdc63fabbed2d94514c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.feedback-status.status-indicator','data' => ['status' => $attendance->approval_status,'label' => ucfirst($attendance->approval_status)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('feedback-status.status-indicator'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($attendance->approval_status),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(ucfirst($attendance->approval_status))]); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.feedback-status.status-indicator','data' => ['status' => 'warning','label' => 'No Attendance']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('feedback-status.status-indicator'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => 'warning','label' => 'No Attendance']); ?>
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
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3 mb-4">

                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-sm font-medium text-gray-600">Date</span>
                            <span class="text-sm text-gray-900 font-medium"><?php echo e(\Carbon\Carbon::parse($program->date)->format('M d, Y')); ?></span>
                        </div>
                        <?php if($hasAttendance): ?>

                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-600">Time In/Out</span>
                                <span class="text-sm text-gray-900 font-medium">
                                    <?php echo e(\Carbon\Carbon::parse($attendance->clock_in)->format('h:i A')); ?>

                                    <?php if($attendance->clock_out): ?>
                                        - <?php echo e(\Carbon\Carbon::parse($attendance->clock_out)->format('h:i A')); ?>

                                    <?php else: ?>
                                        - <span class="text-amber-600">Still Clocked In</span>
                                    <?php endif; ?>
                                </span>
                            </div>

                            <div class="flex justify-between items-center py-2">
                                <span class="text-sm font-medium text-gray-600">Total Hours</span>
                                <?php if($attendance->clock_out): ?>
                                    <?php
                                        $diff = \Carbon\Carbon::parse($attendance->clock_in)->diff(\Carbon\Carbon::parse($attendance->clock_out));
                                    ?>
                                    <span class="text-sm font-bold text-[#1a2235]"><?php echo e($diff->h); ?>h <?php echo e($diff->i); ?>m</span>
                                <?php else: ?>
                                    <span class="text-sm text-amber-600 font-medium">Ongoing</span>
                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <?php if (isset($component)) { $__componentOriginal879d72999cba16bc59a433a99b6fe39e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal879d72999cba16bc59a433a99b6fe39e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.feedback-status.alert','data' => ['variant' => 'warning','icon' => 'bx bx-time','message' => 'No attendance record yet']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('feedback-status.alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'warning','icon' => 'bx bx-time','message' => 'No attendance record yet']); ?>
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
                        <?php endif; ?>
                    </div>

                    <div class="flex gap-2">
                        <button
                            @click="openModal(<?php echo e($program->id); ?>)"
                            class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                            <i class='bx bx-show mr-1'></i>
                            View Details
                        </button>
                        <?php if($hasAttendance): ?>
                            
                            <button
                                onclick="document.getElementById('attendanceModal_<?php echo e($volunteer->id); ?>_<?php echo e($program->id); ?>').showModal()"
                                class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                <i class='bx bx-clipboard-check mr-1'></i>
                                Review
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php else: ?>
        <?php if (isset($component)) { $__componentOriginal879d72999cba16bc59a433a99b6fe39e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal879d72999cba16bc59a433a99b6fe39e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.feedback-status.alert','data' => ['variant' => 'info','icon' => 'bx bx-calendar','message' => 'This volunteer hasn\'t joined any programs yet.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('feedback-status.alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'info','icon' => 'bx bx-calendar','message' => 'This volunteer hasn\'t joined any programs yet.']); ?>
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
    <?php endif; ?>
</div>

<?php $__currentLoopData = $volunteer->programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php echo $__env->make('programs.modals.program-modal', ['program' => $program], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


<?php $__currentLoopData = $volunteer->attendanceLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if($log->program): ?>
        <?php
            $programLogs = $volunteer->attendanceLogs->where('program_id', $log->program->id);
        ?>
        <?php echo $__env->make('programs_volunteers.modals.attendanceApproval', [
            'volunteer' => $volunteer, 
            'volunteerLogs' => $programLogs,
            'program' => $log->program,
            'readOnly' => true,
            'modalId' => 'attendanceModal_' . $volunteer->id . '_' . $log->program->id
        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> <?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/volunteers/partials/programsProfile.blade.php ENDPATH**/ ?>