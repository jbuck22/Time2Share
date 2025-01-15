<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Loan Product') }}
        </h2>
    </x-slot>
    <section class="py-12">
        <section class="product_box" style="padding-bottom:0; margin-bottom:5rem">
            <form method="POST" action="{{ route('products.loan', $product->id) }}">
                @csrf
                <h2 style="justify-content:center; align-items:center; text-align:center" class="font-semibold text-xl text-gray-800 leading-tight" >
                    {{ __('You are about to loan this product') }}
                </h2>
                <br>
                <h3 class="font-semibold text-xl text-gray-800 leading-tight" style="font-weight: normal; justify-content:center; align-items:center; text-align:center ">
                    The product must be returned before: {{ $product->deadline }}
                </h3>
                <section class="product_actions > button" style="text-align:center; margin-top:1rem">
                    <button>{{ __('Confirm Loan') }}</button>
                </section>
            </form>
        </section>


        <section class="product_box" style="max-width:450px">
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
                <section>
                    <p class="owner_name">{{ $product->owner->name }}</p>
                    <p class="created_date">{{ "Avaliable since" }} {{ $product->updated_at->format('j M Y, g:i a') }}</p>
                </section>
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

            </section>
        </section>
    </section>
</x-app-layout>