@extends('layouts.dashboard')
@section('title', 'Dashboard Admin')

@section('content')

<style>
    /* ===== Modern Clean Dashboard UI ===== */
    :root {
        --primary: #4f46e5;
        --primary-light: #eef2ff;
        --text-dark: #111827;
        --text-muted: #6b7280;
        --card-bg: #fff;
        --radius: 16px;
        --shadow: 0 4px 18px rgba(0,0,0,0.06);
        --shadow-hover: 0 8px 30px rgba(0,0,0,0.12);
    }

    .dashboard-container {
        padding: 15px;
    }

    .card-modern {
        background: var(--card-bg);
        border-radius: var(--radius);
        padding: 26px;
        border: 1px solid #ececec;
        box-shadow: var(--shadow);
        transition: .25s ease;
    }

    .card-modern:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-hover);
    }

    .header-modern {
        padding: 35px;
        border-radius: var(--radius);
        background: rgba(255,255,255,0.85);
        backdrop-filter: blur(10px);
        border: 1px solid #ececec;
        margin-bottom: 30px;
        box-shadow: var(--shadow);
    }

    .header-modern h2 {
        font-weight: 700;
        color: var(--primary);
    }

    .stats-number {
        font-size: 32px;
        font-weight: 700;
        color: var(--text-dark);
        margin-top: 5px;
    }

    .badge-soft {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }

    .badge-soft-success { background: #dcfce7; color: #15803d; }
    .badge-soft-info    { background: #e0f2fe; color: #0369a1; }
    .badge-soft-warning { background: #fef9c3; color: #a16207; }
    .badge-soft-danger  { background: #fee2e2; color: #b91c1c; }

    .table-modern tbody tr:hover {
        background: var(--primary-light);
    }

    .section-title {
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 12px;
    }
</style>


<div class="dashboard-container">

    {{-- HEADER --}}
    <div class="header-modern">
        <h2>Dashboard Admin</h2>
        <p class="text-muted mb-0">Selamat datang kembali, <strong>{{ Auth::user()->name }}</strong>.</p>
    </div>

    {{-- STATISTIC CARDS --}}
    <div class="row g-4">

        <div class="col-md-6 col-xl-3">
            <div class="card-modern">
                <p class="text-muted mb-1">Total Pendaftar</p>
                <div class="stats-number">1,240</div>
                <span class="badge-soft badge-soft-success mt-2">+12% Meningkat</span>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card-modern">
                <p class="text-muted mb-1">Terverifikasi</p>
                <div class="stats-number">830</div>
                <span class="badge-soft badge-soft-info mt-2">Dokumen Sah</span>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card-modern">
                <p class="text-muted mb-1">Diterima</p>
                <div class="stats-number">410</div>
                <span class="badge-soft badge-soft-warning mt-2">Lolos Seleksi</span>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card-modern">
                <p class="text-muted mb-1">Belum Dicek</p>
                <div class="stats-number">245</div>
                <span class="badge-soft badge-soft-danger mt-2">Perlu Dicek</span>
            </div>
        </div>
    </div>


    {{-- CHART SECTION --}}
    <div class="row g-4 mt-1">

        <div class="col-xl-8">
            <div class="card-modern">
                <h5 class="section-title">Statistik Pengunjung</h5>
                <div id="visitor-chart" style="height: 260px;"></div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card-modern">
                <h5 class="section-title">Income Overview</h5>
                <div class="stats-number mb-3">$7,650</div>
                <div id="income-chart" style="height: 200px;"></div>
            </div>
        </div>

    </div>


    {{-- TABLE SECTION --}}
    <div class="row g-4 mt-1">

        <div class="col-xl-8">
            <div class="card-modern">
                <h5 class="section-title">Recent Orders</h5>

                <div class="table-responsive mt-3">
                    <table class="table table-modern align-middle">
                        <thead class="table-light">
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
                                <td><span class="badge-soft badge-soft-danger">Rejected</span></td>
                                <td class="text-end">$40,570</td>
                            </tr>

                            <tr>
                                <td>43847393</td>
                                <td>Laptop</td>
                                <td>300</td>
                                <td><span class="badge-soft badge-soft-warning">Pending</span></td>
                                <td class="text-end">$180,139</td>
                            </tr>

                            <tr>
                                <td>93847322</td>
                                <td>Mobile</td>
                                <td>355</td>
                                <td><span class="badge-soft badge-soft-success">Approved</span></td>
                                <td class="text-end">$180,139</td>
                            </tr>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>


        {{-- Analytics --}}
        <div class="col-xl-4">
            <div class="card-modern">
                <h5 class="section-title">Analytics Report</h5>

                <div class="list-group border-0 mb-3 mt-2">
                    <div class="list-group-item border-0 d-flex justify-content-between">
                        Finance Growth <strong>+45.14%</strong>
                    </div>
                    <div class="list-group-item border-0 d-flex justify-content-between">
                        Expense Ratio <strong>0.58%</strong>
                    </div>
                    <div class="list-group-item border-0 d-flex justify-content-between">
                        Risk Level <strong class="text-success">Low</strong>
                    </div>
                </div>

                <div id="analytics-chart" style="height: 200px;"></div>
            </div>
        </div>

    </div>

</div>

@endsection
