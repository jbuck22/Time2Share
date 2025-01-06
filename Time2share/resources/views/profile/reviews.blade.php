<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My reviews') }}
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="filters">
            <a href="{{ route('profile.reviews', array_merge(request()->query(), ['filter' => 'sentReviews'])) }}" class="btn btn-primary">Sent reviews</a>
            <a href="{{ route('profile.reviews', array_merge(request()->query(), ['filter' => 'receivedReviews'])) }}" class="btn btn-primary">Received reviews</a>
            <a href="{{ route('profile.reviews', array_merge(request()->except('sortDate'), ['sortRating' => 'highToLow'])) }}" class="btn btn-primary">Rating: highest first</a>
            <a href="{{ route('profile.reviews', array_merge(request()->except('sortDate'), ['sortRating' => 'lowToHigh'])) }}" class="btn btn-primary">Rating: lowest first</a>
            <a href="{{ route('profile.reviews', array_merge(request()->except('sortRating'), ['sortDate' => 'oldFirst'])) }}" class="btn btn-primary">Oldest first</a>
            <a href="{{ route('profile.reviews', array_merge(request()->except('sortRating'), ['sortDate' => 'newFirst'])) }}" class="btn btn-primary">Newest first</a>
        </div>

        @foreach ($reviews as $review)
        <div id="product_text_space" class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="margin-top: 25px">
            <div id="product_text_box" class="bg-white overflow-hidden shadow-sm sm:rounded-lg" style=" box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)" style="text-align: center">
                <div id="product_post_box" class="p-6 text-gray-900">
                    <div class="p-6 flex space-x-2"> 
                        <div class="flex-1">
                            <div class="flex justify-between items-center">
                                <div class="product_post_grid">
                        {{-- <p>{{ $review->reviewer->name }}</p> --}}

                        <span id="product_owner_text" class="text-gray-800 font-bold">
                            
                            @if ($review->reviewer_id === auth()->id())
                                You
                            @else
                                {{ $review->reviewer->name }}
                            @endif
                            <small id="product_created_text" class="ml-2 text-sm text-gray-600">
                                To: 
                                @if ($review->reviewLoaner_id === auth()-> id())
                                    You
                                @else    
                                    {{ $review->reviewloaner->name }}
                                @endif
                            </small>
                        </span>
                        <p id="product_name_text" class="text-gray-800 font-bold">{{ $review->product->name }}</p>
                        {{-- <p>{{ $review->product->name }}</p> --}}
                        <small id="product_category_text" class="text-gray-800 font-bold">{{ $review->title }}</small>
                        <p id="product_description_text" class="mt-4 text-lg text-gray-900">{{ $review->description }}</p>
                        <p>{{ $review->rating }}</p>
                        {{-- <p>{{ $review->title }}</p>
                        <p>{{ $review->description }}</p> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</x-app-layout>