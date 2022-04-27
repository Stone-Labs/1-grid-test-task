@php
    /**
     * @var \App\Models\Post $post
     */
    $previous = url()->previous();
    $user = \Illuminate\Support\Facades\Auth::user();
@endphp

<x-app-layout>
    <div class="post_item">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Show') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="post_item p-6 bg-white border-b border-gray-200">
                        <div class="title">
                            {{ $post->title }}
                        </div>
                        <div class="content">
                            {{ $post->content }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="bg-white border-gray-200">
                        <div class="buttons">
                            <x-nav-link :href="$previous" style="margin-left: 10px;color: blueviolet;">
                                {{ __('Return to blog') }}
                            </x-nav-link>
                        </div>
                        <div class="block_raitng flex">
                            @include('blog.components.inline_rating',['post'=>$post])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
