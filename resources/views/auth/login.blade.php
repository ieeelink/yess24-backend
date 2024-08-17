<x-layout>
    <div class="w-[500px] flex flex-col justify-center bg-white p-[40px] rounded-2xl shadow-lg">
        <h1 class="text-4xl font-semibold mb-2">Login</h1>
        <div class="">
            <form action="/login" method="post">
                @csrf
                <div class="flex flex-col mb-4">
                    <input id="email" name="email" type="email" placeholder="Enter your email" required
                           class=" p-4 rounded-xl focus-visible:outline-0 flex-1 bg-gray-50 border-gray-200 border" >
                    @error('email')<p class="ms-4 text-sm text-red-500">{{$message}}</p>@enderror
                </div>
                <div class="flex flex-col mb-6">
                    <input id="password" name="password" type="password" placeholder="Enter your password" required
                           class=" p-4 rounded-xl focus-visible:outline-0 flex-1 bg-gray-50 border-gray-200 border" >
                    @error('password')<p class="ms-4 text-sm text-red-500">{{$message}}</p>@enderror
                </div>
                <div class="flex justify-center items-center">
                    <button type="submit" class="w-3/5 py-2 px-4 rounded-xl bg-gray-100 hover:bg-gray-50 mx-auto font-semibold text-black/60">Login</button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
