@extends('layout.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
    <div>
        <h3 class="fw-bold mb-3">Dashboard</h3>
        <h6 class="op-7 mb-2">Comissioning Result On (month, year)</h6>
    </div>
</div>
<div class="row">
    <div class="col-xl-4 col-md-3">
        <div class="card card-stats card-round">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-icon">
                        <div class="icon-big text-center icon-primary bubble-shadow-small">
                            <i class="fa-solid fa-tower-broadcast"></i>
                        </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                            <p class="card-category">Keypoint</p>
                            <h4 class="card-title">1,294</h4>
                        </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                            <p class="card-category">On (Day) 230</p>
                            <button class="btn btn-primary btn-sm">Detail Harian</button>
                        </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                            <p class="card-category">On (Month) 110002</p>
                            <button class="btn btn-primary btn-sm">Detail Bulanan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-3">
        <div class="card card-stats card-round">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-icon">
                        <div class="icon-big text-center icon-primary bubble-shadow-small">
                            <i class="fa-solid fa-tower-broadcast"></i>
                        </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                            <p class="card-category">Penyulang</p>
                            <h4 class="card-title">1,294</h4>
                        </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                            <p class="card-category">On (Day) 230</p>
                            <button class="btn btn-primary btn-sm">Detail Harian</button>
                        </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                            <p class="card-category">On (Month) 10002</p>
                            <button class="btn btn-primary btn-sm">Detail Bulanan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <h6 class="op-7 mb-2">Keypoint</h6>
    </div>

    <div class="row">
        <div class="col-xl-2 col-md-2">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <h4 class="card-title">Gardu Induk</h4>
                                <p class="card-category">On day 122</p>
                                <button class="btn btn-primary btn-sm">Detail Harian</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-2">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <h4 class="card-title">Gardu Induk</h4>
                                <p class="card-category">On month 12039</p>
                                <button class="btn btn-primary btn-sm">Detail Bulanan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-2">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <h4 class="card-title">Sectoral</h4>
                                <p class="card-category">On Day 121</p>
                                <button class="btn btn-primary btn-sm">Detail Harian</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-2">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <h4 class="card-title">Sectoral</h4>
                                <p class="card-category">On Day 121</p>
                                <button class="btn btn-primary btn-sm">Detail Bulanan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div>
        <h6 class="op-7 mb-2">Penyulang</h6>
    </div>

    <div class="row">
        <div class="col-xl-2 col-md-2">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <h4 class="card-title">Gardu Induk</h4>
                                <p class="card-category">On day 122</p>
                                <button class="btn btn-primary btn-sm">Detail Harian</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-2">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <h4 class="card-title">Gardu Induk</h4>
                                <p class="card-category">On month 12039</p>
                                <button class="btn btn-primary btn-sm">Detail Bulanan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-2">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <h4 class="card-title">Sectoral</h4>
                                <p class="card-category">On Day 121</p>
                                <button class="btn btn-primary btn-sm">Detail Harian</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-2">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <h4 class="card-title">Sectoral</h4>
                                <p class="card-category">On Day 121</p>
                                <button class="btn btn-primary btn-sm">Detail Bulanan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
    type: "line",
    height: "70",
    width: "100%",
    lineWidth: "2",
    lineColor: "#177dff",
    fillColor: "rgba(23, 125, 255, 0.14)",
});

$("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
    type: "line",
    height: "70",
    width: "100%",
    lineWidth: "2",
    lineColor: "#f3545d",
    fillColor: "rgba(243, 84, 93, .14)",
});

$("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
    type: "line",
    height: "70",
    width: "100%",
    lineWidth: "2",
    lineColor: "#ffa534",
    fillColor: "rgba(255, 165, 52, .14)",
});
</script>
@endsection
