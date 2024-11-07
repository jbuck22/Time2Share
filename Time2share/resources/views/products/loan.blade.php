<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <h2 class="text-lg font-medium text-gray-900">{{ __('Loan Product') }}</h2>
        
        <form method="POST" action="{{ route('products.loan', $product->id) }}">
            @csrf
            <p>{{ __('Are you sure you want to loan this product from?') }} {{ $product->owner->name }} </p>
            <p>{{ $product->name }}</p>
            <p>{{ $product->category }}</p>
            <p>{{ $product->description }}</p>
            <p>The product must be returned before: {{ $product->deadline }}</p>
            
            <div class="mt-4">
                <x-primary-button>{{ __('Confirm Loan') }}</x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>