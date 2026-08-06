{{-- 
    Reusable attachment upload form.
    Include from any module's edit view like:
    @include('attachment::_upload_form', ['attachable' => $announcement])
--}}
<form action="{{ route('attachments.store') }}" method="POST" enctype="multipart/form-data" class="mb-4">
    @csrf
    <input type="hidden" name="attachable_type" value="{{ get_class($attachable) }}">
    <input type="hidden" name="attachable_id" value="{{ $attachable->id }}">

    <div class="flex items-center gap-2">
        <input type="file" name="file" required
               class="block w-full text-sm border border-gray-300 rounded-lg cursor-pointer">
        <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">
            Upload
        </button>
    </div>

    @error('file')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
</form>