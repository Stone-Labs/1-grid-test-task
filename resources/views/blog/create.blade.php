@php
    $previous = url()->previous();
@endphp
<x-app-layout>
    <div class="post_item">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create Post') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="post_item p-6 bg-white border-b border-gray-200">
                        <form method="POST" action="{{ route('blog.store') }}">
                        @csrf
                            <div class="pb-3">
                                <x-label for="title" :value="__('Title')" />

                                <x-input id="title" class="block mt-1 w-full"
                                         name="title" :value="old('title')" required autofocus />
                            </div>
                            <div class="pb-3">
                                <x-label for="slug" :value="__('Slug')" />

                                <x-input id="slug" class="block mt-1 w-full"
                                         name="slug" :value="old('slug')" required/>
                                @if ($errors->has('slug'))
                                    <small class="text-danger">{{ $errors->first('slug') }}</small>
                                @endif
                            </div>

                            <div class="form-group">
                                <x-label for="content" :value="__('Content')" />
                                <textarea style="min-height:400px; width: 100%;"
                                          class="form-control"
                                          id="content"
                                          name="content">{{old("content")}}</textarea>
                            </div>
                            <x-button class="ml-3">
                                {{ __('Save') }}
                            </x-button>
                            <x-nav-link :href="$previous" style="color: blueviolet;">
                                {{ __('Cancel') }}
                            </x-nav-link>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
