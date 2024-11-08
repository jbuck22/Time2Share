<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My products') }}
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
                                @if($product->owner_id == auth()->id() && in_array( $product->id, $pendingReturns))
                                <form method="POST" action="{{ route('products.accept', $product) }}"  class="flex-1 mb-2">
                                    @csrf
                                    @method('PATCH') 
                                    <span class="text-gray-800 font-bold">{{ $product->owner->name }}</span>
                                    @if ($product->loaner)
                                        <span class="text-gray-800 ml-4 ">Loaner: {{ $product->loaner->name }}</span>
                                    @endif
                                    <small class="ml-2 text-sm text-gray-600">{{ $product->created_at->format('j M Y, g:i a') }}</small>
                                    <p class="text-gray-800 font-bold">{{ $product->category }}</p>
                                    <p class="mt-4 text-lg text-gray-900">{{ $product->description }}</p>
                                    <x-primary-button type="submit">{{ __('Accept Return') }}</x-primary-button>
                                </form>
                                @else
                                    <span class="text-gray-800 font-bold">{{ $product->owner->name }}</span>
                                    <small class="ml-2 text-sm text-gray-600">{{ $product->created_at->format('j M Y, g:i a') }}</small>
                                    <p class="text-gray-800 font-bold">{{ $product->category }}</p>
                                    <p class="mt-4 text-lg text-gray-900">{{ $product->description }}</p>
                                @endif
                                
                                
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
            @foreach ($loanedProducts as $loanedProduct)
                <div class="p-6 flex space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <div>
                                @if($loanedProduct->loaner_id == auth()->id() && !in_array( $loanedProduct->id, $pendingReturns))   
                                    <section class="flex flex-wrap space-x-2">
                                        <form method="POST" action="{{ route('products.return', $loanedProduct) }}"  class="flex-1 mb-2">
                                            @csrf
                                            <span class="text-gray-800 font-bold">{{ $loanedProduct->loaner->name }}</span>
                                            <span class="text-gray-800 ml-4 ">Owner: {{ $loanedProduct->owner->name }}</span>
                                            <small class="ml-2 text-sm text-gray-600">{{ $loanedProduct->created_at->format('j M Y, g:i a') }}</small>
                                            <p class="text-gray-800 font-bold">{{ $loanedProduct->category }}</p>
                                            <p class="mt-4 text-lg text-gray-900">{{ $loanedProduct->description }}</p>
                                            <input type="hidden" name="product" value="{{$loanedProduct->id}}">
                                            <input type="hidden" name="owner_id" value="{{$loanedProduct->owner_id}}"> 
                                            <input type="hidden" name="loaner_id" value="{{$loanedProduct->loaner_id}}">                               
                                            <x-primary-button type="submit">{{ __('Return Product') }}</x-primary-button>
                                        </form>
                                    </section>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
