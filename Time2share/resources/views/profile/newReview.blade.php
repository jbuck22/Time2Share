<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New review for') }} {{ $product->loaner->name }} {{ __('and the loan of ') }} {{ $product->name }}
        </h2>
    </x-slot>
    <section class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('review.store', $product) }}" style="margin-bottom: 5rem">
            @csrf

            <section class="mb-4">
                <label for="title" class="block text-gray-700 font-medium">Title </label>
                <input 
                    type="text" 
                    name="title" 
                    id="title" 
                    value="{{ old('title') }}" 
                    required 
                    class="block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                >
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </section>

            <section class="mb-4">
                <label for="description" class="block text-gray-700 font-medium">Description</label>
                <textarea 
                    name="description" 
                    id="description" 
                    rows="4" 
                    required 
                    class="block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                >{{ old('description') }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </section>

            <section class="mb-4">
                <label for="rating" class="block text-gray-700 font-medium">Rating</label>
                <input 
                    type="numeric" 
                    name="rating" 
                    id="rating" 
                    value="{{ old('rating') }}" 
                    required 
                    class="block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                >
                <x-input-error :messages="$errors->get('rating')" class="mt-2" />
            </section>

            <section class="flex justify-end">
                <x-primary-button id="primaryButton">{{ __('Post review') }}</x-primary-button>
            </section>
        </form>

        <section class="product_box">
            <section class="product_header">
                @if($product->loaner->pfp)
                    <img 
                        src="{{ asset('storage/' . $product->loaner->pfp) }}" 
                        alt="{{ $product->loaner->name }}"
                    >
                @else
                    <img 
                        src="{{ asset('storage/pfps/default_pfp.jpg') }}"
                        alt="Default Profile Picture"
                    >
                @endif
                    <section>
                        <p class="owner_name">{{ $product->loaner->name }}</p>
                        <p class="created_date">{{ "Returned this product on" }} {{ $pendingReturn->created_at->format('j M Y, g:i a') }}</p>
                    </section>
            </section>

            <section class="product_content">
                <p class="product_name">{{ $product->name }}</p>
                <p class="product_description">{{ $product->description }}</p>
            </section>
        </section>
    </section>
</x-app-layout>
