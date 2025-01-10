<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="filters">
            <small class="sortby_title"> Filter by:</small>
            <a href="{{ route('products.overview', ['filter' => 'loaned']) }}" class="btn btn-primary">`
                <x-primary-button id="primaryButton" class="mt-4"> {{__('Loaned Products')}} </x-primary-button>
            </a>
            <a href="{{ route('products.overview', ['filter' => 'loaning']) }}" class="btn btn-primary">`
                <x-primary-button id="primaryButton" class="mt-4"> {{__('Loaning Products')}} </x-primary-button>
            </a>
            <a href="{{ route('products.overview', ['filter' => 'pending_returns']) }}" class="btn btn-primary">`
                <x-primary-button id="primaryButton" class="mt-4"> {{__('Returned Products')}} </x-primary-button>
            </a>
            <a href="{{ route('products.overview', ['filter' => 'my_products']) }}" class="btn btn-primary">`
                <x-primary-button id="primaryButton" class="mt-4"> {{__('My Products')}} </x-primary-button>
            </a>
        </div>

        @if($products->isEmpty())
        <div class="product_box" style="margin-top: 5rem">
            <h2 style="justify-content:center; align-items:center; text-align:center; margin-top:1.5rem" class="font-semibold text-xl text-gray-800 leading-tight">
                There are no products found with this filter
            </h2>   
        </div>
        @else
            @foreach ($products as $product)
                <div class="product_box">
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
                                    <span class="created_date">{{ "Avaliable since" }} {{ $product->created_at->format('j M Y, g:i a') }}</span>
                                    @if ($product->loaner)
                                        <span class="created_date">
                                            {{ "loaned by:" }} {{ $product->loaner->name }}
                                        </span>
                                    @endif
                            </div>
                            
                        @else
                            <div>
                                <span class="owner_name">{{ $product->owner->name }}</span>
                                <span class="created_date">{{ "Avaliable since" }} {{ $product->created_at->format('j M Y, g:i a') }}</span>
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
                    @if($product->owner->id === Auth::user()->id && $filter === 'pending_returns' && in_array($product->id, $pendingReturns))
                        <h2 style="justify-content:center; align-items:center; text-align:center; margin-bottom:1rem; margin-top:2rem" class="font-semibold text-xl text-gray-800 leading-tight" >
                            {{ $product->loaner->name }} has requested to return this product
                        </h2>
                        <div class="form_grid_item" style="max-width: 135px; grid-row-start:6; grid-column-start:1; margin:auto; margin-left:4rem" >
                            <form id="accept_return_form" method="POST" action="{{ route('products.accept', $product) }}" class="flex-1 mb-2" style="margin-bottom: 0%">
                                @csrf
                                @method('PATCH') 
                                <div class="product_actions" style="margin: auto; text-align:center; padding-right:0%">
                                    <button type="submit">{{ __('Accept return') }}</button>
                                </div>
                            </form>
                        </div>
                        <div class="form_grid_item" style="max-width: 165px; grid-row-start:6; grid-column-start:1; margin:auto; margin-right:4rem">
                            <a class="product_actions" style="margin: auto; text-align:center; padding-right:0%" href="{{ route('profile.newReview', $product) }}">
                                <button type="submit">{{ __('Accept and review') }}</button>
                            </a>
                        </div>
                    @elseif($product->loaner_id == auth()->id() && !in_array($product->id, $pendingReturns)&& $filter === 'loaning')
                        <div class="form_grid_item" style="margin:auto; margin-top:2rem;" >
                            <form id="accept_return_form" method="POST" action="{{ route('products.return', $product) }}" class="flex-1 mb-2" style="margin-bottom: 0%">
                                @csrf
                                <div class="product_actions" style="margin: auto; text-align:center; padding-right:0%">
                                    <button type="submit">{{ __('Return product') }}</button>
                                </div>
                            </form>
                        </div>
                        
                    @elseif($product->loaner_id == auth()->id() && in_array($product->id, $pendingReturns)&& $filter === 'loaning')
                        <h2 style="justify-content:center; align-items:center; text-align:center; margin-bottom:1rem; margin-top:2rem" class="font-semibold text-xl text-gray-800 leading-tight" >
                            You have succesfully returned this product, waiting for confirmation from the owner. 
                        </h2>   
                    @endif
                </div>          
            @endforeach
        @endif
    </div>
</x-app-layout>
