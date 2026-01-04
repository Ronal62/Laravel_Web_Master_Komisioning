@extends('layout.app')

@section('title', 'Dashboard')

@section('content')
<div class="page-inner">
    {{-- Header Section --}}
    <div class="d-flex align-items-center justify-content-between flex-wrap pt-2 pb-4">
        <div>
            <h3 class="fw-bold mb-1">Dashboard</h3>
            <h6 class="text-muted mb-0">Commissioning Result - {{ $displayMonth }}</h6>
        </div>
        <div class="d-flex gap-3 flex-wrap align-items-end">
            <div>
                <label for="filter-date" class="form-label small mb-1">Pilih Tanggal</label>
                <input type="date" id="filter-date" class="form-control" value="{{ $selectedDate }}">
            </div>
            <div>
                <label for="filter-month" class="form-label small mb-1">Pilih Bulan</label>
                <input type="month" id="filter-month" class="form-control" value="{{ $selectedMonth }}">
            </div>
            <div>
                <button type="button" id="btn-apply-filter" class="btn btn-primary">
                    <i class="fas fa-sync-alt me-1"></i> Apply Filter
                </button>
            </div>
        </div>
    </div>

    {{-- Main Summary Cards --}}
    <div class="row g-3 mb-4">
        {{-- Keypoint Summary Card --}}
        <div class="col-xl-6 col-lg-6 col-md-12">
            <div class="card card-stats card-round h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="icon-big text-center icon-primary bubble-shadow-small">
                                <i class="fa-solid fa-tower-broadcast"></i>
                            </div>
                        </div>
                        <div class="col">
                            <h5 class="card-category text-muted mb-1">Total Keypoint</h5>
                            <h3 class="card-title fw-bold mb-0">{{ number_format($keypointTotal) }}</h3>
                        </div>
                        <div class="col-auto text-end">
                            <div class="mb-2">
                                <span class="badge bg-info">Harian: {{ number_format($keypointDaily) }}</span>
                            </div>
                            <div>
                                <span class="badge bg-success">Bulanan: {{ number_format($keypointMonthly) }}</span>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex gap-2 flex-wrap">
                        <button class="btn btn-outline-primary btn-sm" onclick="navigateTo('keypoint', 'daily')">
                            <i class="fas fa-calendar-day me-1"></i> Detail Harian
                        </button>
                        <button class="btn btn-outline-success btn-sm" onclick="navigateTo('keypoint', 'monthly')">
                            <i class="fas fa-calendar-alt me-1"></i> Detail Bulanan
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Penyulang Summary Card --}}
        <div class="col-xl-6 col-lg-6 col-md-12">
            <div class="card card-stats card-round h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="icon-big text-center icon-warning bubble-shadow-small">
                                <i class="fa-solid fa-bolt"></i>
                            </div>
                        </div>
                        <div class="col">
                            <h5 class="card-category text-muted mb-1">Total Penyulang</h5>
                            <h3 class="card-title fw-bold mb-0">{{ number_format($penyulangTotal) }}</h3>
                        </div>
                        <div class="col-auto text-end">
                            <div class="mb-2">
                                <span class="badge bg-info">Harian: {{ number_format($penyulangDaily) }}</span>
                            </div>
                            <div>
                                <span class="badge bg-success">Bulanan: {{ number_format($penyulangMonthly) }}</span>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex gap-2 flex-wrap">
                        <button class="btn btn-outline-primary btn-sm" onclick="navigateTo('penyulangan', 'daily')">
                            <i class="fas fa-calendar-day me-1"></i> Detail Harian
                        </button>
                        <button class="btn btn-outline-success btn-sm" onclick="navigateTo('penyulangan', 'monthly')">
                            <i class="fas fa-calendar-alt me-1"></i> Detail Bulanan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Keypoint Section --}}
    <div class="mb-4">
        <h5 class="fw-bold mb-3">
            <i class="fa-solid fa-tower-broadcast text-primary me-2"></i>Keypoint
        </h5>
        <div class="row g-3">
            {{-- Gardu Induk - Harian --}}
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats card-round h-100 border-start border-primary border-4">
                    <div class="card-body">
                        <h6 class="card-title fw-bold mb-2">Gardu Induk</h6>
                        <p class="text-muted small mb-2">Harian ({{ $displayDate }})</p>
                        <h4 class="fw-bold text-primary mb-3">{{ number_format($keypointGarduIndukDaily) }}</h4>
                        <button class="btn btn-primary btn-sm w-100"
                            onclick="navigateTo('keypoint', 'daily', 'gardu_induk')">
                            <i class="fas fa-eye me-1"></i> Detail Harian
                        </button>
                    </div>
                </div>
            </div>

            {{-- Gardu Induk - Bulanan --}}
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats card-round h-100 border-start border-success border-4">
                    <div class="card-body">
                        <h6 class="card-title fw-bold mb-2">Gardu Induk</h6>
                        <p class="text-muted small mb-2">Bulanan ({{ $displayMonth }})</p>
                        <h4 class="fw-bold text-success mb-3">{{ number_format($keypointGarduIndukMonthly) }}</h4>
                        <button class="btn btn-success btn-sm w-100"
                            onclick="navigateTo('keypoint', 'monthly', 'gardu_induk')">
                            <i class="fas fa-eye me-1"></i> Detail Bulanan
                        </button>
                    </div>
                </div>
            </div>

            {{-- Sectoral - Harian --}}
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats card-round h-100 border-start border-info border-4">
                    <div class="card-body">
                        <h6 class="card-title fw-bold mb-2">Sectoral</h6>
                        <p class="text-muted small mb-2">Harian ({{ $displayDate }})</p>
                        <h4 class="fw-bold text-info mb-3">{{ number_format($keypointSectoralDaily) }}</h4>
                        <button class="btn btn-info btn-sm w-100" onclick="navigateTo('keypoint', 'daily', 'sectoral')">
                            <i class="fas fa-eye me-1"></i> Detail Harian
                        </button>
                    </div>
                </div>
            </div>

            {{-- Sectoral - Bulanan --}}
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats card-round h-100 border-start border-warning border-4">
                    <div class="card-body">
                        <h6 class="card-title fw-bold mb-2">Sectoral</h6>
                        <p class="text-muted small mb-2">Bulanan ({{ $displayMonth }})</p>
                        <h4 class="fw-bold text-warning mb-3">{{ number_format($keypointSectoralMonthly) }}</h4>
                        <button class="btn btn-warning btn-sm w-100"
                            onclick="navigateTo('keypoint', 'monthly', 'sectoral')">
                            <i class="fas fa-eye me-1"></i> Detail Bulanan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Penyulang Section --}}
    <div class="mb-4">
        <h5 class="fw-bold mb-3">
            <i class="fa-solid fa-bolt text-warning me-2"></i>Penyulang
        </h5>
        <div class="row g-3">
            {{-- Gardu Induk - Harian --}}
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats card-round h-100 border-start border-primary border-4">
                    <div class="card-body">
                        <h6 class="card-title fw-bold mb-2">Gardu Induk</h6>
                        <p class="text-muted small mb-2">Harian ({{ $displayDate }})</p>
                        <h4 class="fw-bold text-primary mb-3">{{ number_format($penyulangGarduIndukDaily) }}</h4>
                        <button class="btn btn-primary btn-sm w-100"
                            onclick="navigateTo('penyulangan', 'daily', 'gardu_induk')">
                            <i class="fas fa-eye me-1"></i> Detail Harian
                        </button>
                    </div>
                </div>
            </div>

            {{-- Gardu Induk - Bulanan --}}
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats card-round h-100 border-start border-success border-4">
                    <div class="card-body">
                        <h6 class="card-title fw-bold mb-2">Gardu Induk</h6>
                        <p class="text-muted small mb-2">Bulanan ({{ $displayMonth }})</p>
                        <h4 class="fw-bold text-success mb-3">{{ number_format($penyulangGarduIndukMonthly) }}</h4>
                        <button class="btn btn-success btn-sm w-100"
                            onclick="navigateTo('penyulangan', 'monthly', 'gardu_induk')">
                            <i class="fas fa-eye me-1"></i> Detail Bulanan
                        </button>
                    </div>
                </div>
            </div>

            {{-- RTU GI - Harian --}}
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats card-round h-100 border-start border-info border-4">
                    <div class="card-body">
                        <h6 class="card-title fw-bold mb-2">RTU GI</h6>
                        <p class="text-muted small mb-2">Harian ({{ $displayDate }})</p>
                        <h4 class="fw-bold text-info mb-3">{{ number_format($penyulangRtuGiDaily) }}</h4>
                        <button class="btn btn-info btn-sm w-100"
                            onclick="navigateTo('penyulangan', 'daily', 'rtu_gi')">
                            <i class="fas fa-eye me-1"></i> Detail Harian
                        </button>
                    </div>
                </div>
            </div>

            {{-- RTU GI - Bulanan --}}
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats card-round h-100 border-start border-warning border-4">
                    <div class="card-body">
                        <h6 class="card-title fw-bold mb-2">RTU GI</h6>
                        <p class="text-muted small mb-2">Bulanan ({{ $displayMonth }})</p>
                        <h4 class="fw-bold text-warning mb-3">{{ number_format($penyulangRtuGiMonthly) }}</h4>
                        <button class="btn btn-warning btn-sm w-100"
                            onclick="navigateTo('penyulangan', 'monthly', 'rtu_gi')">
                            <i class="fas fa-eye me-1"></i> Detail Bulanan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
