@props(['comment', 'url' => null, 'deleteUrl' => null])


<div class="flex space-x-4">
    <div class="flex-shrink-0">

        @if ($comment?->user?->profile?->image)
            <img src="{{ $comment?->user?->profile?->image }}" alt="Profile Picture" class="object-cover w-12 h-12 rounded-full" />
        @elseif ($comment?->user?->profilePicture)
            <img src="{{ $comment?->user?->profilePicture->file_dir }}" alt="Profile Picture"
                class="object-cover w-12 h-12 rounded-full" />
        @else
            <img src="https://ui-avatars.com/api/?name={{ urlencode($comment?->user?->name) }}&color=7F9CF5&background=EBF4FF"
                alt="Profile Picture" class="object-cover rounded-full" />
        @endif
    </div>
    
    <div class="flex-1">
        <div>
            <p class="font-semibold text-gray-800">{{ $comment->user->name }}</p>
            <p class="mb-1 text-sm text-gray-600">{{ $comment->created_at->diffForHumans() }}</p>
            <p class="p-4 text-gray-700 bg-gray-50 rounded-lg">{{ $comment->content }}</p>
        </div>


        <div class="flex gap-2 items-center">

            @if ($comment->user->id === Auth::user()->id)
                @if ($deleteUrl)
                    <form action="{{ $deleteUrl }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-sm font-semibold text-red-500 hover:underline">Delete</button>
                    </form>
                @endif
            @endif

        </div>


        <div x-data="{ open: false }" class="mt-2">
            <button @click="open = !open" class="text-sm font-semibold text-blue-500 hover:underline">Reply</button>
            <div x-show="open" x-cloak class="mt-3">
                <x-comment-form :commentable="$comment->commentable" :parentId="$comment->id" :url="$url" />
            </div>
        </div>

        @if ($comment->replies->isNotEmpty())
            <div class="pl-6 mt-4 space-y-4 border-l-2 border-gray-200">
                @foreach ($comment->replies as $reply)
                    <x-commentThread :comment="$reply" :key="$reply->id" :url="$url" :deleteUrl="route('student.announcements.comments.destroy', $reply->id)"/>
                @endforeach
            </div>
        @endif
    </div>
</div>
