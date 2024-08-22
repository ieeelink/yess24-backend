<x-dashboard>
    <div class="flex justify-center items-center max-h-svh">
        <form action="/events" method="post">
            @csrf
            <div class="w-[500px] space-y-8">

                <div class="sm:col-span-2">
                    <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Event Name</label>
                    <div class="mt-2">
                        <input type="text" name="name" id="name" autocomplete="name" class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="type" class="block text-sm font-medium leading-6 text-gray-900">Event Type</label>
                    <div class="mt-2">
                        <input type="text" name="type" id="type" autocomplete="type" class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="description" class="block text-sm font-medium leading-6 text-gray-900">Event Description</label>
                    <div class="mt-2">
                        <input type="text" name="description" id="description" autocomplete="description" class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="slot" class="block text-sm font-medium leading-6 text-gray-900">Slot</label>
                    <div class="mt-2">
                        <input type="number" name="slot" id="slot" autocomplete="slot" class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Submit</button>
                </div>
            </div>
        </form>
    </div>

</x-dashboard>
