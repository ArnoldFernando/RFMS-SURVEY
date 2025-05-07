<x-app-layout>
    @section('css')
        {{-- Boostrap CDN --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

        {{-- Google Fonts --}}
        <link
            href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
            rel="stylesheet">

        {{-- Database --}}
        <link rel="stylesheet" href="//cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
        <link rel="stylesheet" href="https://code.jquery.com/jquery-3.7.1.js">
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js">
        <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/js/dataTables.js">
        <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js">

        <style>
            body {
                font-family: 'Poppins';
            }
        </style>
    @stop

    @section('content_header')
        <h5 class="fw-semibold text-md">File</h5>
        <hr class="mt-0">
    @stop

    @section('content')
        <div class="container-fluid">

            <div class="d-flex justify-content-end align-items-center">
                <a href="{{ route('file.create') }}" class="btn btn-primary">Upload File</a>
            </div>
            <hr class="mt-2">
            <table class="table table-bordered table-striped" id="myTable">
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
                                <a href="{{ route('file.show', $file->id) }}" class="btn btn-info btn-sm">View</a>
                                <a href="{{ route('file.edit', $file->id) }}" class="btn btn-warning btn-sm">Process</a>
                                <form action="{{ route('file.destroy', $file->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure?');">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endsection
    @section('js')
        {{-- Js Script --}}
        <script src="{{ url('Js/script.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="//cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>
        <script>
            new DataTable('#myTable', {
                layout: {
                    topStart: {
                        pageLength: {
                            menu: [10, 25, 50, 100]
                        }
                    },
                    topEnd: {
                        search: {
                            placeholder: 'Type search here'
                        }
                    },
                    bottomEnd: {
                        paging: {
                            buttons: 3
                        }
                    }
                },
                language: {
                    lengthMenu: " _MENU_ Records per page",
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
        </script>

    @endsection
</x-app-layout>
