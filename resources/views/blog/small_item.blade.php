@php
/**
 * @var \App\Models\Post $post
 */
@endphp

<div class="small_item">
    <div class="title">{{ $post->title }}</div>
    <hr/>
    <div class="content">{{ Str::limit($post->content,300) }}</div>
    <div class="footer">
        <div class="flex justify-between h-12">
            <div class="flex">
                <div class="created_at space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <p class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-900">
                        Created: {{ $post->created_at }}
                    </p>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="sm:flex sm:items-center sm:ml-6">
                <x-nav-link :href="route('blog.show',$post->slug)" style="color: blueviolet;">
                    {{ __('View more...') }}
                </x-nav-link>
            </div>

        </div>

    </div>

</div>
