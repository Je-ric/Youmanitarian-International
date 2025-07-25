<x-modal.dialog id="statusGuideModal">
    <x-modal.header>
        <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Content Status Flow Guide</h2>
    </x-modal.header>
    <x-modal.body>
        <div class="overflow-x-auto w-full">
            <table class="min-w-[600px] w-full text-xs sm:text-sm text-left border border-gray-200 whitespace-normal">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-2 sm:px-4 py-2 border-b">Publishing Action</th>
                        <th class="px-2 sm:px-4 py-2 border-b">Content Status</th>
                        <th class="px-2 sm:px-4 py-2 border-b">Approval Status</th>
                        <th class="px-2 sm:px-4 py-2 border-b">Meaning/Stage</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="px-2 sm:px-4 py-2 border-b">Save as Draft</td>
                        <td class="px-2 sm:px-4 py-2 border-b">draft</td>
                        <td class="px-2 sm:px-4 py-2 border-b">draft</td>
                        <td class="px-2 sm:px-4 py-2 border-b">Saved as draft, not submitted</td>
                    </tr>
                    <tr>
                        <td class="px-2 sm:px-4 py-2 border-b">Submit for Approval</td>
                        <td class="px-2 sm:px-4 py-2 border-b">draft</td>
                        <td class="px-2 sm:px-4 py-2 border-b">submitted</td>
                        <td class="px-2 sm:px-4 py-2 border-b">Waiting for review</td>
                    </tr>
                    <tr>
                        <td class="px-2 sm:px-4 py-2 border-b">Publish Directly</td>
                        <td class="px-2 sm:px-4 py-2 border-b">published</td>
                        <td class="px-2 sm:px-4 py-2 border-b">approved</td>
                        <td class="px-2 sm:px-4 py-2 border-b">Published and approved</td>
                    </tr>
                    <tr>
                        <td class="px-2 sm:px-4 py-2 border-b">(Reviewer) Needs Revision</td>
                        <td class="px-2 sm:px-4 py-2 border-b">draft</td>
                        <td class="px-2 sm:px-4 py-2 border-b">needs_revision</td>
                        <td class="px-2 sm:px-4 py-2 border-b">Sent back for changes</td>
                    </tr>
                    <tr>
                        <td class="px-2 sm:px-4 py-2 border-b">(Reviewer) Rejected</td>
                        <td class="px-2 sm:px-4 py-2 border-b">draft</td>
                        <td class="px-2 sm:px-4 py-2 border-b">rejected</td>
                        <td class="px-2 sm:px-4 py-2 border-b">Rejected, not published</td>
                    </tr>
                    <tr>
                        <td class="px-2 sm:px-4 py-2 border-b">(Reviewer) Approve after Review</td>
                        <td class="px-2 sm:px-4 py-2 border-b">published</td>
                        <td class="px-2 sm:px-4 py-2 border-b">approved</td>
                        <td class="px-2 sm:px-4 py-2 border-b">Published after approval</td>
                    </tr>
                    <tr>
                        <td class="px-2 sm:px-4 py-2 border-b">Archive</td>
                        <td class="px-2 sm:px-4 py-2 border-b">archived</td>
                        <td class="px-2 sm:px-4 py-2 border-b">approved</td>
                        <td class="px-2 sm:px-4 py-2 border-b">Archived after being published</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="mt-4 text-xs text-gray-500">
            <p><b>Note:</b> Only valid combinations are possible from the form. This guide helps you understand what each action does in the publishing workflow.</p>
        </div>
    </x-modal.body>
    <x-modal.footer align="end">
        <x-modal.close-button :modalId="'statusGuideModal'" text="Close" />
    </x-modal.footer>
</x-modal.dialog>
