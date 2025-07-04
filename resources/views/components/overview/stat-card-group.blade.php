<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
    {{ $slot }}
</div>

{{--
Usage: <x-overview.stat-card-group>
            <x-overview.stat-card icon="bx-users" title="Total Users" value="1,234" />
            <x-overview.stat-card icon="bx-dollar" title="Revenue" value="$12,345" />
            <x-overview.stat-card icon="bx-chart" title="Growth" value="23%" />
            <x-overview.stat-card icon="bx-trending-up" title="Sales" value="456" />
        </x-overview.stat-card-group>

Used in:
- resources/views/dashboard.blade.php
- resources/views/finance/donations.blade.php
- resources/views/finance/membership_payments.blade.php
- resources/views/programs/index.blade.php
- resources/views/volunteers/index.blade.php
--}} 