@php
    /**
     * @var \App\Models\Post $post
     */
@endphp

<div class="sm:flex sm:items-center sm:ml-6">
    <p class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-900">
        Rating: {{ $post->total_rating ? number_format(round($post->total_rating,2),2): '-' }}
    </p>
</div>
<div class="sm:flex sm:items-center sm:ml-6">
    <p class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-900">
        You rated:
        @if($post->myRating)
            {{ round($post->myRating) ?: '-' }}
        @else
            &nbsp;
            <span class="fa fa-star" data-rating="1" data-post="{{ $post->id }}"></span>
            <span class="fa fa-star" data-rating="2" data-post="{{ $post->id }}"></span>
            <span class="fa fa-star" data-rating="3" data-post="{{ $post->id }}"></span>
            <span class="fa fa-star" data-rating="4" data-post="{{ $post->id }}"></span>
            <span class="fa fa-star" data-rating="5" data-post="{{ $post->id }}"></span>
        @endif
    </p>
</div>
