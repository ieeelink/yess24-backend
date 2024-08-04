<x-dashboard>

    <div>
        <ul role="list" class="divide-y divide-gray-100">
            @foreach($registrants as $registrant)
                <li class="flex justify-between gap-x-6 py-5">
                    <div class="flex min-w-0 gap-x-4">
                        <div class="min-w-0 flex-auto">
                            <p class="text-sm font-semibold leading-6 text-gray-900">{{ $registrant->name }}</p>
                            <p class="mt-1 truncate text-xs leading-5 text-gray-500">{{ $registrant->email }} / {{ $registrant->phone }}</p>
                        </div>
                    </div>
                    <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                        <p class="text-sm leading-6 text-gray-900">{{ $registrant->college_name  }} / {{ $registrant->ticket_type }}</p>
                        <p class="mt-1 text-xs leading-5 text-gray-500">Last seen <time datetime="2023-01-23T13:23Z">3h ago</time></p>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</x-dashboard>
