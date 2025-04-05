@php
    $variant = strval($variant); 

    $styles = [
        'primary'   => 'btn bg-[#ffb51b] hover:bg-[#141a2b] text-white active:scale-95 transition-transform duration-200', //submit, create
        'secondary' => 'btn bg-[#1a2235] hover:bg-[#e6a011] text-white active:scale-95 transition-transform duration-200',
        'success'   => 'btn btn-success hover:bg-green-600 active:scale-95 transition-transform duration-200', 
        'danger'    => 'btn bg-red-600 text-white hover:bg-red-400 active:scale-95 transition-transform duration-200',
        'warning'   => 'btn btn-warning hover:bg-[#e6a011] active:scale-95 transition-transform duration-200',
        'info'      => 'btn btn-info hover:bg-blue-600 active:scale-95 transition-transform duration-200', 

        'delete'    => 'text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center',
        'close'     => 'py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700'
];


@endphp

<button {{ $attributes->merge(['class' => "px-4 py-2 rounded-md font-semibold transition duration-200 " . ($styles[$variant] ?? $styles['primary'])]) }}>
    {{ $slot }}
</button>
