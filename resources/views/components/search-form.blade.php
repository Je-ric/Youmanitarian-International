{{-- @props([
    'search' => '',
    'dateFilter' => '',
    'sortBy' => 'created_at',
    'sortOrder' => 'desc',
    'showDateFilter' => false,
    'showSortOptions' => true,
    'sortOptions' => [
        'created_at' => 'Date Created',
        'updated_at' => 'Date Updated',
        'title' => 'Title',
        'name' => 'Name',
        'email' => 'Email',
        'start_date' => 'Start Date',
        'donation_date' => 'Donation Date',
        'date' => 'Date'
    ],
    'showPaymentMethod' => false,
    'paymentMethods' => [
        'Cash' => 'Cash',
        'Bank Transfer' => 'Bank Transfer',
        'Credit Card' => 'Credit Card',
        'PayPal' => 'PayPal',
        'Check' => 'Check'
    ],
    'showDateRange' => false
])

<div class="bg-white p-4 rounded-lg shadow-sm border mb-6">
    <form method="GET" class="space-y-4">
        <!-- Search Input -->
        <div class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input type="text"
                       id="search"
                       name="search"
                       value="{{ $search }}"
                       placeholder="Search by name, title, email..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            @if($showDateFilter)
            <div class="sm:w-48">
                <label for="date_filter" class="block text-sm font-medium text-gray-700 mb-1">Filter by Date</label>
                <input type="date"
                       id="date_filter"
                       name="date_filter"
                       value="{{ $dateFilter }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            @endif

            @if($showDateRange)
            <div class="sm:w-48">
                <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                <input type="date"
                       id="date_from"
                       name="date_from"
                       value="{{ request('date_from') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div class="sm:w-48">
                <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                <input type="date"
                       id="date_to"
                       name="date_to"
                       value="{{ request('date_to') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            @endif

            @if($showPaymentMethod)
            <div class="sm:w-48">
                <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-1">Payment Method</label>
                <select id="payment_method"
                        name="payment_method"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">All Methods</option>
                    @foreach($paymentMethods as $value => $label)
                        <option value="{{ $value }}" {{ request('payment_method') == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
            @endif
        </div>

        @if($showSortOptions)
        <div class="flex flex-col sm:flex-row gap-4">
            <div class="sm:w-48">
                <label for="sort_by" class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                <select id="sort_by"
                        name="sort_by"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @foreach($sortOptions as $value => $label)
                        <option value="{{ $value }}" {{ $sortBy == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="sm:w-48">
                <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
                <select id="sort_order"
                        name="sort_order"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="asc" {{ $sortOrder == 'asc' ? 'selected' : '' }}>Ascending</option>
                    <option value="desc" {{ $sortOrder == 'desc' ? 'selected' : '' }}>Descending</option>
                </select>
            </div>
        </div>
        @endif

        <!-- Preserve current tab -->
        @if(request('tab'))
            <input type="hidden" name="tab" value="{{ request('tab') }}">
        @endif

        <!-- Action Buttons -->
        <div class="flex gap-2">
            <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Search
            </button>
            <a href="{{ request()->url() }}"
               class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                Clear
            </a>
        </div>
    </form>
</div> --}}

@props([
    'search' => '',
    'dateFilter' => '',
    'sortBy' => 'created_at',
    'sortOrder' => 'desc',
    'showDateFilter' => false,
    'showSortOptions' => true,
    'sortOptions' => [
        'created_at' => 'Date Created',
        'updated_at' => 'Date Updated',
        'title' => 'Title',
        'name' => 'Name',
        'email' => 'Email',
        'start_date' => 'Start Date',
        'donation_date' => 'Donation Date',
        'date' => 'Date'
    ],
    'showPaymentMethod' => false,
    'paymentMethods' => [
        'Cash' => 'Cash',
        'Bank Transfer' => 'Bank Transfer',
        'Credit Card' => 'Credit Card',
        'PayPal' => 'PayPal'
    ],
    'showDateRange' => false,
    'showYear' => false,
    'year' => now()->year,
    'yearOptions' => range(2023,2030),
    // New: customization for search label and placeholder
    'searchPlaceholder' => 'Search...',
    'searchLabel' => 'Search',
    'searchLabelVariant' => null,
])

<!-- Redesigned with compact layout, Boxicons, and dashboard-consistent styling -->
<div class="bg-gradient-to-r from-slate-50 to-gray-50 border border-gray-200 rounded-xl p-4 mb-4">
    <form method="GET" class="space-y-3">
        <!-- Main Search Row -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-3 items-end">
            <!-- Search Input -->
            <div class="lg:col-span-4">
                <x-form.label for="search" :variant="$searchLabelVariant">{{ $searchLabel }}</x-form.label>
                <div class="relative">
                    <input type="text"
                           id="search"
                           name="search"
                           value="{{ $search }}"
                           placeholder="{{ $searchPlaceholder }}"
                           class="w-full pl-9 pr-3 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition-all duration-200">
                    <i class='bx bx-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400'></i>
                </div>
            </div>

            @if($showDateFilter)
            <!-- Date Filter -->
            <div class="lg:col-span-2">
                <label for="date_filter" class="block text-xs font-semibold text-gray-600 mb-1 uppercase tracking-wide">
                    <i class='bx bx-calendar text-sm mr-1'></i>Date
                </label>
                <input type="date"
                       id="date_filter"
                       name="date_filter"
                       value="{{ $dateFilter }}"
                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition-all duration-200">
            </div>
            @endif

            @if($showDateRange)
            <!-- Date Range -->
            <div class="lg:col-span-2">
                <label for="date_from" class="block text-xs font-semibold text-gray-600 mb-1 uppercase tracking-wide">
                    <i class='bx bx-calendar-event text-sm mr-1'></i>From
                </label>
                <input type="date"
                       id="date_from"
                       name="date_from"
                       value="{{ request('date_from') }}"
                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition-all duration-200">
            </div>
            <div class="lg:col-span-2">
                <label for="date_to" class="block text-xs font-semibold text-gray-600 mb-1 uppercase tracking-wide">
                    <i class='bx bx-calendar-check text-sm mr-1'></i>To
                </label>
                <input type="date"
                       id="date_to"
                       name="date_to"
                       value="{{ request('date_to') }}"
                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition-all duration-200">
            </div>
            @endif

            @if($showPaymentMethod)
            <!-- Payment Method -->
            <div class="lg:col-span-2">
                <label for="payment_method" class="block text-xs font-semibold text-gray-600 mb-1 uppercase tracking-wide">
                    <i class='bx bx-credit-card text-sm mr-1'></i>Payment
                </label>
                <select id="payment_method"
                        name="payment_method"
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition-all duration-200">
                    <option value="">All Methods</option>
                    @foreach($paymentMethods as $value => $label)
                        <option value="{{ $value }}" {{ request('payment_method') == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
            @endif

            @if($showSortOptions)
            <!-- Sort Options -->
            <div class="lg:col-span-2">
                <label for="sort_by" class="block text-xs font-semibold text-gray-600 mb-1 uppercase tracking-wide">
                    <i class='bx bx-sort text-sm mr-1'></i>Sort By
                </label>
                <select id="sort_by"
                        name="sort_by"
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition-all duration-200">
                    @foreach($sortOptions as $value => $label)
                        <option value="{{ $value }}" {{ $sortBy == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="lg:col-span-1">
                <label for="sort_order" class="block text-xs font-semibold text-gray-600 mb-1 uppercase tracking-wide">
                    <i class='bx bx-sort-alt-2 text-sm mr-1'></i>Order
                </label>
                <select id="sort_order"
                        name="sort_order"
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition-all duration-200">
                    <option value="asc" {{ $sortOrder == 'asc' ? 'selected' : '' }}>
                        <i class='bx bx-sort-up'></i> Asc
                    </option>
                    <option value="desc" {{ $sortOrder == 'desc' ? 'selected' : '' }}>
                        <i class='bx bx-sort-down'></i> Desc
                    </option>
                </select>
            </div>
            @endif

            @if($showYear)
            <!-- Year Selector -->
            <div class="lg:col-span-2">
                <label for="year" class="block text-xs font-semibold text-gray-600 mb-1 uppercase tracking-wide">
                    <i class='bx bx-calendar-event text-sm mr-1'></i>Year
                </label>
                <select id="year" name="year"
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition-all duration-200">
                    @foreach($yearOptions as $y)
                        <option value="{{ $y }}" {{ (int)request('year', $year) === (int)$y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endforeach
                </select>
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="lg:col-span-1 flex gap-2">
                <button type="submit"
                        class="flex-1 px-3 py-2 bg-gradient-to-r from-amber-500 to-amber-600 text-white text-sm font-medium rounded-lg hover:from-amber-600 hover:to-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:ring-offset-1 transition-all duration-200 border border-amber-600">
                    <i class='bx bx-search text-sm'></i>
                </button>
                <a href="{{ request()->url() }}"
                   class="flex-1 px-3 py-2 bg-gradient-to-r from-gray-500 to-gray-600 text-white text-sm font-medium rounded-lg hover:from-gray-600 hover:to-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-1 transition-all duration-200 border border-gray-600 text-center">
                    <i class='bx bx-x text-sm'></i>
                </a>
            </div>
        </div>

        <!-- Preserve current tab -->
        @if(request('tab'))
            <input type="hidden" name="tab" value="{{ request('tab') }}">
        @endif
    </form>
</div>
