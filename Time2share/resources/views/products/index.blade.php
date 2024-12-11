<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="GET" action="{{ route('products.index') }}">
            @csrf
            <input
                type="text"
                name="search"
                placeholder="{{ __('Search for a product...') }}"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                value="{{ request('search') }}"
                />
                <x-primary-button class="mt-4">{{ __('Search') }}</x-primary-button>
        </form>
    </div>
    <div class="py-12">
        @foreach ($products as $product)
        <div id="product_text_space" class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="margin-top: 25px">
            <div id="product_text_box" class="bg-white overflow-hidden shadow-sm sm:rounded-lg" style=" box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)" style="text-align: center">
                <div id="product_post_box" class="p-6 text-gray-900">
                    <div class="p-6 flex space-x-2"> 
                        @if ($product->loaner)
                            <div class="loaned_icon">
                                ➡️ 
                                <span id="product_loaner_text" class="text-gray-800 ml-4" >Loaned by: {{ $product->loaner->name }}</span>
                                <span id="product_created_text" class="ml-2 text-sm text-gray-600" >Deadline: {{ $product->deadline }}</span>
                            </div>
                        @else
                            <div class="notloaned_icon" style="font-size: 22px">
                                🏠
                            </div>
                        @endif
                        <div class="flex-1">
                            <div class="flex justify-between items-center">
                                <div class="product_post_grid">
                                    <span id="product_owner_text" class="text-gray-800 font-bold">
                                        {{ $product->owner->name }}
                                        <small id="product_created_text" class="ml-2 text-sm text-gray-600">
                                            {{ $product->created_at->format('j M Y, g:i a') }}
                                        </small>
                                        @if(Auth::user()->admin)
                                            <x-dropdown align="right" width="48">
                                                <x-slot name="trigger">
                                                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                                        <div>
                                                            {{ Auth::user()->name }}
                                                        </div>
                
                                                        <div class="ms-1">
                                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                            </svg>
                                                        </div>
                                                    </button>
                                                </x-slot>
                
                                                <x-slot name="content">
                                                    <x-dropdown-link>
                                                        @if ($product->owner->blocked)
                                                        <form method="POST" action="{{ route('user.unblock', $product) }}" class="flex-1 mb-2">
                                                            @csrf
                                                            <x-primary-button type="submit">{{ __('Unblock user') }}</x-primary-button>
                                                        </form>
                                                        @else
                                                        <form method="POST" action="{{ route('user.block', $product) }}" class="flex-1 mb-2">
                                                            @csrf
                                                            <x-primary-button type="submit">{{ __('Block user') }}</x-primary-button>
                                                        </form>
                                                        @endif
                                                    </x-dropdown-link>
                            
                                                    <form method="POST" action="{{ route('product.delete', $product) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <x-primary-button type="submit">{{ __('Delete product') }}</x-primary-button>
                                                    </form>
                                                </x-slot>
                                            </x-dropdown>
                                        @endif
                                    </span>
                                    <p id="product_name_text" class="text-gray-800 font-bold">{{ $product->name}}</p>
                                        <small id="product_category_text" class="text-gray-800 font-bold">{{ $product->category }}</small>
                                    <p id="product_description_text" class="mt-4 text-lg text-gray-900">{{ $product->description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</x-app-layout>