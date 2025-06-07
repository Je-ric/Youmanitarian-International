{{-- Available for anchor links --}}

@props([
    'href' => null,
    'type' => 'button',
    'variant' => 'primary',
])

@php
    $variant = strval($variant);
    $styles = [
        'primary' => 'btn px-4 py-2 rounded-md text-white text-sm md:text-sm font-semibold 
                shadow-[0px_5.28px_13.2px_rgba(255,225,164,1)] active:scale-95 transition-transform duration-200 
                bg-[#ffb51b] hover:bg-[#ffc449] border-0 outline-none focus:outline-none focus:ring-2 focus:ring-yellow-400/70',
        'secondary' => 'btn px-4 py-2 rounded-md text-white text-sm md:text-sm font-semibold 
                shadow-[0px_5px_13px_rgba(15,21,36,0.8)] active:scale-95 transition-transform duration-200 
                bg-[#1a2235] hover:bg-[#0F1524] border-0 outline-none focus:outline-none focus:ring-2 focus:ring-yellow-700/70',

        'success'   => 'btn btn-success text-white hover:bg-green-600 active:scale-95 transition-transform duration-200',
        'danger'    => 'btn bg-red-600 text-white hover:bg-red-400 active:scale-95 transition-transform duration-200',
        'warning'   => 'btn btn-warning text-white hover:bg-[#e6a011] active:scale-95 transition-transform duration-200',
        'info'      => 'btn btn-info text-white hover:bg-blue-600 active:scale-95 transition-transform duration-200',
        'manage'    => 'btn bg-emerald-500 text-white hover:bg-emerald-600 active:scale-95 transition-transform duration-200',

        'restore'   => 'btn bg-blue-500 text-white hover:bg-blue-600 active:scale-95 transition-transform duration-200',
        'approve'   => 'btn bg-green-500 text-white hover:bg-green-600 active:scale-95 transition-transform duration-200',

        'delete'    => 'text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center',
        'close'     => 'py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700',
    
        'disabled' => '
            bg-slate-400 
            text-white text-base font-semibold tracking-tight 
            rounded-md 
            shadow-[0px_5.28px_13.2px_rgba(49,56,73,0.24)] 
            cursor-not-allowed 
            transition duration-200
        ',
        'clock_in' => '
            bg-[#ffb51b] hover:bg-[#ffc449] 
            text-white 
            px-4 py-2 
            text-sm sm:text-base md:text-base font-semibold 
            rounded-md 
            shadow-[0px_5.28px_13.2px_0px_rgba(255,225,164,1.00)] 
            w-full 
            active:scale-95 
            transition-transform duration-200
        ',


        ];

    $class = "inline-flex items-center justify-center gap-1 px-4 py-2 rounded-md font-semibold transition duration-200 " . ($styles[$variant] ?? $styles['primary']);
@endphp

{{-- So, it allows button to work as clickable link if provided a href, but mag-aact as regular button if none --}}
@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $class]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $class]) }}>
        
        {{ $slot }}
    </button>
@endif

{{-- 

<div class="flex flex-col sm:flex-row gap-3 w-full max-w-md">
  <!-- Log Attendance Button -->
  <button
    class="flex items-center justify-center gap-2 px-4 py-2 rounded-md border border-gray-300 bg-white text-gray-800 
           hover:bg-gray-100 hover:border-gray-400 active:bg-gray-200 active:scale-[.98] cursor-pointer 
           shadow-sm transition-all duration-150 ease-in-out flex-1">
    <i class='bx bx-time text-xl'></i>
    <span class="text-sm sm:text-base font-medium">Log Attendance</span>
  </button>

  <!-- Participate Button -->
  <button
    class="flex items-center justify-center gap-2 px-4 py-2 rounded-md border border-gray-300 bg-white text-gray-800 
           hover:bg-gray-100 hover:border-gray-400 active:bg-gray-200 active:scale-[.98] cursor-pointer 
           shadow-sm transition-all duration-150 ease-in-out flex-1">
    <i class='bx bx-user-plus text-xl'></i>
    <span class="text-sm sm:text-base font-medium">Participate</span>
  </button>
</div> --}}
