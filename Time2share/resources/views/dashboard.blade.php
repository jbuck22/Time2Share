<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <section class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
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
    </section>

    <section class="py-12">
        @foreach ($products as $product)
            @if (!$product->loaner)
                <section class="product_box">
                    <section class="product_header">
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
                            <section>
                                    <p class="owner_name">{{ "You" }}</p>
                                    <p class="created_date">{{ "Avaliable since" }} {{ $product->updated_at->format('j M Y, g:i a') }}</p>
                            </section>
                        @else
                            <section>
                                <p class="owner_name">{{ $product->owner->name }}</p>
                                <p class="created_date">{{ "Avaliable since" }} {{ $product->updated_at->format('j M Y, g:i a') }}</p>
                            </section>
                        @endif
                        @if(Auth::user()->admin)
                        <section id="admin_dropdown" class="sm:flex sm:items-center sm:ms-6">
                            <x-dropdown align="top" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                        <section>
                                            {{ "Admin" }}
                                        </section>
                                        <section class="ms-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </section>
                                    </button>
                                </x-slot>
    
                                <x-slot name="content">
                                    <section class="admin_content">
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
                                    </section>
                                </x-slot>
                            </x-dropdown>
                        </section>
                        @endif
                    </section>
                    <section class="product_content">
                        <section>
                            <p class="product_name">{{ $product->name }}</p>
                            <p class="product_category">{{ "Category:" }} {{ $product->category }}</p>
                        </section>
                        <p class="product_description">{{ $product->description }}</p>
                    </section>
    
                    @if($product->image)
                        <img 
                            src="{{ asset('storage/' . $product->image) }}" 
                            alt="{{ $product->name }}" 
                            class="product_image"
                        >
                    @endif
                    @if (Auth::user()->id !== $product->owner->id)
                        <section class="product_actions">
                            <a href="{{ route('products.loanForm', $product->id) }}">
                                <x-primary-button id="primaryButton">{{ __('Loan') }}</x-primary-button>
                            </a>
                        </section>
                    @endif
                </section>
            @endif
        @endforeach
    </section>
</x-app-layout>