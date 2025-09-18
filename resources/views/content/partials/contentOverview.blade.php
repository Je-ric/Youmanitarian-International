@php
    $ov = $overview ?? [];
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
    <x-overview.card title="Views" icon="bx-show" variant="midnight-header">
        <x-slot name="slot">
            <div class="flex items-end justify-between">
                <div>
                    <div class="text-sm text-gray-500">Total</div>
                    <div class="text-2xl font-semibold">{{ number_format($ov['totalViews'] ?? 0) }}</div>
                </div>
                <div class="text-right">
                    <div class="text-sm text-gray-500">Last 7 days</div>
                    <div class="text-xl font-semibold">
                        {{ is_null($ov['viewsLast7'] ?? null) ? '—' : number_format($ov['viewsLast7']) }}</div>
                </div>
            </div>
        </x-slot>
    </x-overview.card>

    <x-overview.card title="Reactions" icon="bx-heart" variant="midnight-header">
        <x-slot name="slot">
            <div class="flex items-end justify-between">
                <div>
                    <div class="text-sm text-gray-500">Total Likes</div>
                    <div class="text-2xl font-semibold">{{ number_format($ov['likesTotal'] ?? 0) }}</div>
                </div>
                <div class="text-right">
                    <div class="text-sm text-gray-500">Last 7 days</div>
                    <div class="text-xl font-semibold">{{ number_format($ov['likesLast7'] ?? 0) }}</div>
                </div>
            </div>
        </x-slot>
    </x-overview.card>

    <x-overview.card title="Comments" icon="bx-comment" variant="midnight-header">
        <x-slot name="slot">
            <div class="flex items-end justify-between">
                <div>
                    <div class="text-sm text-gray-500">Total</div>
                    <div class="text-2xl font-semibold">{{ number_format($ov['commentsTotal'] ?? 0) }}</div>
                </div>
                <div class="text-right">
                    <div class="text-sm text-gray-500">Last 7 days</div>
                    <div class="text-xl font-semibold">{{ number_format($ov['commentsLast7'] ?? 0) }}</div>
                </div>
            </div>
        </x-slot>
    </x-overview.card>

    <x-overview.card title="Bookmarks" icon="bx-bookmark" variant="midnight-header">
        <x-slot name="slot">
            <div class="flex items-end justify-between">
                <div>
                    <div class="text-sm text-gray-500">Total</div>
                    <div class="text-2xl font-semibold">
                        {{ is_null($ov['bookmarksTotal'] ?? null) ? '—' : number_format($ov['bookmarksTotal']) }}
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-sm text-gray-500">Last 7 days</div>
                    <div class="text-xl font-semibold">
                        {{ is_null($ov['bookmarksLast7'] ?? null) ? '—' : number_format($ov['bookmarksLast7']) }}
                    </div>
                </div>
            </div>
        </x-slot>
    </x-overview.card>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mt-6">
    <x-overview.card title="Status" icon="bx-badge-check" variant="bordered">
        <x-slot name="slot">
            <div class="flex flex-wrap items-center gap-4 text-sm">
                <div class="flex items-center gap-2">
                    <span class="font-medium">Content Status:</span>
                    <x-feedback-status.status-indicator :status="$ov['status'] ?? 'draft'" :label="ucfirst($ov['status'] ?? 'draft')" />
                </div>
                <br>
                <div class="flex items-center gap-2">
                    <span class="font-medium">Approval Status:</span>
                    <x-feedback-status.status-indicator :status="$ov['approval'] ?? 'draft'" :label="ucfirst(str_replace('_', ' ', $ov['approval'] ?? 'draft'))" />
                </div>
                <br><br>
                @if (!empty($ov['publishedAt']))
                    <div class="flex items-center gap-2">
                        <span class="font-medium">Published:</span>
                        <span class="font-semibold text-gray-700">
                            {{ \Illuminate\Support\Carbon::parse($ov['publishedAt'])->setTimezone('Asia/Manila')->format('M d, Y (h:i A)') }}
                        </span>
                    </div>
                @endif
            </div>
        </x-slot>
    </x-overview.card>

    <x-overview.card title="Engagement Settings" icon="bx-cog" variant="bordered">
        <x-slot name="slot">
            <div class="grid grid-cols-2 gap-3 text-sm">
                <div class="flex items-center gap-2">
                    <i class='bx bx-heart text-red-500'></i>
                    <span class="font-medium">Likes:</span>
                    <span
                        class="{{ $content->enable_likes ?? true ? 'text-green-600 font-semibold' : 'text-gray-500' }}">
                        {{ $content->enable_likes ?? true ? 'Enabled' : 'Disabled' }}
                    </span>
                </div>
                <div class="flex items-center gap-2">
                    <i class='bx bx-comment text-blue-500'></i>
                    <span class="font-medium">Comments:</span>
                    <span
                        class="{{ $content->enable_comments ?? true ? 'text-green-600 font-semibold' : 'text-gray-500' }}">
                        {{ $content->enable_comments ?? true ? 'Enabled' : 'Disabled' }}
                    </span>
                </div>
                <div class="flex items-center gap-2">
                    <i class='bx bx-bookmark text-yellow-500'></i>
                    <span class="font-medium">Bookmarks:</span>
                    <span
                        class="{{ $content->enable_bookmark ?? true ? 'text-green-600 font-semibold' : 'text-gray-500' }}">
                        {{ $content->enable_bookmark ?? true ? 'Enabled' : 'Disabled' }}
                    </span>
                </div>
                <div class="flex items-center gap-2">
                    <i class='bx bx-star text-purple-500'></i>
                    <span class="font-medium">Featured:</span>
                    <span
                        class="{{ $content->is_featured ?? false ? 'text-green-600 font-semibold' : 'text-gray-500' }}">
                        {{ $content->is_featured ?? false ? 'Yes' : 'No' }}
                    </span>
                </div>
            </div>

        </x-slot>
    </x-overview.card>

    <x-overview.card title="Metadata" icon="bx-info-circle" variant="bordered">
        <x-slot name="slot">
            <div class="space-y-2 text-sm">
                <div>
                    <span class="font-medium">Type:</span>
                    <span class="text-gray-800">{{ ucfirst($content->content_type ?? '—') }}</span>
                </div>
                <div>
                    <span class="font-medium">Slug:</span>
                    <span class="text-gray-800">{{ $content->slug ?? '—' }}</span>
                </div>
                <div>
                    <span class="font-medium">Author:</span>
                    <span class="text-gray-800">{{ optional($content->user)->name ?? '—' }}</span>
                </div>
                <div>
                    <span class="font-medium">Created:</span>
                    <span
                        class="text-gray-800">{{ optional($content->created_at)->setTimezone('Asia/Manila')->format('M d, Y (h:i A)') }}</span>
                </div>
                <div>
                    <span class="font-medium">Updated:</span>
                    <span
                        class="text-gray-800">{{ optional($content->updated_at)->setTimezone('Asia/Manila')->format('M d, Y (h:i A)') }}</span>
                </div>
            </div>

        </x-slot>
    </x-overview.card>
</div>
