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

    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="GET" action="{{ route('products.showDashboard') }}">
            @csrf
            <input
                type="text"
                name="search"
                placeholder="{{ __('Search for a product...') }}"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                value="{{ request('search') }}"
                />
                <x-primary-button id="primaryButton" class="mt-4" style="margin-top: 2%;">{{ __('Search') }}</x-primary-button>
        </form>
    </div>

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
                                        {{ "Admin" }}
                                    </div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <div class="admin_content">
                                    @if ($product->owner->blocked)
                                        <form method="POST" action="{{ route('user.unblock', $product) }}" class="flex-1 mb-2">
                                            @csrf
                                            <x-primary-button id="primaryButton" type="submit">{{ __('Unblock user') }}</x-primary-button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('user.block', $product) }}" class="flex-1 mb-2">
                                            @csrf
                                            <x-primary-button id="primaryButton" type="submit">{{ __('Block user') }}</x-primary-button>
                                        </form>
                                    @endif
            
                                    <form method="POST" action="{{ route('product.delete', $product) }}">
                                        @csrf
                                        @method('DELETE')
                                        <x-primary-button id="primaryButton" type="submit">{{ __('Delete product') }}</x-primary-button>
                                    </form>
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>
                    @endif
                    <div class="product_header">
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
                        @if (Auth::user()->id === $product->owner->id)
                            <div>
                                    <span class="owner_name">{{ "You" }}</span>
                                    <span class="created_date">{{ "Created this product on" }} {{ $product->created_at->format('j M Y, g:i a') }}</span>
                            </div>
                        @else
                            <div>
                                <span class="owner_name">{{ $product->owner->name }}</span>
                                <span class="created_date">{{ "Created this product on" }} {{ $product->created_at->format('j M Y, g:i a') }}</span>
                            </div>
                            <div class="product_actions">
                                <a href="{{ route('products.loanForm', $product->id) }}">
                                    <button>{{ __('Loan') }}</button>
                                </a>
                            </div>
                        @endif
                    </div>
    
                    <div class="product_content">
                        <p class="product_name">{{ $product->name }}</p>
                        <p class="product_description">{{ $product->description }}</p>
                    </div>
    
                    @if($product->image)
                        <img 
                            src="{{ asset('storage/' . $product->image) }}" 
                            alt="{{ $product->name }}" 
                            class="product_image"
                        >
                    @endif
                </div>
            @endif
        @endforeach
    </div>
    
    
</x-app-layout>
@endif