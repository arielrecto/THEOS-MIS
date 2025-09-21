@props([
    'commentable',
    'parentId' => null,
    'url' => null,
])


<form action="{{ $url }}" method="POST">
    @csrf
    <input type="hidden" name="commentable_type" value="{{ get_class($commentable) }}">
    <input type="hidden" name="commentable_id" value="{{ $commentable->id }}">
    
    <input type="hidden" name="parent_id" value="{{ $parentId }}">

    <div class="mb-4">
        <textarea name="content" rows="3" class="w-full rounded-md border-gray-300 shadow-sm" placeholder="Write a comment..." required></textarea>
    </div>

    <div>
        <button type="submit" class="px-4 py-2 font-semibold text-white bg-blue-600 rounded-md hover:bg-blue-700">
            {{ $parentId ? 'Post Reply' : 'Post Comment' }}
        </button>
    </div>
</form>