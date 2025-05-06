<x-app-layout>


    <div class="container">
        <h1>Edit File</h1>

        <a href="{{ route('file.index') }}" class="btn btn-secondary mb-3">Back to file</a>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('file.update', $file->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="file_name" class="form-label">File Name</label>
                <input type="text" name="file_name" id="file_name" class="form-control"
                    value="{{ old('file_name', $file->file_name) }}" required>
            </div>

            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" name="location" id="location" class="form-control"
                    value="{{ old('location', $file->location) }}" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control">{{ old('description', $file->description) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="file" class="form-label">Replace File (Optional)</label>
                <input type="file" name="file" id="file" class="form-control">
                @if ($file->file)
                    <p>Current File: <a href="{{ asset('storage/' . $file->file) }}"
                            target="_blank">{{ $file->file }}</a></p>
                @endif
            </div>

            <div class="mb-3">
                <label for="civil_case_number" class="form-label">Civil Case Number</label>
                <input type="text" name="civil_case_number" id="civil_case_number" class="form-control"
                    value="{{ old('civil_case_number', $file->civil_case_number) }}" required>
            </div>

            <div class="mb-3">
                <label for="lot_number" class="form-label">Lot Number</label>
                <input type="text" name="lot_number" id="lot_number" class="form-control"
                    value="{{ old('lot_number', $file->lot_number) }}" required>
            </div>





            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="pending" {{ $file->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ $file->status == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ $file->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    <option value="deleted" {{ $file->status == 'deleted' ? 'selected' : '' }}>Deleted</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label">File Category</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ $file->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update File</button>
        </form>
    </div>


</x-app-layout>
