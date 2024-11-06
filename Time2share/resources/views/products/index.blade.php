<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="GET" action="{{ route('products.index') }}">
            @csrf <!-- Niet per se nodig bij GET, maar kan geen kwaad -->
            <input
                type="text"
                name="search"
                placeholder="{{ __('Search for a product...') }}"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                value="{{ request('search') }}"
            />
            <x-primary-button class="mt-4">{{ __('Search') }}</x-primary-button>
        </form>
        <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
            @foreach ($products as $product)
                <div class="p-6 flex space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-gray-800 font-bold">{{ $product->owner->name }}</span>
                                <!-- Controleer of er een loaner is -->
                                @if($product->loaner)
                                    <span class="text-gray-800 ml-4 ">Loaner: {{ $product->loaner->name }}</span>
                                @else
                                    <span class="text-gray-500 ml-4">Not loaned out</span>
                                @endif
                                
                                <small class="ml-2 text-sm text-gray-600">{{ $product->created_at->format('j M Y, g:i a') }}</small>
                            </div>
                        </div>
                        <span class="text-gray-800">{{ $product->category }}</span>
                        <p class="mt-4 text-lg text-gray-900">{{ $product->description }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>