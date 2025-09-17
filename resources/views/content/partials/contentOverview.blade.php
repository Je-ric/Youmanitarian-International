@php
    $ov = $overview ?? [];
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
    <x-overview.card title="Views" icon="bx-show" variant="elevated">
        <x-slot name="slot">
            <div class="flex items-end justify-between">
                <div>
                    <div class="text-sm text-gray-500">Total</div>
                    <div class="text-2xl font-semibold">{{ number_format($ov['totalViews'] ?? 0) }}</div>
                </div>
                <div class="text-right">
                    <div class="text-sm text-gray-500">Last 7 days</div>
                    <div class="text-xl font-semibold">{{ is_null($ov['viewsLast7'] ?? null) ? '—' : number_format($ov['viewsLast7']) }}</div>
                </div>
            </div>
        </x-slot>
    </x-overview.card>

    <x-overview.card title="Reactions" icon="bx-heart" variant="elevated">
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

    <x-overview.card title="Comments" icon="bx-comment" variant="elevated">
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

    <x-overview.card title="Bookmarks" icon="bx-bookmark" variant="elevated">
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
            <div class="flex items-center gap-3">
                <x-feedback-status.status-indicator :status="($ov['status'] ?? 'draft')" :label="ucfirst($ov['status'] ?? 'draft')" />
                <x-feedback-status.status-indicator :status="($ov['approval'] ?? 'draft')" :label="ucfirst(str_replace('_',' ', ($ov['approval'] ?? 'draft')))" />
                @if(!empty($ov['publishedAt']))
                    <div class="ml-auto text-sm text-gray-600">
                        Published: {{ \Illuminate\Support\Carbon::parse($ov['publishedAt'])->setTimezone('Asia/Manila')->format('M d, Y h:i A') }}
                    </div>
                @endif
            </div>
        </x-slot>
    </x-overview.card>

    <x-overview.card title="Engagement Settings" icon="bx-cog" variant="bordered">
        <x-slot name="slot">
            <div class="grid grid-cols-2 gap-3 text-sm">
                <div class="flex items-center gap-2"><i class='bx bx-heart text-gray-500'></i> Likes: {{ ($content->enable_likes ?? true) ? 'Enabled' : 'Disabled' }}</div>
                <div class="flex items-center gap-2"><i class='bx bx-comment text-gray-500'></i> Comments: {{ ($content->enable_comments ?? true) ? 'Enabled' : 'Disabled' }}</div>
                <div class="flex items-center gap-2"><i class='bx bx-bookmark text-gray-500'></i> Bookmarks: {{ ($content->enable_bookmark ?? true) ? 'Enabled' : 'Disabled' }}</div>
                <div class="flex items-center gap-2"><i class='bx bx-star text-gray-500'></i> Featured: {{ ($content->is_featured ?? false) ? 'Yes' : 'No' }}</div>
            </div>
        </x-slot>
    </x-overview.card>

    <x-overview.card title="Metadata" icon="bx-info-circle" variant="bordered">
        <x-slot name="slot">
            <div class="space-y-1 text-sm text-gray-700">
                <div><span class="text-gray-500">Type:</span> {{ ucfirst($content->content_type ?? '—') }}</div>
                <div><span class="text-gray-500">Slug:</span> {{ $content->slug ?? '—' }}</div>
                <div><span class="text-gray-500">Author:</span> {{ optional($content->user)->name ?? '—' }}</div>
                <div><span class="text-gray-500">Created:</span> {{ optional($content->created_at)->setTimezone('Asia/Manila')->format('M d, Y h:i A') }}</div>
                <div><span class="text-gray-500">Updated:</span> {{ optional($content->updated_at)->setTimezone('Asia/Manila')->format('M d, Y h:i A') }}</div>
            </div>
        </x-slot>
    </x-overview.card>
</div>
