@props(['items' => []])

<nav class="flex px-5 py-3 text-gray-700 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        @foreach($items as $item)
            <li>
                <div class="flex items-center">
                    @if(!$loop->first)
                        <i class="bx bx-chevron-right text-gray-400"></i>
                    @endif
                    @if(isset($item['url']))
                        <a href="{{ $item['url'] }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">
                            @if($loop->first)
                                <i class="bx bxs-home mr-2"></i>
                            @endif
                            {{ $item['label'] }}
                        </a>
                    @else
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">
                            {{ $item['label'] }}
                        </span>
                    @endif
                </div>
            </li>
        @endforeach
    </ol>
</nav> 