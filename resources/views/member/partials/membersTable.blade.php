<x-table.table containerClass="overflow-x-auto" tableClass="min-w-full">
    <x-table.thead>
        <x-table.tr :hover="false">
            <x-table.th class="w-12 text-center">Photo</x-table.th>
            <x-table.th class="w-10 text-center">#</x-table.th>
            <x-table.th>Name</x-table.th>
            <x-table.th>Membership Type</x-table.th>
            <x-table.th>Start Date</x-table.th>
            <x-table.th>Status</x-table.th>
            <x-table.th>Actions</x-table.th>
        </x-table.tr>
    </x-table.thead>
    <x-table.tbody>
        @forelse($members as $member)
            <x-table.tr>
                <x-table.td class="w-12 text-center">
                    @if($member->profile_photo_url)
                        <img src="{{ $member->profile_photo_url }}" alt="{{ $member->user->name }}" class="rounded-full size-10 object-cover mx-auto">
                    @else
                        <span class="size-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-400">N/A</span>
                    @endif
                </x-table.td>
                <x-table.td
                    class="w-10 text-center text-gray-500">{{ $loop->iteration + ($members->currentPage() - 1) * $members->perPage() }}</x-table.td>
                <x-table.td>
                    <div class="text-sm font-bold text-gray-800">{{ $member->user->name }}</div>
                    <div class="text-sm text-gray-500">{{ $member->user->email }}</div>
                </x-table.td>
                <x-table.td>
                    <div class="text-sm text-gray-900">{{ ucfirst(str_replace('_', ' ', $member->membership_type)) }}</div>
                </x-table.td>
                <x-table.td>
                    <div class="text-sm text-gray-900">
                        {{ $member->start_date ? $member->start_date->format('M d, Y') : 'N/A' }}</div>
                </x-table.td>
                <x-table.td>
                    <span
                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $member->membership_status === 'active' ? 'bg-green-100 text-green-800' :
            ($member->invitation_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                        {{ $member->invitation_status === 'pending' ? 'Pending Invitation' : ucfirst($member->membership_status) }}
                    </span>
                </x-table.td>
                <x-table.td>
                    <div class="flex space-x-2">
                        @if($member->invitation_status === 'pending')
                            <form action="{{ route('members.resend-invitation', $member) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-indigo-600 hover:text-indigo-900">
                                    <i class='bx bx-refresh'></i> Resend Invitation
                                </button>
                            </form>
                        @endif
                        @if($member->membership_status === 'inactive' && $member->invitation_status !== 'pending')
                            <form action="{{ route('members.status', $member) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="membership_status" value="active">
                                <button type="submit" class="text-green-600 hover:text-green-900">
                                    <i class='bx bx-check'></i> Activate
                                </button>
                            </form>
                        @endif
                        @if($member->membership_status === 'active')
                            <form action="{{ route('members.status', $member) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="membership_status" value="inactive">
                                <button type="submit" class="text-red-600 hover:text-red-900">
                                    <i class='bx bx-x'></i> Deactivate
                                </button>
                            </form>
                        @endif
                    </div>
                </x-table.td>
            </x-table.tr>
        @empty
            <tr>
                <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                    No members found
                </td>
            </tr>
        @endforelse
    </x-table.tbody>
</x-table.table>
<div class="px-6 py-4 border-t border-gray-200">
    {{ $members->links() }}
</div>