
        <dialog id="attendanceModal_{{ $volunteer->id }}" class="modal">
                                <form method="POST" action="#" class="modal-box max-w-3xl p-8 rounded-[20px] bg-white relative"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <h3 class="text-gray-800 text-2xl font-bold font-['Poppins'] mb-8 text-center">
                                        Review Attendance - {{ $volunteer->user->name }}
                                    </h3>

                                    @foreach ($volunteerLogs as $log)
                                        <div class="mb-8 border border-gray-300 rounded-[12px] p-6 bg-white shadow-sm">
                                            <div class="flex justify-between mb-4 flex-wrap gap-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="relative w-7 h-7">
                                                        <div
                                                            class="absolute left-[5px] top-[5px] w-5 h-5 rounded-full outline outline-[2.5px] outline-gray-500">
                                                        </div>
                                                        <div
                                                            class="absolute left-[15px] top-[10.6px] w-1.5 h-1 outline outline-[2.5px] outline-offset-[-1.25px] outline-gray-500">
                                                        </div>
                                                    </div>
                                                    <p class="text-black text-xl font-medium font-['Poppins'] tracking-tight">Time In:</p>
                                                    <p class="text-black text-xl font-normal font-['Poppins'] tracking-tight">
                                                        {{ \Carbon\Carbon::parse($log->clock_in)->format('M d, Y h:i A') }}
                                                    </p>
                                                </div>

                                                <div class="flex items-center gap-3">
                                                    <p class="text-black text-xl font-medium font-['Poppins'] tracking-tight">Time Out:</p>
                                                    <p class="text-black text-xl font-normal font-['Poppins'] tracking-tight">
                                                        @if ($log->clock_out)
                                                            {{ \Carbon\Carbon::parse($log->clock_out)->format('M d, Y h:i A') }}
                                                        @else
                                                            <span class="text-red-500">Still Clocked In</span>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>

                                            <label for="notes_{{ $log->id }}"
                                                class="block text-black font-medium mb-2 font-['Poppins'] tracking-tight">
                                                Notes (optional):
                                            </label>

                                            <textarea id="notes_{{ $log->id }}" name="notes" rows="5"
                                                class="w-full px-4 py-2.5 bg-white rounded-xl outline outline-[1.4px] outline-stone-300 resize-none text-zinc-700 text-base font-medium font-['Montserrat'] tracking-tight mb-4"
                                                placeholder="Add any comments about this attendance record...">{{ old('notes', $log->notes) }}</textarea>

                                            <div class="flex justify-between items-center flex-wrap gap-4">
                                                <div>
                                                    @if ($log->proof_image)
                                                        <img src="{{ asset('storage/' . $log->proof_image) }}" alt="Proof of Attendance"
                                                            class="w-64 h-auto border rounded shadow mb-2" />

                                                        <a href="{{ asset('storage/' . $log->proof_image) }}" target="_blank"
                                                            class="underline text-blue-600 hover:text-blue-800 font-['Poppins']">
                                                            View Full Size
                                                        </a>
                                                    @else
                                                        <p class="text-gray-500 font-['Poppins']">No proof image uploaded</p>
                                                    @endif
                                                </div>


                                                <div class="flex gap-4 flex-wrap">
                                                    <button formaction="{{ route('attendance.approve', $log->id) }}" formmethod="POST"
                                                        class="w-64 h-14 px-5 bg-emerald-50 rounded-md outline outline-1 outline-green-500 flex justify-center items-center gap-2 text-green-600 font-medium font-['Inter'] cursor-pointer hover:bg-green-100 transition">
                                                        <i class='bx bx-check-circle text-green-600 text-xl'></i> Approve
                                                    </button>

                                                    <button formaction="{{ route('attendance.reject', $log->id) }}" formmethod="POST"
                                                        class="w-64 h-14 px-5 bg-rose-100 rounded-md outline outline-1 outline-red-600 flex justify-center items-center gap-2 text-red-600 font-medium font-['Inter'] cursor-pointer hover:bg-red-200 transition">
                                                        <i class='bx bx-x-circle text-red-600 text-xl'></i> Reject
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="modal-action mt-4 text-center">
                                        <button type="button"
                                            class="btn bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-3 rounded-md font-semibold"
                                            onclick="document.getElementById('attendanceModal_{{ $volunteer->id }}').close()">
                                            Close
                                        </button>
                                    </div>
                                </form>
                            </dialog> 