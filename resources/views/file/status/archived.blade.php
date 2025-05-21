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
        <h5 class="fw-semibold text-md">File Management</h5>
        <hr class="mt-0">
    @stop

    @section('content')
        <div class="container-fluid">
            <div class="d-flex justify-content-end align-items-center mb-3 gap-2">
                <form method="GET" action="{{ route('files.export') }}">
                    <input type="hidden" name="status" value="archived">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-file-earmark-excel"></i> Export to Excel
                    </button>
                </form>
                <a href="{{ route('file.create') }}" class="btn btn-primary">
                    <i class="bi bi-upload"></i> Upload File
                </a>
            </div>
            <table class="table table-bordered table-striped table-hover" id="myTable" style="width: 100%;">
                <thead>
                    <tr>
                        <th>File Name</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($files as $file)
                        <tr>
                            <td>{{ $file->file_name }}</td>
                            <td>{{ $file->location }}</td>
                            <td>{{ ucfirst($file->status) }}</td>
                            <td>
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewModal"
                                    data-id="{{ $file->id }}" data-file_name="{{ $file->file_name }}"
                                    data-location="{{ $file->location }}" data-description="{{ $file->description }}"
                                    data-civil_case_number="{{ $file->civil_case_number }}"
                                    data-lot_number="{{ $file->lot_number }}" data-status="{{ $file->status }}">
                                    View
                                </button>

                                <a href="{{ route('status.edit', $file->id) }}" class="btn btn-warning btn-sm">Process</a>

                                @if ($file->file && file_exists(storage_path('app/public/' . $file->file)))
                                    <a href="{{ route('files.download', $file->id) }}" class="btn btn-success">Download</a>
                                @else
                                    No file available
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

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

                            <dt class="col-sm-4">Location</dt>
                            <dd class="col-sm-8" id="modal-location"></dd>

                            <dt class="col-sm-4">Description</dt>
                            <dd class="col-sm-8" id="modal-description"></dd>

                            <dt class="col-sm-4">Civil Case Number</dt>
                            <dd class="col-sm-8" id="modal-civil_case_number"></dd>

                            <dt class="col-sm-4">Lot Number</dt>
                            <dd class="col-sm-8" id="modal-lot_number"></dd>

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
                $('#modal-location').text(button.data('location'));
                $('#modal-description').text(button.data('description'));
                $('#modal-civil_case_number').text(button.data('civil_case_number'));
                $('#modal-lot_number').text(button.data('lot_number'));
                $('#modal-status').text(button.data('status'));
            });
        </script>
    @endsection
</x-app-layout>
