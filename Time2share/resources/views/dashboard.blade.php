<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
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
                                {{-- ZET HIER IF PRODUCT IS IN PENDING -> LAAT HET ZIEN --}}
                                    <span class="text-gray-800 ml-4 ">Loaner: {{ $product->loaner->name }}</span>
                                    <section class="flex flex-wrap space-x-2">
                                        <form action="{{ route('dashboard.return') }}" method="POST" class="flex-1 mb-2">
                                            @csrf
                                            <x-primary-button type="submit" class="w-full px-2 py-1 text-xs bg-green-800 hover:bg-green-600 focus:bg-green-600">Accept</x-primary-button>
                                        </form>
                                    </section>
                                @else
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
        </div>
    </div>
</x-app-layout>
