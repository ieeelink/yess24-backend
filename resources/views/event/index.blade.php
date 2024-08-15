@php
function get_route($event)
{
    $home = route('home');
    $event_route = $event->type == 'Mentoring Session' ? '/events/mentoring-session/': '/events/';
    $event_id = $event->id;
    return $home . "/api" . $event_route . $event_id;
}

@endphp

<x-dashboard>

    <div>
        <ul role="list" class="divide-y divide-gray-100">
            @foreach($events as $event)
                <li class="flex justify-between gap-x-6 py-5">
                    <div class="flex min-w-0 gap-x-4">
                        <div class="min-w-0 flex-auto">
                            <p class="text-sm font-semibold leading-6 text-gray-900">{{ $event->name }}<span class="text-gray-300"> / {{ $event->slot }}</span></p>
                            <p class="mt-1 truncate text-xs leading-5 text-gray-500">{{ $event->type }}</p>
                        </div>
                    </div>
                    <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                        <p class="text-sm leading-6 text-gray-900">{{get_route($event)}}</p>
                        <a href="/events/{{ $event->id }}" class="text-blue-300 hover:text-blue-500">View Details</a>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</x-dashboard>
