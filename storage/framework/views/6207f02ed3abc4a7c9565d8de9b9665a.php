

<?php if (isset($component)) { $__componentOriginal6eb288a80e68f6f6b1755bcc863df159 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6eb288a80e68f6f6b1755bcc863df159 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal.dialog','data' => ['id' => 'modal_'.e($program->id).'','maxWidth' => 'max-w-6xl','width' => 'w-11/12','maxHeight' => 'max-h-[90vh]']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal.dialog'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'modal_'.e($program->id).'','maxWidth' => 'max-w-6xl','width' => 'w-11/12','maxHeight' => 'max-h-[90vh]']); ?>
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
            <h2 id="modal-title-<?php echo e($program->id); ?>" class="text-2xl font-bold text-slate-900 tracking-tight">
                <?php echo e($program->title); ?>

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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal.body','data' => ['padded' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal.body'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['padded' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
            <div class="flex flex-col lg:flex-row flex-1 min-h-0 overflow-hidden">
                
                <div class="lg:w-2/3 w-full p-6 space-y-6 overflow-y-auto">

                    <article>
                        <h3 class="text-lg font-semibold text-slate-900 mb-3 flex items-center gap-2">
                            <i class='bx bx-book-open text-slate-600'></i>
                            Description
                        </h3>
                        <div
                            class="bg-slate-50 border border-slate-200 rounded-lg p-4 max-h-36 overflow-y-auto custom-scrollbar-gold">
                            <p class="text-slate-700 leading-relaxed">
                                <?php echo e($program->description); ?>

                            </p>
                        </div>
                    </article>

                    
                    <div class="border-t border-slate-200 pt-6">
                        <h4 class="text-lg font-semibold text-slate-900 mb-3 flex items-center gap-2">
                            <i class='bx bx-user-circle text-slate-600'></i>
                            Program Coordinator
                        </h4>
                        <div
                            class="flex items-center space-x-4 p-4 border border-slate-200 rounded-lg hover:border-blue-200 transition-colors duration-200">
                            <div class="relative">
                                <img src="https://images.pexels.com/photos/2379004/pexels-photo-2379004.jpeg?auto=compress&cs=tinysrgb&w=150&h=150&fit=crop"
                                    alt="Coordinator" class="rounded-lg w-16 h-16 object-cover border-2 border-slate-300" />
                                <div
                                    class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 border-2 border-white rounded-full">
                                </div>
                            </div>
                            <div>
                                <div class="text-lg font-semibold text-slate-900"><?php echo e($program->creator->name); ?></div>
                                <div class="text-slate-600 text-sm flex items-center gap-1">
                                    <i class='bx bx-check-circle text-green-500'></i>
                                    Program Coordinator
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <?php
                        $user = Auth::user();
                        $volunteer = $user?->volunteer;
                        $alreadyJoined = false;

                        if ($user && $user->hasRole('Volunteer') && $volunteer) {
                            $alreadyJoined = $program->volunteers->contains($volunteer->id);
                        }

                        $isCoordinator = Auth::id() === $program->created_by;
                    ?>

                    <?php if(Auth::check() && Auth::user()->hasRole('Volunteer') && !$isCoordinator): ?>
                        <?php
                            $currentVolunteers = $program->volunteers->count();
                            $volunteer = Auth::user()->volunteer;
                            $alreadyJoined = $program->volunteers->contains($volunteer?->id ?? 0);

                            // Check if the volunteer has any task assignments for this program
                            $hasTasks = $volunteer ? $volunteer->taskAssignments()
                                ->whereHas('task', function ($query) use ($program) {
                                    $query->where('program_id', $program->id);
                                })->exists() : false;
                        ?>

                        <div class="border-t border-slate-200 pt-6">
                            <?php if($program->progress_status === 'done'): ?>
                                <?php if (isset($component)) { $__componentOriginal879d72999cba16bc59a433a99b6fe39e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal879d72999cba16bc59a433a99b6fe39e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.feedback-status.alert','data' => ['type' => 'success','icon' => 'bx bx-check-circle','message' => 'This program is already done.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('feedback-status.alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'success','icon' => 'bx bx-check-circle','message' => 'This program is already done.']); ?>
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
                            <?php elseif($currentVolunteers >= $program->volunteer_count): ?>
                                <?php if (isset($component)) { $__componentOriginal879d72999cba16bc59a433a99b6fe39e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal879d72999cba16bc59a433a99b6fe39e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.feedback-status.alert','data' => ['type' => 'error','icon' => 'bx bx-error-circle','message' => 'All volunteer slots are filled, but you\'re welcome to join as a guest, viewer, or supporter!']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('feedback-status.alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'error','icon' => 'bx bx-error-circle','message' => 'All volunteer slots are filled, but you\'re welcome to join as a guest, viewer, or supporter!']); ?>
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
                            <?php elseif($alreadyJoined): ?>
                                <div class="space-y-4">
                                    <?php if (isset($component)) { $__componentOriginal879d72999cba16bc59a433a99b6fe39e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal879d72999cba16bc59a433a99b6fe39e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.feedback-status.alert','data' => ['type' => 'success','icon' => 'bx bx-check-circle','message' => 'You are already joined in this program.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('feedback-status.alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'success','icon' => 'bx bx-check-circle','message' => 'You are already joined in this program.']); ?>
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

                                    <?php if($program->progress_status === 'incoming' && !$hasTasks): ?>
                                        <form action="<?php echo e(route('programs.leave', [$program->id, $volunteer->id])); ?>" method="POST"
                                            onsubmit="return confirm('Are you sure you want to leave this program?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit"
                                                class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                                                <i class='bx bx-log-out'></i>
                                                Leave Program
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <?php if($hasTasks): ?>
                                            <?php if (isset($component)) { $__componentOriginal879d72999cba16bc59a433a99b6fe39e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal879d72999cba16bc59a433a99b6fe39e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.feedback-status.alert','data' => ['type' => 'error','icon' => 'bx bx-task','message' => 'You cannot leave this program because you have assigned tasks.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('feedback-status.alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'error','icon' => 'bx bx-task','message' => 'You cannot leave this program because you have assigned tasks.']); ?>
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
                                        <?php elseif($program->progress_status !== 'incoming'): ?>
                                            <?php if (isset($component)) { $__componentOriginal879d72999cba16bc59a433a99b6fe39e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal879d72999cba16bc59a433a99b6fe39e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.feedback-status.alert','data' => ['type' => 'info','icon' => 'bx bx-lock','message' => 'You cannot leave this program because it is no longer in incoming status.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('feedback-status.alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'info','icon' => 'bx bx-lock','message' => 'You cannot leave this program because it is no longer in incoming status.']); ?>
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
                                    <?php endif; ?>
                                </div>
                            <?php else: ?>
                                <form action="<?php echo e(route('programs.join', $program->id)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit"
                                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                                        <i class='bx bx-user-plus'></i>
                                        Join Program
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    <?php elseif(!Auth::check()): ?>
                        <div class="border-t border-slate-200 pt-6">
                            <?php if (isset($component)) { $__componentOriginal879d72999cba16bc59a433a99b6fe39e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal879d72999cba16bc59a433a99b6fe39e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.feedback-status.alert','data' => ['type' => 'info','icon' => 'bx bx-info-circle','message' => 'Sign in to join or interact with this program.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('feedback-status.alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'info','icon' => 'bx bx-info-circle','message' => 'Sign in to join or interact with this program.']); ?>
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
                            <a href="<?php echo e(route('login')); ?>"
                               class="mt-3 inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg">
                                <i class='bx bx-log-in'></i>
                                Sign in
                            </a>
                        </div>
                    <?php endif; ?>

                </div>

                
                <aside class="lg:w-1/3 w-full bg-slate-50 border-l border-slate-200 p-6 space-y-5 overflow-y-auto">
                    <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2 pb-2 border-b border-slate-300">
                        <i class='bx bx-detail text-slate-600'></i>
                        Program Details
                    </h3>

                    <?php
                        $progressComponent = view('components.feedback-status.programProgress', ['program' => $program])->render();

                        $currentVolunteers = $program->volunteers->count();
                        // $progressPercentage = ($currentVolunteers / $program->volunteer_count) * 100;
                        $progressPercentage = ($program->volunteer_count > 0)
                            ? ($currentVolunteers / $program->volunteer_count) * 100
                            : 0;
                        $details = [
                            ['icon' => 'calendar', 'label' => 'Date', 'value' => \Carbon\Carbon::parse($program->date)->format('M d, Y')],
                            ['icon' => 'time', 'label' => 'Time', 'value' => \Carbon\Carbon::parse($program->start_time)->format('h:i A') . ' - ' . \Carbon\Carbon::parse($program->end_time)->format('h:i A')],
                            ['icon' => 'map-pin', 'label' => 'Location', 'value' => $program->location],
                            // ['icon' => 'group', 'label' => 'Volunteers Needed', 'value' => $program->volunteer_count]
                            [
                                'icon' => 'group',
                                'label' => 'Volunteers Needed',
                                'value' => new \Illuminate\Support\HtmlString('
                                                                        <div class="space-y-2">
                                                                            <div class="flex justify-between text-sm">
                                                                                <span class="text-slate-700">' . $currentVolunteers . ' / ' . $program->volunteer_count . ' volunteers</span>
                                                                                <span class="text-slate-600">' . round($progressPercentage) . '%</span>
                                                                            </div>
                                                                            <div class="w-full bg-slate-200 rounded-full h-2">
                                                                                <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: ' . min($progressPercentage, 100) . '%"></div>
                                                                            </div>
                                                                        </div>
                                                                    ')
                            ],

                            ['icon' => 'trending-up', 'label' => 'Progress', 'value' => $progressComponent]
                        ];
                    ?>

                    <?php $__currentLoopData = $details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div
                            class="bg-white p-4 border border-slate-200 rounded-lg hover:border-blue-200 transition-colors duration-200">
                            <div class="flex items-center gap-2 text-slate-600 text-sm mb-2">
                                <i class='bx bx-<?php echo e($detail['icon']); ?>'></i>
                                <span><?php echo e($detail['label']); ?></span>
                            </div>
                            
                            <p class="text-slate-900 font-medium text-sm"><?php echo $detail['value']; ?></p>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                </aside>
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
            <?php if (isset($component)) { $__componentOriginaled059d8d932fd09048df3e5a42bf4f05 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaled059d8d932fd09048df3e5a42bf4f05 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal.close-button','data' => ['modalId' => 'modal_' . $program->id]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal.close-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['modalId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('modal_' . $program->id)]); ?>
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

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 3px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    
    .custom-scrollbar {
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 #f1f5f9;
    }

    
    @media (max-width: 1024px) {
        .modal-box {
            max-width: 95vw;
        }
    }

    @media (max-width: 768px) {
        .modal-box {
            max-width: 98vw;
            margin: 1rem;
            max-height: 95vh;
        }

        .flex.flex-col.lg\\:flex-row {
            flex-direction: column;
        }

        .lg\\:w-2\\/3,
        .lg\\:w-1\\/3 {
            width: 100%;
        }

        .border-l.border-slate-200 {
            border-left: none;
            border-top: 1px solid #e2e8f0;
        }
    }

    @media (max-width: 480px) {
        .modal-box {
            max-width: 100vw;
            margin: 0.5rem;
            max-height: 98vh;
        }

        header .px-6 {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .p-6 {
            padding: 1rem;
        }

        footer .px-6 {
            padding-left: 1rem;
            padding-right: 1rem;
        }
    }
</style>
<?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/programs/modals/program-modal.blade.php ENDPATH**/ ?>