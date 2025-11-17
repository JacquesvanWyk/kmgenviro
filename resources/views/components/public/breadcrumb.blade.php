@props(['items' => []])

@if(count($items) > 0)
    <nav class="bg-gray-50 border-b" aria-label="Breadcrumb">
        <div class="max-w-7xl mx-auto px-4 py-3">
            <ol class="flex items-center space-x-2 text-sm">
                @foreach($items as $index => $item)
                    <li class="flex items-center">
                        @if($index > 0)
                            <svg class="w-4 h-4 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        @endif

                        @if(isset($item['url']) && $index < count($items) - 1)
                            <a href="{{ $item['url'] }}"
                               class="text-gray-600 hover:text-green-600 transition">
                                {{ $item['label'] }}
                            </a>
                        @else
                            <span class="text-gray-900 font-medium">
                                {{ $item['label'] }}
                            </span>
                        @endif
                    </li>
                @endforeach
            </ol>
        </div>
    </nav>
@endif
