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
        <h5 class="fw-semibold text-md">File Category List</h5>
        <hr class="mt-0">
    @stop

    @section('content')
        <div class="container-fluid">
            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('category.create') }}" class="btn btn-success">Add New Category</a>
            </div>
            <div class="row">
                @foreach ($filecategories as $category)
                    <div class="col-3 ">
                        <a href="{{ route('category.show', $category->id) }}">

                            <div class="card shadow-sm bg-primary text-white rounded-3">
                                <div
                                    class="card-body d-flex flex-column align-items-center justify-content-center text-center">
                                    <div class="mb-3">
                                        <i class="fa-solid fa-folder-open fa-3x text-light"></i>
                                    </div>
                                    <p class="card-title ">{{ $category->name }}</p>
                                </div>
                            </div>
                        </a>

                    </div>
                @endforeach
            </div>
        </div>
    @endsection

    @section('js')
        <!-- Scripts -->
        <script src="{{ url('Js/script.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
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
