<x-app-layout>

    @section('css')
        <!-- Bootstrap 5 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
        <style>
            body {
                font-family: 'Poppins', sans-serif;
                background-color: #f8f9fa;
            }

            .table th,
            .table td {
                vertical-align: middle;
            }

            .table thead {
                background-color: #343a40;
                color: #fff;
            }

            .btn-sm {
                margin-right: 4px;
            }
        </style>
    @stop



    <div class="container">
        <h1>Edit File</h1>

        {{--  <a href="{{ route('file.index') }}" class="btn btn-secondary mb-3">Back to file</a>  --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('status.update', $file->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="file_name" class="form-label">File Name</label>
                    <input type="text" name="file_name" id="file_name" class="form-control"
                        value="{{ old('file_name', $file->file_name) }}" disabled>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" name="location" id="location" class="form-control"
                        value="{{ old('location', $file->location) }}" disabled>
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" disabled>{{ old('description', $file->description) }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="file" class="form-label">Replace File (Optional)</label>
                    <input type="file" name="file" id="file" class="form-control" disabled>
                    @if ($file->file)
                        <p>Current File: <a href="{{ asset('storage/' . $file->file) }}"
                                target="_blank">{{ $file->file }}</a></p>
                    @endif
                </div>

                <div class="col-md-3 mb-3">
                    <label for="civil_case_number" class="form-label">Civil Case Number</label>
                    <input type="text" name="civil_case_number" id="civil_case_number" class="form-control"
                        value="{{ old('civil_case_number', $file->civil_case_number) }}" disabled>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="lot_number" class="form-label">Lot Number</label>
                    <input type="text" name="lot_number" id="lot_number" class="form-control"
                        value="{{ old('lot_number', $file->lot_number) }}" disabled>
                </div>
            </div>

            <div class="row">


                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="for_action" {{ $file->status == 'for_action' ? 'selected' : '' }}>For Action
                        </option>
                        <option value="action_completed" {{ $file->status == 'action_completed' ? 'selected' : '' }}>
                            Action Completed
                        </option>
                        <option value="archived" {{ $file->status == 'archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="category_id" class="form-label">File Category</label>
                    <select name="category_id" id="category_id" class="form-control" disabled>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ $file->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Update File</button>
                <button type="button" class="btn btn-secondary" onclick="window.history.back()">Go Back</button>
            </div>

        </form>
    </div>

    @section('js')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.min.js"></script>

        <script>
            // Initialize DataTable
            new DataTable('#myTable', {
                responsive: true,
                layout: {
                    topStart: {
                        pageLength: {
                            menu: [10, 25, 50, 100]
                        }
                    },
                    topEnd: {
                        search: {
                            placeholder: 'Search records...'
                        }
                    }
                },
                language: {
                    lengthMenu: " _MENU_ records per page",
                    info: "Showing _START_ to _END_ of _TOTAL_ records",
                    infoEmpty: "No records available",
                    infoFiltered: "(filtered from _MAX_ total records)",
                    search: "Search:",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous"
                    }
                }
            });

            // Populate modal with data attributes
            $('#viewModal').on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget);
                $('#modal-file_name').text(button.data('file_name'));
                $('#modal-location').text(button.data('location'));
                $('#modal-description').text(button.data('description'));
                $('#modal-civil_case_number').text(button.data('civil_case_number'));
                $('#modal-lot_number').text(button.data('lot_number'));
                $('#modal-status').text(button.data('status'));
            });
        </script>
    @endsection
</x-app-layout>
