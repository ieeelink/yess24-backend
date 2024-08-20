<x-dashboard>
    <p>
        @error('csv_file')
            {{$message}}
        @enderror
    </p>
    <div class="flex justify-center items-center max-h-svh">
        <form action="/registrations" method="post" enctype="multipart/form-data">
            @csrf
            <div class="w-[500px] space-y-8">
                <div class="col-span-full">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="csv_file">Upload file</label>
                    <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="csv_file" name="csv_file" type="file">
                </div>

                <div class="sm:col-span-3">
                    <label for="ticket_type" class="block text-sm font-medium leading-6 text-gray-900">Ticket Type</label>
                    <div class="mt-2">
                        <select id="ticket_type" name="ticket_type" autocomplete="ticket-type" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                            <option value="Early Bird">Early Bird</option>
                            <option value="Normal Registration">Normal Registration</option>
                        </select>
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label for="is_ieee" class="block text-sm font-medium leading-6 text-gray-900">List of IEEE or Non IEEE</label>
                    <div class="mt-2">
                        <select id="is_ieee" name="is_ieee" autocomplete="is_ieee" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                            <option value="true">IEEE</option>
                            <option value="false">Non IEEE</option>
                        </select>
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="count" class="block text-sm font-medium leading-6 text-gray-900">Count</label>
                    <div class="mt-2">
                        <input type="number" name="count" id="count" autocomplete="count" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Submit</button>
                </div>
            </div>
        </form>
    </div>

</x-dashboard>
