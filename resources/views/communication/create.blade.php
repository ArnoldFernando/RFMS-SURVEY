<x-app-layout>
    @section('css')
        {{-- Boostrap CDN --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

        {{-- Google Fonts --}}
        <link
            href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
            rel="stylesheet">
        <style>
            body {
                font-family: 'Poppins';
            }
        </style>
    @stop

    @section('content_header')
        <h5 class="fw-semibold text-md">Upload File</h5>
        <hr class="mt-0">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    @stop

    @section('content')
        <div class="container-fluid">
            <form action="{{ route('communication.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="mb-3">
                            <label for="file_name" class="form-label">File Name</label>
                            <input type="text" name="file_name" id="file_name" class="form-control"
                                value="{{ old('file_name') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="mb-3">
                            <label for="tracking_number" class="form-label">Tracking Number</label>
                            <input type="text" name="tracking_number" id="tracking_number" class="form-control"
                                value="{{ old('tracking_number') }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" name="location" id="location" class="form-control"
                                value="{{ old('location') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="in_coming" selected>INCOMING</option>
                                <option value="out_going">OUT GOING</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="file" class="form-label">Upload File</label>
                            <input type="file" name="file" id="file" class="form-control">
                        </div>
                    </div>
                </div>


                <div class="d-flex justify-content-end align-items-center">
                    <button type="submit" class="btn btn-success me-2">Upload File</button>
                    <a href="{{ route('communication.index') }}" class="btn btn-secondary">Cancel</a>
                </div>

            </form>
        </div>
    @endsection
    @section('js')
        {{-- Js Script --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script src="{{ url('Js/script.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
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
