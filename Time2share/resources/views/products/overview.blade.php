<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="filters">
            <a href="{{ route('products.overview', ['filter' => 'loaned']) }}" class="btn btn-primary">Loaned Products</a>
            <a href="{{ route('products.overview', ['filter' => 'loaning']) }}" class="btn btn-primary">Loaning Products</a>
            <a href="{{ route('products.overview', ['filter' => 'pending_returns']) }}" class="btn btn-primary">Returned Products</a>
            <a href="{{ route('products.overview') }}" class="btn btn-primary">My Products</a>
        </div>

        @if($products->isEmpty())
        <p class="mt-4 text-gray-600">No products found for this filter.</p>
        @else

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
                                        <span id="product_owner_text" class="text-gray-800 font-bold">{{ $product->owner->name }}
                                            <small id="product_created_text" class="ml-2 text-sm text-gray-600">{{ $product->created_at->format('j M Y, g:i a') }}</small>
                                        </span>
                                        <p id="product_name_text" class="text-gray-800 font-bold">{{ $product->name}}</p>
                                            <small id="product_category_text" class="text-gray-800 font-bold">{{ $product->category }}</small>
                                        <p id="product_description_text" class="mt-4 text-lg text-gray-900">{{ $product->description }}</p>

                                        @if($product->owner_id == auth()->id() && $filter === 'pending_returns' && in_array($product->id, $pendingReturns))
                                                <form id="accept_return_form" method="POST" action="{{ route('products.accept', $product) }}" class="flex-1 mb-2">
                                                    @csrf
                                                    @method('PATCH') 
                                                    <p id="product_return_text" class="ml-2 text-sm text-gray-600">
                                                        {{ $product->loaner->name }} has requested to return this product
                                                    </p>
                                                    <x-primary-button class="accept_return_button" type="submit">{{ __('Accept Return') }}</x-primary-button>
                                                </form>
                                            @elseif($filter === 'loaning' && $product->loaner_id == auth()->id())
                                                <form method="POST" action="{{ route('products.return', $product) }}" class="flex-1 mb-2">
                                                    @csrf
                                                    <x-primary-button type="submit">{{ __('Return Product') }}</x-primary-button>
                                                </form>
                                            @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        @endif
    </div>
</x-app-layout>
