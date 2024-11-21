@extends('layouts.app')

@section('content')
    <div class="bg-white px-6 py-32 lg:px-8">
        <div class="mx-auto max-w-3xl text-base/7 text-gray-700">
            <h1 class="mt-2 text-pretty text-4xl font-semibold tracking-tight text-gray-900 sm:text-5xl">{{ $post->title }}</h1>
            <p class="mt-6 text-xl/8">{{ $post->excerpt }}</p>
            <figure class="mt-16">
                <img class="aspect-video rounded-xl bg-gray-50 object-cover"
                    src="{{ $post->image }}"
                    alt="">
            </figure>
            <div class="mt-16 max-w-2xl">
                <p class="mt-6">{{ $post->body }}</p>
            </div>
            <div>
                By {{ $post->author->name }}
            </div>
            <!-- Comments Section -->
            <div class="mt-16">
                <h2 class="text-2xl font-semibold text-gray-900">Comments</h2>
                @if ($comments->isEmpty())
                    <p class="mt-4 text-gray-500">No comments yet. Be the first to comment!</p>
                @else
                    <ul>
                        @foreach ($comments as $comment)
                            <li class="mt-4">
                                <p class="text-sm text-gray-500">
                                    {{ $comment->created_at->diffForHumans() }}
                                </p>
                                <p class="text-sm text-gray-800 font-semibold">{{ $comment->name }}</p>
                                <p class="text-gray-600">{{ $comment->body }}</p>
                                <form method="POST" action="{{ route('comment.delete',  $comment->id) }}" class="inline-block mt-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline">Delete</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
            <!-- Comment Form -->
            <div class="mt-16">
                <h2 class="text-2xl font-semibold text-gray-900">Leave a Comment</h2>
                <form id="comment-form" method="POST" action="{{ route('comment', $post) }}">
                    @csrf
                    <div class="mt-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Your Name</label>
                        <input id="name" required name="name" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div class="mt-4">
                        <label for="body" class="block text-sm font-medium text-gray-700">Your Comment</label>
                        <textarea id="body" required name="body" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    </div>
                    <div class="mt-6">
                        <button type="submit" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-gray-700 hover:bg-indigo-700 border-gray-300 shadow-sm">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
