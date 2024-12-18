@if (Auth::user()->blocked)
    <x-guest-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Blocked') }}
            </h2>
        </x-slot>

        You have been blocked. Please reach out to an admin to resolve this issue. 
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-primary-button :href="route('logout')"
                    onclick="event.preventDefault();
                                this.closest('form').submit();">
                {{ __('Log Out') }}
            </x-primary-button>
        </form>
    </x-guest-layout>
@else
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8" style="padding-bottom:0%">
        <form method="GET" action="{{ route('products.showDashboard') }}">
            @csrf
            <input
                type="text"
                name="search"
                placeholder="{{ __('Search for a product...') }}"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                value="{{ request('search') }}"
                />
                <x-primary-button id="primaryButton" class="mt-4">{{ __('Search') }}</x-primary-button>
        </form>
    </div>
    {{-- <div class="py-12">
        @foreach ($products as $product)
        @if (!$product->loaner)
        <div id="product_text_space" class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="margin-top: 25px">
            <div id="product_text_box" class="bg-white overflow-hidden shadow-sm sm:rounded-lg" style=" box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)" style="text-align: center">
                <div id="product_post_box" class="p-6 text-gray-900">
                    <div class="p-6 flex space-x-2">
                        @if($product->owner_id !== auth()->id())
                            <div class="notloaned_icon" style="font-size: 22px">
                                🏠
                                
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
                                        @if($product->owner->pfp)
                                        <small id="user_pfp">
                                            <img 
                                                src="{{ asset('storage/' . $product->owner->pfp) }}" 
                                                alt="{{ Auth::user()->name }}" 
                                                class="w-8 h-8 rounded-full object-cover mr-2"
                                            >
                                        </small>
                                        @else
                                        <small id="user_pfp">
                                            <img
                                                src="{{ asset('storage/pfps/default_pfp.jpg') }}"
                                                class="w-8 h-8 rounded-full object-cover mr-2"
                                                style="width: 30px; height: 30px; float:left"
                                            >
                                        </small>
                                        @endif
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
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="rounded-lg shadow-md w-full h-auto" id="product_image">
                                    @endif

                                    <p id="product_name_text" class="text-gray-800 font-bold">{{ $product->name}}
                                        <small id="product_category_text" class="text-gray-800 font-bold">{{ $product->category }}</small>
                                    </p>
                                    <p id="product_description_text" class="mt-4 text-lg text-gray-900">{{ $product->description }}</p>
                                    <a id="product_loan_button" href="{{ route('products.loanForm', $product->id) }}">
                                        <x-primary-button class="mt-4">{{ __('Loan') }}</x-primary-button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @endforeach
    </div> --}}
    <div class="py-12">
        @foreach ($products as $product)
            @if (!$product->loaner)
                <div class="product_box">
                    @if(Auth::user()->admin)
                    <div id="admin_dropdown" class="hidden sm:flex sm:items-center sm:ms-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <div>
                                        {{ "More" }}
                                    </div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                    @if ($product->owner->blocked)
                                    <form method="POST" action="{{ route('user.unblock', $product) }}" class="flex-1 mb-2">
                                        @csrf
                                        <x-dropdown-link type="submit">{{ __('Unblock user') }}</x-dropdown-link>
                                    </form>
                                    @else
                                    <form method="POST" action="{{ route('user.block', $product) }}" class="flex-1 mb-2">
                                        @csrf
                                        <button type="submit">{{ __('Block user') }}</button>
                                    </form>
                                    @endif
        
                                <form method="POST" action="{{ route('product.delete', $product) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">{{ __('Delete product') }}</button>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                    @endif
                    {{-- Header: Profiel + Naam --}}
                    <div class="product_header">
                        {{-- Profiel Foto --}}
                        @if($product->owner->pfp)
                            <img 
                                src="{{ asset('storage/' . $product->owner->pfp) }}" 
                                alt="{{ $product->owner->name }}"
                            >
                        @else
                            <img 
                                src="{{ asset('storage/pfps/default_pfp.jpg') }}"
                                alt="Default Profile Picture"
                            >
                        @endif
                        {{-- Naam en Datum --}}
                        <div>
                            <span class="owner_name">{{ $product->owner->name }}</span>
                            <span class="created_date">{{ $product->created_at->format('j M Y, g:i a') }}</span>
                        </div>
                        <div class="product_actions">
                            <a href="{{ route('products.loanForm', $product->id) }}">
                                <button>{{ __('Loan') }}</button>
                            </a>
                        </div>
                        
                    </div>
    
                    {{-- Content: Product Naam & Beschrijving --}}
                    <div class="product_content">
                        <p class="product_name">{{ $product->name }}
                          
                        </p>
                        <p class="product_description">{{ $product->description }}</p>
                    </div>
    
                    {{-- Afbeelding --}}
                    @if($product->image)
                        <img 
                            src="{{ asset('storage/' . $product->image) }}" 
                            alt="{{ $product->name }}" 
                            class="product_image"
                        >
                    @endif
    
                    {{-- Acties (bijv. Loan Button) --}}
                    {{-- <div class="product_actions">
                        <a href="{{ route('products.loanForm', $product->id) }}">
                            <button>{{ __('Loan') }}</button>
                        </a>
                    </div> --}}
                </div>
            @endif
        @endforeach
    </div>
    
    
</x-app-layout>
@endif