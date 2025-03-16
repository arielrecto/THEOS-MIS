<x-dashboard.admin.base>
    <x-dashboard.page-title :title="_('users')"/>
    <div class="panel">
        <div class="grid grid-cols-2 grid-flow-row h-64 gap-5">
            <a href="{{route('admin.users.students.index')}}" class="w-full h-full gap-2 rounded-lg border border-accent flex">
                <img src="{{asset('sticker/go-to-school.png')}}" class="object-cover w-1/2 h-auto" />
                <div class="flex flex-col gap-5 w-full">
                    <h1 class="text-2xl font-bold py-5">
                        Student
                    </h1>
                    <p class="text-6xl font-bold text-accent text-center ">
                        {{count($students)}}
                    </p>
                </div>
            </a>
            <a href="{{route('admin.users.teacher.index')}}" class="w-full h-full gap-2 rounded-lg border border-accent flex">
                <img src="{{asset('sticker/teacher.png')}}" class="object-cover w-1/2 h-auto" />
                <div class="flex flex-col gap-5 w-full">
                    <h1 class="text-2xl font-bold py-5">
                        teacher
                    </h1>
                    <p class="text-6xl font-bold text-accent text-center ">
                        {{count($teachers)}}
                    </p>
                </div>
            </a>
        </div>
    </div>
</x-dashboard.admin.base>
