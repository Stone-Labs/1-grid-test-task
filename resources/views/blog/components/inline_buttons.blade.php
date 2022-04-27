@php
    /**
     * @var \App\Models\Post $post
     * @var \App\Models\User $user
     */
@endphp

@if($user && $post->user_id === $user->id)
    <div class="sm:flex sm:items-center sm:ml-6">
        <form method="POST" action="{{ route('blog.destroy',$post->id) }}" enctype="multipart/form-data">
            @csrf
            @method('DELETE')
            <input type="submit"
                   class="button_delete inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 text-red-600"
                   value="{{ __('DELETE') }}">
        </form>
    </div>
    <div class="sm:flex sm:items-center sm:ml-6">
        <a class="button_edit inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 text-indigo-600"
           href="{{ route('blog.edit',$post->id) }}">
            {{ __('Edit') }}
        </a>
    </div>
@endif
<div class="sm:flex sm:items-center sm:ml-6">
    <a class="button_view inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 text-green-600"
       href="{{ route('blog.show',$post->slug) }}">
        {{ __('View more...') }}
    </a>
</div>
