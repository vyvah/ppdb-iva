@extends('layouts.dashboard')
@section('title', 'Dashboard Admin')

@section('content')

<style>
    /* ======= Premium UI Styling ======= */
    .dashboard-card {
        border: none;
        border-radius: 20px;
        padding: 25px;
        background: #ffffff;
        box-shadow: 0 8px 25px rgba(0,0,0,0.06);
        transition: 0.3s ease;
    }

    .dashboard-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.12);
    }

    .soft-badge {
        padding: 6px 14px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 12px;
    }

    .glass-box {
        background: rgba(255,255,255,0.65);
        backdrop-filter: blur(10px);
        border-radius: 20px;
    }

    .section-title {
        font-weight: 700;
        margin-bottom: 15px;
        color: #333;
    }

    .table-modern tbody tr:hover {
        background: rgba(125, 180, 255, 0.06);
    }

</style>


{{-- ===== HEADER ===== --}}
<div class="glass-box shadow-sm p-4 mb-4">
    <h2 class="fw-bold text-primary mb-1">
        Dashboard Admin
    </h2>
    <p class="text-muted mb-0">
        Selamat datang kembali, <strong>{{ Auth::user()->name }}</strong>.
        Kelola seluruh aktivitas PPDB dari satu tempat.
    </p>
</div>


{{-- ===== STATISTIK CARDS ===== --}}
<div class="row g-4">

    <div class="col-md-6 col-xl-3">
        <div class="dashboard-card">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="text-muted mb-0">Total Pendaftar</h6>
                <i class="ti ti-users fs-3 text-primary"></i>
            </div>
            <h2 class="fw-bold mb-1">1,240</h2>
            <span class="soft-badge bg-light-success text-success">
                <i class="ti ti-trending-up"></i> 12% Meningkat
            </span>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="dashboard-card">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="text-muted mb-0">Terverifikasi</h6>
                <i class="ti ti-check fs-3 text-success"></i>
            </div>
            <h2 class="fw-bold mb-1">830</h2>
            <span class="soft-badge bg-light-info text-info">
                <i class="ti ti-clipboard"></i> Dokumen Sah
            </span>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="dashboard-card">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="text-muted mb-0">Diterima</h6>
                <i class="ti ti-badge-check fs-3 text-warning"></i>
            </div>
            <h2 class="fw-bold mb-1">410</h2>
            <span class="soft-badge bg-light-warning text-warning">
                <i class="ti ti-star"></i> Lolos Seleksi
            </span>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="dashboard-card">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="text-muted mb-0">Belum Dicek</h6>
                <i class="ti ti-alert-circle fs-3 text-danger"></i>
            </div>
            <h2 class="fw-bold mb-1">245</h2>
            <span class="soft-badge bg-light-danger text-danger">
                <i class="ti ti-alert-triangle"></i> Perlu Tindakan
            </span>
        </div>
    </div>

</div>



{{-- ===== CHART SECTION ===== --}}
<div class="row mt-4 g-4">

    <div class="col-xl-8">
        <div class="dashboard-card">
            <h5 class="section-title">Statistik Pengunjung</h5>
            <div id="visitor-chart" style="height: 260px;"></div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="dashboard-card">
            <h5 class="section-title">Income Overview</h5>
            <h2 class="fw-bold mb-3">$7,650</h2>
            <div id="income-chart" style="height: 200px;"></div>
        </div>
    </div>

</div>



{{-- ===== TABLE ORDERS ===== --}}
<div class="row mt-4 g-4">

    <div class="col-xl-8">
        <div class="dashboard-card">
            <h5 class="section-title">Recent Orders</h5>

            <div class="table-responsive">
                <table class="table table-modern align-middle">
                    <thead class="table-light rounded-3">
                        <tr>
                            <th>Tracking No</th>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td>84564564</td>
                            <td>Camera Lens</td>
                            <td>40</td>
                            <td><span class="badge bg-danger">Rejected</span></td>
                            <td class="text-end">$40,570</td>
                        </tr>

                        <tr>
                            <td>43847393</td>
                            <td>Laptop</td>
                            <td>300</td>
                            <td><span class="badge bg-warning text-dark">Pending</span></td>
                            <td class="text-end">$180,139</td>
                        </tr>

                        <tr>
                            <td>93847322</td>
                            <td>Mobile</td>
                            <td>355</td>
                            <td><span class="badge bg-success">Approved</span></td>
                            <td class="text-end">$180,139</td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>



    {{-- ===== Analytics Small Chart ===== --}}
    <div class="col-xl-4">
        <div class="dashboard-card">
            <h5 class="section-title">Analytics Report</h5>

            <div class="list-group border-0 mb-3">
                <a class="list-group-item border-0 d-flex justify-content-between">
                    Finance Growth <strong>+45.14%</strong>
                </a>
                <a class="list-group-item border-0 d-flex justify-content-between">
                    Expense Ratio <strong>0.58%</strong>
                </a>
                <a class="list-group-item border-0 d-flex justify-content-between">
                    Risk Level <strong class="text-success">Low</strong>
                </a>
            </div>

            <div id="analytics-chart" style="height: 200px;"></div>
        </div>
    </div>

</div>

@endsection
