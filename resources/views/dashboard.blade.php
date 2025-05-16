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


            .btn-sm {
                margin-right: 4px;
            }
        </style>
    @stop

    @section('content')
        <div class="container py-3">
            <h2 class="mb-4 fw-bold ">📁 File Status Dashboard</h2>

            <!-- Status Cards -->
            <div class="row g-4 mb-5">
                <!-- For Action -->
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-hourglass-split text-primary fs-1 me-3"></i>
                                <div>
                                    <h5 class="text-primary mb-0">For Action</h5>
                                    <h2 class="fw-bold">{{ $for_action }}</h2>
                                </div>
                            </div>
                            <p class="text-muted mb-0">Files waiting for action.</p>
                        </div>
                    </div>
                </div>

                <!-- Action Completed -->
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-check-circle-fill text-success fs-1 me-3"></i>
                                <div>
                                    <h5 class="text-success mb-0">Action Completed</h5>
                                    <h2 class="fw-bold">{{ $action_completed }}</h2>
                                </div>
                            </div>
                            <p class="text-muted mb-0">Files with completed actions.</p>
                        </div>
                    </div>
                </div>

                <!-- Archived -->
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-archive-fill text-secondary fs-1 me-3"></i>
                                <div>
                                    <h5 class="text-secondary mb-0">Archived</h5>
                                    <h2 class="fw-bold">{{ $archived }}</h2>
                                </div>
                            </div>
                            <p class="text-muted mb-0">Files moved to archive.</p>
                        </div>
                    </div>
                </div>
            </div>
            @php
                $current = \Carbon\Carbon::createFromDate($year, $month, 1);
                $prev = $current->copy()->subMonth();
                $next = $current->copy()->addMonth();
            @endphp
            <div class="container">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <a href="{{ route('dashboard', ['month' => $prev->format('m'), 'year' => $prev->format('Y')]) }}"
                        class="btn btn-outline-secondary">
                        ← {{ $prev->format('F Y') }}
                    </a>

                    <h4 class="mb-0 fw-bold">{{ $current->format('F Y') }}</h4>

                    <a href="{{ route('dashboard', ['month' => $next->format('m'), 'year' => $next->format('Y')]) }}"
                        class="btn btn-outline-secondary">
                        {{ $next->format('F Y') }} →
                    </a>
                </div>

                <div class="card shadow p-4">
                    <canvas id="fileStatusChart" height="200"></canvas>
                </div>
            </div>
        </div>
    @endsection

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('fileStatusChart').getContext('2d');

                const labels = @json($weeklyData->pluck('date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('M d')));
                const data = @json($weeklyData->pluck('count'));

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Completed Tasks',
                            data: data,
                            backgroundColor: '#198754',
                            borderRadius: 6,
                            barThickness: 40
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Completed Tasks for {{ $current->format('F Y') }}',
                                font: {
                                    size: 20
                                }
                            },
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endpush


</x-app-layout>