// Store filter values
const dashboardFilters = {
    date: '{{ $selectedDate }}',
    month: '{{ $selectedMonth }}',
    monthStart: '{{ $monthStart->format("Y-m-d") }}',
    monthEnd: '{{ $monthEnd->format("Y-m-d") }}'
};

// Navigate to detail page with filters
function navigateTo(page, period, category = null) {
    let url = '/' + page + '?';
    let params = new URLSearchParams();

    if (period === 'daily') {
        params.append('from_date', dashboardFilters.date);
        params.append('to_date', dashboardFilters.date);
    } else if (period === 'monthly') {
        params.append('from_date', dashboardFilters.monthStart);
        params.append('to_date', dashboardFilters.monthEnd);
    }

    if (category) {
        params.append('category', category);
    }

    params.append('auto_filter', 'true');

    window.location.href = url + params.toString();
}

// Sync month when date changes
document.getElementById('filter-date').addEventListener('change', function() {
    const dateValue = this.value;
    if (dateValue) {
        const monthValue = dateValue.slice(0, 7);
        document.getElementById('filter-month').value = monthValue;
    }
});

// NEW: Sync date when month changes (set to first day of month for consistency)
document.getElementById('filter-month').addEventListener('change', function() {
    const monthValue = this.value;
    if (monthValue) {
        const dateInput = document.getElementById('filter-date');
        dateInput.value = monthValue + '-01'; // Set to YYYY-MM-01
    }
});

// Apply filter button
document.getElementById('btn-apply-filter').addEventListener('click', function() {
    const date = document.getElementById('filter-date').value;
    const month = document.getElementById('filter-month').value;

    let url = new URL(window.location.href);
    url.searchParams.set('date', date);
    url.searchParams.set('month', month);

    window.location.href = url.toString();
});
</script>

<style>
.card-stats {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card-stats:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.icon-big {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
}

.icon-big i {
    font-size: 1.5rem;
}

.icon-primary {
    background: rgba(23, 125, 255, 0.15);
    color: #177dff;
}

.icon-warning {
    background: rgba(255, 165, 52, 0.15);
    color: #ffa534;
}

.bubble-shadow-small {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.gap-2 {
    gap: 0.5rem;
}

.gap-3 {
    gap: 1rem;
}

.border-4 {
    border-width: 4px !important;
}
</style>

@endsection
