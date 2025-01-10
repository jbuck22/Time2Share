<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My reviews') }}
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="filters">
            <div class="filters_buttons">
                <small class="sortby_title"> Filter by:</small>
                <a href="{{ route('profile.reviews', array_merge(request()->query(), ['filter' => 'sentReviews'])) }}" class="btn btn-primary">
                    <x-primary-button id="primaryButton" class="mt-4"> {{__('Sent reviews')}} </x-primary-button>
                </a>
                <a href="{{ route('profile.reviews', array_merge(request()->query(), ['filter' => 'receivedReviews'])) }}" class="btn btn-primary"> 
                    <x-primary-button id="primaryButton" class="mt-4"> {{__('Received reviews')}} </x-primary-button>
                </a>
                <br>    
            </div>
            <div class="sortby_buttons"> 
                <small class="sortby_title"> Sort by:</small>
                <a href="{{ route('profile.reviews', array_merge(request()->except('sortDate'), ['sortRating' => 'highToLow'])) }}" class="btn btn-primary">
                     <x-primary-button id="primaryButton" class="mt-4"> {{__('Rating: highest')}} </x-primary-button>
                </a>
                <a href="{{ route('profile.reviews', array_merge(request()->except('sortDate'), ['sortRating' => 'lowToHigh'])) }}" class="btn btn-primary">
                     <x-primary-button id="primaryButton" class="mt-4"> {{__('Rating: lowest')}} </x-primary-button>
                </a>
                <a href="{{ route('profile.reviews', array_merge(request()->except('sortRating'), ['sortDate' => 'oldFirst'])) }}" class="btn btn-primary">
                    <x-primary-button id="primaryButton" class="mt-4"> {{__('Date: Oldest ')}} </x-primary-button>
                </a>
                <a href="{{ route('profile.reviews', array_merge(request()->except('sortRating'), ['sortDate' => 'newFirst'])) }}" class="btn btn-primary">
                    <x-primary-button id="primaryButton" class="mt-4"> {{__('Date: Newest')}} </x-primary-button>
                </a>
            </div>
        </div>

        @foreach ($reviews as $review)
        <div class="product_box">
            <div class="product_header">
                @if($review->reviewer->pfp)
                <img 
                    src="{{ asset('storage/' . $review->reviewer->pfp) }}" 
                    alt="{{ $review->reviewer->name }}"
                >
                @else
                    <img 
                        src="{{ asset('storage/pfps/default_pfp.jpg') }}"
                        alt="Default Profile Picture"
                    >
                @endif
                @if ($review->reviewer_id === auth()->id())
                <div>
                    <span class="owner_name">{{ "You" }}</span>
                    <span class="review_loan_text"> {{ "To:" }} {{ $review->reviewloaner->name }} {{ "- For the product:" }} {{ $review->product->name }}</span>
                </div>
                <div class="product_actions">
                    <span class="owner_name">{{ $review->rating }} {{"/ 10"}}</span>
                </div>
                @else
                <div>
                    <span class="owner_name">{{ $review->reviewer->name }}</span>
                    <span class="review_loan_text"> {{ "To:" }} {{ "You" }} {{ "- For the product:" }} {{ $review->product->name }}</span>
                </div>
                <div class="product_actions">
                    <span class="owner_name">{{ $review->rating }} {{"/ 10"}}</span>
                </div>
                @endif
            </div>

            <div class="product_content">
                <p class="product_name">{{ $review->title }}</p>
                <p class="product_description">{{ $review->description }}</p>
            </div>
        </div>
        @endforeach
    </div>
</x-app-layout>