{{-- 
    Reusable attachment list with delete buttons.
    Include from any module's edit view like:
    @include('attachment::_list', ['attachable' => $announcement])
--}}
<ul class="divide-y divide-gray-200 border rounded-lg">
    @forelse ($attachable->attachments as $attachment)
        <li class="flex items-center justify-between p-3">
            <a href="{{ $attachment->url }}" target="_blank" class="text-blue-600 hover:underline text-sm">
                {{ $attachment->file_name }}
            </a>

            <form action="{{ route('attachments.destroy', $attachment) }}" method="POST"
                  onsubmit="return confirm('Delete this file?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 text-sm hover:underline">
                    Delete
                </button>
            </form>
        </li>
    @empty
        <li class="p-3 text-sm text-gray-500">No files attached.</li>
    @endforelse
</ul>