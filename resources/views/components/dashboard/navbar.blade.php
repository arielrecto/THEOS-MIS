@props([
    'profile_url' => null,
])

<div class="w-full p-5 flex items-center  justify-between">
    <h1 class="text-xl font-bold text-accent capitalize">
        Dashboard {{ Auth::user()->name }}
    </h1>
    <div>

        <div class="dropdown">
            <div tabindex="0" role="button" class="btn btn-ghost m-1">
                <img src="{{ Auth::user()->profile->image ?? asset('sticker/man.png') }}" alt="" srcset=""
                    class="h-12 w-12 object-cover rounded-full">
            </div>
            <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">

                @if ($profile_url !== null)
                    <li>
                        <a href="{{ $profile_url }}">
                            Profile
                        </a>
                    </li>
                @endif

                <li>
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button>logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
