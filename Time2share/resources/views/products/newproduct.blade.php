<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New product') }}
        </h2>
    </x-slot>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">Nieuw Product Aanmaken</h2>

        <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
            @csrf
            <!-- Naam van het product -->
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-medium">Naam van het product</label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    value="{{ old('name') }}" 
                    required 
                    class="block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                >
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Omschrijving -->
            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-medium">Omschrijving</label>
                <textarea 
                    name="description" 
                    id="description" 
                    rows="4" 
                    required 
                    class="block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                >{{ old('description') }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <!-- Categorie -->
            <div class="mb-4">
                <label for="category" class="block text-gray-700 font-medium">Categorie</label>
                <input 
                    type="text" 
                    name="category" 
                    id="category" 
                    value="{{ old('category') }}" 
                    class="block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                >
                <x-input-error :messages="$errors->get('category')" class="mt-2" />
            </div>

            <div class="mb-4">
                <label for="image" class="block text-gray-700 font-medium">Image:</label>
                <input type="file" name="image" id="image" value="{{ old('image') }}" required class="block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
            </div>

            <!-- Deadline -->
            <div class="mb-4">
                <label for="deadline" class="block text-gray-700 font-medium">Deadline</label>
                <input 
                    type="date" 
                    name="deadline" 
                    id="deadline" 
                    value="{{ old('deadline') }}" 
                    required 
                    class="block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                >
                <x-input-error :messages="$errors->get('deadline')" class="mt-2" />
            </div>

            <!-- Verstuur knop -->
            <div class="flex justify-end">
                <x-primary-button>{{ __('Product Aanmaken') }}</x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
