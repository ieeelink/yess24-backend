<x-dashboard>
    <div class="flex space-x-7">
        <div>
            <h2 class="text-2xl">Total Attendees</h2>
            <p class="text-center">{{ $no_of_attendees }}</p>
        </div>
        <div>
            <h2 class="text-2xl">Total Certificate Downloaded</h2>
            <p class="text-center">{{ $no_of_certificates_downloaded }}</p>
        </div>
        <div>
            <h2 class="text-2xl">Total Attendees Left to Download</h2>
            <p class="text-center">{{ $no_of_attendees - $no_of_certificates_downloaded }}</p>
        </div>
    </div>
    <div class="mt-4">
        <a href="/certificates/download" class="text-blue-500 hover:underline">Download List of Participants Not Downloaded Certificate</a>
    </div>
</x-dashboard>
