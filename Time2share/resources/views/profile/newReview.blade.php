<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">Reviewing {{ $product->loaner->name }}</h2>

        <form method="POST" action="{{ route('review.store', $product) }}">
            @csrf

            <div class="mb-4">
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
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-medium">Description</label>
                <textarea 
                    name="description" 
                    id="description" 
                    rows="4" 
                    required 
                    class="block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                >{{ old('description') }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <div class="mb-4">
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
            </div>

            <div class="flex justify-end">
                <x-primary-button>{{ __('Post review') }}</x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
