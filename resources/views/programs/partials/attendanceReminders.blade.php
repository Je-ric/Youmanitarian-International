<section class="max-w-7xl mx-auto px-4 py-6 sm:px-6 sm:py-8 bg-yellow-50 rounded-2xl border-2 border-amber-400 mt-6">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- Reminders --}}
        <div>
            <h2 class="text-gray-800 text-lg font-bold mb-4 flex items-center">
                <i class='bx bx-bell text-amber-500 mr-2'></i>
                Important Reminders
            </h2>
            <ul class="space-y-2 text-gray-800 text-sm leading-relaxed">
                <li class="flex items-start gap-2">
                    <i class='bx bx-check text-[#ffb51b] mt-0.5'></i>
                    Volunteers can only Clock In once and Clock Out once per program.
                </li>
                <li class="flex items-start gap-2">
                    <i class='bx bx-check text-[#ffb51b] mt-0.5'></i>
                    Attendance will only be accessible once the program has started.
                </li>
                <li class="flex items-start gap-2">
                    <i class='bx bx-check text-[#ffb51b] mt-0.5'></i>
                    After Clock In, the Clock In button becomes disabled.
                </li>
                <li class="flex items-start gap-2">
                    <i class='bx bx-check text-[#ffb51b] mt-0.5'></i>
                    After Clock Out, the Clock Out button becomes disabled.
                </li>
                <li class="flex items-start gap-2">
                    <i class='bx bx-check text-[#ffb51b] mt-0.5'></i>
                    You must Clock In first before you're allowed to upload attendance proof.
                </li>
                <li class="flex items-start gap-2">
                    <i class='bx bx-check text-[#ffb51b] mt-0.5'></i>
                    You can only submit a rating and review after the program has ended.
                </li>
            </ul>
        </div>

        {{-- Missing Attendance --}}
        <div>
            <h3 class="text-[#1a2235] font-semibold mb-4 flex items-center">
                <i class='bx bx-support text-[#ffb51b] mr-2'></i>
                Need Help? (Missing Attendance)
            </h3>

            <ul class="space-y-2 text-gray-800 text-sm leading-relaxed">
                <li class="flex items-start gap-2">
                    <i class='bx bx-check text-[#ffb51b] mt-0.5'></i>
                    If you missed Clocking In or Clocking Out, please contact your program coordinator.
                </li>
                <li class="flex items-start gap-2">
                    <i class='bx bx-check text-[#ffb51b] mt-0.5'></i>
                    The coordinator can manually enter the missing attendance record for you.
                </li>
                <li class="flex items-start gap-2">
                    <i class='bx bx-check text-[#ffb51b] mt-0.5'></i>
                    Be sure to provide a reason when requesting manual attendance entry.
                </li>
            </ul>

            <div class="mt-6 p-4 bg-white rounded border border-amber-300">
                <p
                    class="text-center text-[#1a2235] text-sm font-medium leading-relaxed flex items-center justify-center gap-2">
                    <i class='bx bx-error-circle text-amber-500 text-lg'></i>
                    Attendance is taken seriously.<br>
                    It serves as official documentation of your participation and will be used as one of the primary
                    bases for recognizing your contribution to the program.
                </p>
            </div>

        </div>
    </div>
</section>