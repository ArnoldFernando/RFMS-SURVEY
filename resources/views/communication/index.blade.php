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

    @section('content_header')
        <h5 class="fw-semibold text-md">All Communication</h5>
        <hr class="mt-0">
    @stop

    @section('content')
        <div class="container-fluid">
            <div class="d-flex justify-content-end mb-3 gap-2">

                <form method="GET" action="{{ route('communication.export') }}">
                    <button type="submit" class="btn btn-success">
                        <i class="fa-solid fa-file-export"></i></i> Export to Excel
                    </button>
                </form>
                <a href="{{ route('communication.create') }}" class="btn btn-primary"><i class="bi bi-upload"></i> Upload
                    File</a>
            </div>

            <table class="table table-bordered table-striped table-hover" id="myTable" style="width: 100%;">
                <thead>
                    <tr>
                        <th></th>
                        <th>File Name</th>
                        <th>Tracking No.</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php $counter = 1; @endphp
                    @foreach ($files as $file)
                        <tr>
                            <td>{{ $counter++ }}</td>
                            @php
                                $words = explode(' ', $file->file_name);
                                $chunked = array_chunk($words, 5); // change 4 to however many words per line you want
                                $formattedFileName = collect($chunked)
                                    ->map(fn($chunk) => implode(' ', $chunk))
                                    ->implode('<br>');
                            @endphp

                            <td>{!! $formattedFileName !!}</td>


                            <td>{{ $file->tracking_number }}</td>
                            <td>
                                {!! wordwrap(e($file->location), 20, '<br>') !!}
                            </td>
                            <td>{{ ucfirst($file->status) }}</td>
                            <td>
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewModal"
                                    data-id="{{ $file->id }}" data-file_name="{{ $file->file_name }}"
                                    data-tracking_number="{{ $file->tracking_number }}"
                                    data-location="{{ $file->location }}" data-description="{{ $file->description }}"
                                    data-status="{{ $file->status }}">
                                    View
                                </button>

                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal"
                                    data-id="{{ $file->id }}" data-file_name="{{ $file->file_name }}"
                                    data-tracking_number="{{ $file->tracking_number }}"
                                    data-location="{{ $file->location }}" data-description="{{ $file->description }}"
                                    data-status="{{ $file->status }}">
                                    Edit
                                </button>

                                @if ($file->file && file_exists(storage_path('app/public/' . $file->file)))
                                    <a href="{{ route('communication.download', $file->id) }}"
                                        class="btn btn-success">Download</a>
                                @else
                                    No file available
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if (isset($file))
            <!-- Edit Modal -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <form action="{{ route('communication.update', $file->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="edit-id">
                        <div class="modal-content">
                            <div class="modal-header bg-warning text-dark">
                                <h5 class="modal-title" id="editModalLabel">Edit File</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body row g-3">
                                <div class="col-md-6">
                                    <label for="edit-file_name" class="form-label">File Name</label>
                                    <input type="text" class="form-control" name="file_name" id="edit-file_name"
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <label for="edit-tracking_number" class="form-label">Tracking No.</label>
                                    <input type="text" class="form-control" name="tracking_number"
                                        id="edit-tracking_number" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="edit-location" class="form-label">Location</label>
                                    <input type="text" class="form-control" name="location" id="edit-location" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="edit-status" class="form-label">Status</label>
                                    <select class="form-select" name="status" id="edit-status">
                                        <option value="in_coming">INCOMING</option>
                                        <option value="out_going">OUTGOING</option>

                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="edit-date" class="form-label">Date</label>
                                    <input type="date" class="form-control" name="date" id="edit-date"
                                        value="{{ old('date') }}" required>
                                </div>
                                <div class="col-12">
                                    <label for="edit-description" class="form-label">Description</label>
                                    <textarea class="form-control" name="description" id="edit-description" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-warning">Update</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        <!-- View Modal -->
        <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="viewModalLabel">File Details</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <dl class="row">
                            <dt class="col-sm-4">File Name</dt>
                            <dd class="col-sm-8" id="modal-file_name"></dd>

                            <dt class="col-sm-4">Tracking No.</dt>
                            <dd class="col-sm-8" id="modal-tracking_number"></dd>

                            <dt class="col-sm-4">Location</dt>
                            <dd class="col-sm-8" id="modal-location"></dd>

                            <dt class="col-sm-4">Description</dt>
                            <dd class="col-sm-8" id="modal-description"></dd>

                            <dt class="col-sm-4">Status</dt>
                            <dd class="col-sm-8" id="modal-status"></dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    @endsection

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
                $('#modal-tracking_number').text(button.data('tracking_number'));
                $('#modal-location').text(button.data('location'));
                $('#modal-description').text(button.data('description'));

                $('#modal-status').text(button.data('status'));
            });


            // Populate Edit Modal
            $('#editModal').on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget);

                $('#edit-id').val(button.data('id'));
                $('#edit-file_name').val(button.data('file_name'));
                $('#edit-tracking_number').val(button.data('tracking_number'));
                $('#edit-location').val(button.data('location'));
                $('#edit-description').val(button.data('description'));
                $('#edit-status').val(button.data('status'));
            });
        </script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
                    confirmButtonText: 'OK'
                });
            @endif
        </script>

    @endsection
</x-app-layout>
