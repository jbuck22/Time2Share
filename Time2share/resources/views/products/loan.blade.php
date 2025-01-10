<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Loan Product') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="product_box" style="padding-bottom:0; margin-bottom:5rem">
            <form method="POST" action="{{ route('products.loan', $product->id) }}">
                @csrf
                <h2 style="justify-content:center; align-items:center; text-align:center" class="font-semibold text-xl text-gray-800 leading-tight" >
                    {{ __('You are about to loan this product') }}
                </h2>
                <br>
                <h3 class="font-semibold text-xl text-gray-800 leading-tight" style="font-weight: normal; justify-content:center; align-items:center; text-align:center ">
                    The product must be returned before: {{ $product->deadline }}
                </h3>
                {{-- <div class="mt-4" style="background-color: rgb(40, 0, 150); color: #fff; padding: 0.5rem 1rem; border: none; border-radius: 5px; font-size: 1rem; cursor: pointer; width:fit-content">
                    <button>{{ __('Confirm Loan') }}</button>
                </div> --}}
                <div class="product_actions > button" style="text-align:center; margin-top:1rem">
                    <button>{{ __('Confirm Loan') }}</button>
                </div>
            </form>
        </div>


        <div class="product_box" style="max-width:450px">
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
                    <span class="created_date">{{ "Avaliable since" }} {{ $product->created_at->format('j M Y, g:i a') }}</span>
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

            </div>
        </div>
    </div>
</x-app-layout>