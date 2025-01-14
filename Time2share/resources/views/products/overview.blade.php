<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My products') }}
        </h2>
    </x-slot>

    <section class="py-12">
        <section class="filters">
            <section class="filters_buttons">
                <small class="sortby_title"> Filter by:</small>
                <a href="{{ route('products.overview', ['filter' => 'loaned']) }}" class="btn btn-primary">
                    <x-primary-button id="primaryButton" class="mt-4"> {{__('Loaned Products')}} </x-primary-button>
                </a>
                <a href="{{ route('products.overview', ['filter' => 'loaning']) }}" class="btn btn-primary">
                    <x-primary-button id="primaryButton" class="mt-4"> {{__('Loaning Products')}} </x-primary-button>
                </a>
                <a href="{{ route('products.overview', ['filter' => 'pending_returns']) }}" class="btn btn-primary">
                    <x-primary-button id="primaryButton" class="mt-4"> {{__('Returned Products')}} </x-primary-button>
                </a>
                <a href="{{ route('products.overview', ['filter' => 'my_products']) }}" class="btn btn-primary">
                    <x-primary-button id="primaryButton" class="mt-4"> {{__('My Products')}} </x-primary-button>
                </a>
            </section>
        </section>

        @if($products->isEmpty())
        <section class="product_box" style="margin-top: 5rem">
            <h2 style="justify-content:center; align-items:center; text-align:center; margin-top:1.5rem" class="font-semibold text-xl text-gray-800 leading-tight">
                There are no products found with this filter
            </h2>   
        </section>
        @else
            @foreach ($products as $product)
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
                                    <p class="created_date">{{ "Avaliable since" }} {{ $product->created_at->format('j M Y, g:i a') }}</p>
                                    @if ($product->loaner)
                                        <p class="created_date">
                                            {{ "loaned by:" }} {{ $product->loaner->name }}
                                        </p>
                                    @endif
                            </section>
                            
                        @else
                            <section>
                                <p class="owner_name">{{ $product->owner->name }}</p>
                                <p class="created_date">{{ "Avaliable since" }} {{ $product->created_at->format('j M Y, g:i a') }}</p>
                            </section>
                        @endif

             
                    </section>

                    <section class="product_content">
                        <p class="product_name">{{ $product->name }}</p>
                        <p class="product_description">{{ $product->description }}</p>
                    </section>

                    @if($product->image)
                        <img 
                            src="{{ asset('storage/' . $product->image) }}" 
                            alt="{{ $product->name }}" 
                            class="product_image"
                        >
                    @endif
                    @if($product->owner->id === Auth::user()->id && $filter === 'pending_returns' && in_array($product->id, $pendingReturns))
                        <h2 style="justify-content:center; align-items:center; text-align:center; margin-bottom:1rem; margin-top:2rem" class="font-semibold text-xl text-gray-800 leading-tight" >
                            {{ $product->loaner->name }} has requested to return this product
                        </h2>
                        <section>
                            <form id="accept_return_form" method="POST" action="{{ route('products.accept', $product) }}" class="flex-1 mb-2" >
                                @csrf
                                @method('PATCH') 
                                <section class="product_actions" style="width: 75%">
                                    <x-primary-button id="primaryButton" type="submit">{{ __('Accept return') }}</x-primary-button>
                                </section>
                            </form> 
                        </section>
                        
                        <article id="accept_return_form">
                            <section class="product_actions" style="width: 75%">
                                <x-primary-button id="primaryButton" type="submit" onclick="window.location='{{ route('profile.newReview', $product) }}' ">
                                    {{ __('Accept and review') }}
                                </x-primary-button>
                            </section>
                        </article>
                    @elseif($product->loaner_id == auth()->id() && !in_array($product->id, $pendingReturns)&& $filter === 'loaning')
                            <form id="accept_return_form" method="POST" action="{{ route('products.return', $product) }}" class="flex-1 mb-2" style="margin-bottom: 0%">
                                @csrf
                                <section class="product_actions" style="width:75%">
                                    <x-primary-button id="primaryButton" type="submit">{{ __('Return product') }}</x-primary-button>
                                </section>
                            </form>
                        </section>
                        
                    @elseif($product->loaner_id == auth()->id() && in_array($product->id, $pendingReturns)&& $filter === 'loaning')
                        <h2 style="justify-content:center; align-items:center; text-align:center; margin-bottom:1rem; margin-top:2rem" class="font-semibold text-xl text-gray-800 leading-tight" >
                            You have succesfully returned this product, waiting for confirmation from the owner. 
                        </h2>   
                    @endif
                </section>          
            @endforeach
        @endif
    </section>
</x-app-layout>
