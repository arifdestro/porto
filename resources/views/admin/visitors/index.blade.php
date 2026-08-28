@extends('layouts.admin')

@section('title', 'Visitor Analytics')

@push('styles')
<style>
    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
    }
</style>
@endpush

@section('content')
<!-- <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">Visitor Analytics</h2>
</div> -->

<!-- Chart Card -->
<div class="admin-card">
    <div class="admin-card-body">
        <h5 class="card-title fw-bold mb-4">Visits (Last 7 Days)</h5>
        <div class="chart-container">
            <canvas id="visitorChart"></canvas>
        </div>
    </div>
</div>

<!-- Data Table Card -->
<div class="admin-card">
    <div class="admin-card-header">
        <h5 class="card-title fw-bold">Recent Visitors</h5>
    </div>
    <div class="admin-card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-body-tertiary">
                    <tr>
                        <th class="ps-4">IP Address</th>
                        <th>Page Visited</th>
                        <th>Browser / OS</th>
                        <th class="text-end pe-4">Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($visitors as $visitor)
                        <tr>
                            <td class="ps-4">
                                <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary-subtle">
                                    {{ $visitor->ip_address ?: 'Unknown' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ url($visitor->page_visited) }}" target="_blank" class="text-decoration-none">
                                    {{ \Illuminate\Support\Str::limit($visitor->page_visited, 40) }}
                                </a>
                            </td>
                            <td>
                                <small class="text-muted d-block" style="max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $visitor->user_agent }}">
                                    {{ $visitor->user_agent ?: 'Unknown' }}
                                </small>
                            </td>
                            <td class="text-end pe-4">
                                <small class="text-muted">{{ $visitor->created_at->diffForHumans() }}</small>
                                <div class="small text-muted" style="font-size: 0.7rem;">{{ $visitor->created_at->format('d M Y, H:i') }}</div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                No visitor data available yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($visitors->hasPages())
        <div class="card-footer bg-transparent border-0 pt-3 pb-3 pe-4">
            {{ $visitors->links() }}
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById('visitorChart').getContext('2d');
    
    // Check if we are in dark mode to adjust chart colors
    const isDarkMode = document.documentElement.getAttribute('data-bs-theme') === 'dark';
    const textColor = isDarkMode ? '#adb5bd' : '#6c757d';
    const gridColor = isDarkMode ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.05)';
    
    // Gradient for the area chart
    let gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(13, 110, 253, 0.5)'); // Primary color with opacity
    gradient.addColorStop(1, 'rgba(13, 110, 253, 0.0)');

    const chartData = {
        labels: {!! json_encode($chartLabels) !!},
        datasets: [{
            label: 'Daily Visitors',
            data: {!! json_encode($chartData) !!},
            fill: true,
            backgroundColor: gradient,
            borderColor: '#0d6efd',
            borderWidth: 2,
            pointBackgroundColor: '#fff',
            pointBorderColor: '#0d6efd',
            pointBorderWidth: 2,
            pointRadius: 4,
            pointHoverRadius: 6,
            tension: 0.4 // Makes the line smooth/curved
        }]
    };

    const config = {
        type: 'line',
        data: chartData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false // Hide legend since we only have one dataset
                },
                tooltip: {
                    backgroundColor: isDarkMode ? '#212529' : '#fff',
                    titleColor: isDarkMode ? '#fff' : '#000',
                    bodyColor: isDarkMode ? '#adb5bd' : '#6c757d',
                    borderColor: isDarkMode ? '#495057' : '#dee2e6',
                    borderWidth: 1,
                    padding: 10,
                    displayColors: false,
                    intersect: false,
                    mode: 'index',
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        color: textColor
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: gridColor,
                        drawBorder: false
                    },
                    ticks: {
                        color: textColor,
                        precision: 0 // Only show integers
                    }
                }
            },
            interaction: {
                mode: 'nearest',
                axis: 'x',
                intersect: false
            }
        }
    };

    let visitorChart = new Chart(ctx, config);

    // Listen for theme changes to update chart colors dynamically
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.attributeName === "data-bs-theme") {
                const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
                const newTextColor = isDark ? '#adb5bd' : '#6c757d';
                const newGridColor = isDark ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.05)';
                
                visitorChart.options.scales.x.ticks.color = newTextColor;
                visitorChart.options.scales.y.ticks.color = newTextColor;
                visitorChart.options.scales.y.grid.color = newGridColor;
                visitorChart.options.plugins.tooltip.backgroundColor = isDark ? '#212529' : '#fff';
                visitorChart.options.plugins.tooltip.titleColor = isDark ? '#fff' : '#000';
                visitorChart.options.plugins.tooltip.bodyColor = isDark ? '#adb5bd' : '#6c757d';
                visitorChart.options.plugins.tooltip.borderColor = isDark ? '#495057' : '#dee2e6';
                
                visitorChart.update();
            }
        });
    });

    observer.observe(document.documentElement, {
        attributes: true,
        attributeFilter: ['data-bs-theme']
    });
});
</script>
@endpush
