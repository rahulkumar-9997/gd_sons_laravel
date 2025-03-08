@extends('backend.layouts.master')
@section('title','Customer Details')
@section('main-content')
@push('styles')
<!-- <link href="{{asset('backend/assets/vendor/datatables/css/jquery.dataTables.css')}}" rel="stylesheet" type="text/css" media="screen" />
<link href="{{asset('backend/assets/vendor/datatables/extensions/TableTools/css/dataTables.tableTools.min.css')}}" rel="stylesheet" type="text/css" media="screen" />
<link href="{{asset('backend/assets/vendor/datatables/extensions/Responsive/css/dataTables.responsive.css')}}" rel="stylesheet" type="text/css" media="screen" />
<link href="{{asset('backend/assets/vendor/datatables/extensions/Responsive/bootstrap/3/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" media="screen" /> -->
@endpush
<!-- Start Container Fluid -->

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="bg-primary profile-bg rounded-top p-5 position-relative mx-n3 mt-n3">

                        @if(!empty($customer->profile_img))
                        <img src="{{ asset('images/customer/'. $customer->profile_img) }}" class="avatar-lg border border-light border-3 rounded-circle position-absolute top-100 start-0 translate-middle ms-5">
                        @else
                        <img src="{{ asset('backend/assets/images/avatar-2.jpg') }}" class="avatar-lg border border-light border-3 rounded-circle position-absolute top-100 start-0 translate-middle ms-5">
                        @endif
                    </div>
                    <div class="mt-4 pt-3">
                        <h4 class="mb-1">
                            {{$customer->name}}
                            <i class="bx bxs-badge-check text-success align-middle"></i>
                        </h4>
                        <div class="mt-2">

                            <p class="fs-15 mb-1 mt-1">
                                <span class="text-dark fw-semibold">Email : </span> {{$customer->email}}
                            </p>
                            <p class="fs-15 mb-0 mt-1">
                                <span class="text-dark fw-semibold">Phone : </span>
                                {{$customer->phone_number}}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-footer border-top gap-1 hstack">
                    <a href="#!" class="btn btn-primary w-100">Send Message</a>
                    <a href="#!" class="btn btn-light w-100">Analytics</a>
                    <a href="#!" class="btn btn-soft-dark d-inline-flex align-items-center justify-content-center rounded avatar-sm"><i class="bx bx-edit-alt fs-18"></i></a>
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="card-title">Customer Details</h4>
                    </div>
                    <div>
                        <span class="badge bg-success-subtle text-success px-2 py-1">Active User</span>
                    </div>

                </div>
                <div class="card-body py-2">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <tbody>
                                <tr>
                                    <td class="px-0">
                                        <p class="d-flex mb-0 align-items-center gap-1 fw-semibold text-dark">Account ID : </p>
                                    </td>
                                    <td class="text-dark fw-medium px-0">#AC-278699</td>
                                </tr>
                                <tr>
                                    <td class="px-0">
                                        <p class="d-flex mb-0 align-items-center gap-1 fw-semibold text-dark"> Invoice Email : </p>
                                    </td>
                                    <td class="text-dark fw-medium px-0">michaelaminer@dayrep.com</td>
                                </tr>
                                <tr>
                                    <td class="px-0">
                                        <p class="d-flex mb-0 align-items-center gap-1 fw-semibold text-dark"> Delivery Address : </p>
                                    </td>
                                    <td class="text-dark fw-medium px-0">62, rue des Nations Unies 22000 SAINT-BRIEUC</td>
                                </tr>
                                <tr>
                                    <td class="px-0">
                                        <p class="d-flex mb-0 align-items-center gap-1 fw-semibold text-dark"> Language : </p>
                                    </td>
                                    <td class="text-dark fw-medium px-0">English</td>
                                </tr>
                                <tr>
                                    <td class="px-0">
                                        <p class="d-flex mb-0 align-items-center gap-1 fw-semibold text-dark"> Latest Invoice Id : </p>
                                    </td>
                                    <td class="text-dark fw-medium px-0">#INV2540</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h4 class="card-title mb-2 d-flex align-items-center gap-2">Total Invoice</h4>
                                    <p class="text-muted fw-medium fs-22 mb-0">0</p>
                                </div>
                                <div>
                                    <div class="avatar-md bg-primary bg-opacity-10 rounded">
                                        <iconify-icon icon="solar:bill-list-bold-duotone" class="fs-32 text-primary avatar-title"></iconify-icon>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('customer-orders', ['id' => $customer->id]) }}">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h4 class="card-title mb-2 d-flex align-items-center gap-2">Total Order</h4>
                                        <p class="text-muted fw-medium fs-22 mb-0">{{$totalOrders}}</p>
                                    </div>
                                    <div>
                                        <div class="avatar-md bg-primary bg-opacity-10 rounded">
                                            <iconify-icon icon="solar:box-bold-duotone" class="fs-32 text-primary avatar-title"></iconify-icon>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Latest Five Orders </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0 table-hover table-centered">
                            <thead class="bg-light-subtle">
                                <tr>
                                    <th>Order ID</th>
                                    <th>Status</th>
                                    <th>Total Amount</th>
                                    <th>Order Date</th>
                                    <th>Payment Method</th>
                                    <th>Order Items</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($orders->isNotEmpty())
                                @foreach($orders as $order)
                                <tr>
                                    <td>
                                        <a href="{{ route('order', $order->id) }}" class="text-body">
                                            {{ $order->order_id }}
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge bg-success-subtle text-success py-1 px-2">
                                            {{ $order->orderStatus->status_name ?? 'Pending' }}
                                        </span>
                                    </td>
                                    <td>
                                        Rs. {{ number_format($order->total_amount, 2) }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($order->due_date)->format('d M, Y') }}
                                    </td>
                                    <td>
                                        {{ $order->payment_mode ?? 'N/A' }}
                                    </td>
                                    <td>
                                        {{ $order->orderLines->count() }} 
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="6" class="text-center">No orders found.</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>


                    </div>
                </div>
            </div>
            <!--<div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body text-center">
                            <img src="assets/images/user-profile.png" alt="" class="img-fluid">
                            <h4><i class="bx bxs-coin-stack text-primary"></i> 3,764 <span class="text-muted fw-medium">Points Earned</span> </h4>
                            <p class="mb-0">Collect reward points with each purchase.</p>
                        </div>
                        <div class="card-footer border-top gap-1 hstack">
                            <a href="#!" class="btn btn-primary w-100">Earn Point</a>
                            <a href="#!" class="btn btn-light w-100">View Items</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex gap-3">
                                <div class="avatar bg-light d-flex align-items-center justify-content-center rounded-circle">
                                    <i class="bx bx-down-arrow-alt fs-30"></i>
                                </div>
                                <div class="d-block">
                                    <h4 class="text-dark fw-medium mb-1">Payment Arrived</h4>
                                    <p class="mb-0 text-muted">23 min ago</p>
                                </div>
                                <div class="ms-auto">
                                    <h4 class="text-dark fw-medium mb-1">$ 1,340</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-2">

                                <img src="assets/images/users/avatar-2.jpg" alt="avatar-3" class="avatar rounded-circle">

                                <div class="d-block">
                                    <h4 class="text-dark fw-medium mb-1">Michael A. Miner</h4>
                                    <p class="mb-0 text-muted">Welcome Back</p>
                                </div>
                                <div class="ms-auto">
                                    <span class="text-muted">
                                        <a href="#!" class="link-reset fs-3"><iconify-icon icon="solar:settings-bold"></iconify-icon></a>
                                    </span>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="d-flex align-items-center">
                                    <h5 class="text-dark mb-0">All Account <span class="text-muted fw-normal ms-1"><i class="bx bxs-circle fs-10"></i></span><span class="text-muted fw-normal ms-1">Total Balance</span></h5>
                                    <div class="ms-auto">
                                        <a href="#!" class="link-reset fw-medium">UTS <i class="bx bx-down-arrow-alt text-danger"></i></a>
                                    </div>
                                </div>
                                <h3 class="fw-semibold mt-2 mb-0">$4,700 <span class="fs-5 text-muted ms-1">+$232</span></h3>
                                <div id="chart2" class="apex-charts mt-3" style="min-height: 208px;">
                                    <div id="apexchartsnqrmdv8q" class="apexcharts-canvas apexchartsnqrmdv8q apexcharts-theme-light" style="width: 320px; height: 208px;"><svg id="SvgjsSvg1055" width="320" height="208" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;">
                                            <foreignObject x="0" y="0" width="320" height="208">
                                                <div class="apexcharts-legend" xmlns="http://www.w3.org/1999/xhtml" style="max-height: 104px;"></div>
                                            </foreignObject>
                                            <rect id="SvgjsRect1059" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe"></rect>
                                            <g id="SvgjsG1098" class="apexcharts-yaxis" rel="0" transform="translate(-18, 0)"></g>
                                            <g id="SvgjsG1057" class="apexcharts-inner apexcharts-graphical" transform="translate(0, 1)">
                                                <defs id="SvgjsDefs1056">
                                                    <clipPath id="gridRectMasknqrmdv8q">
                                                        <rect id="SvgjsRect1061" width="326" height="212" x="-3" y="-3" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect>
                                                    </clipPath>
                                                    <clipPath id="forecastMasknqrmdv8q"></clipPath>
                                                    <clipPath id="nonForecastMasknqrmdv8q"></clipPath>
                                                    <clipPath id="gridRectMarkerMasknqrmdv8q">
                                                        <rect id="SvgjsRect1062" width="324" height="210" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect>
                                                    </clipPath>
                                                    <linearGradient id="SvgjsLinearGradient1067" x1="0" y1="0" x2="0" y2="1">
                                                        <stop id="SvgjsStop1068" stop-opacity="0.4" stop-color="rgba(255,108,47,0.4)" offset="0"></stop>
                                                        <stop id="SvgjsStop1069" stop-opacity="0" stop-color="rgba(255,182,151,0)" offset="1"></stop>
                                                        <stop id="SvgjsStop1070" stop-opacity="0" stop-color="rgba(255,182,151,0)" offset="1"></stop>
                                                    </linearGradient>
                                                </defs>
                                                <line id="SvgjsLine1060" x1="0" y1="0" x2="0" y2="206" stroke="#b6b6b6" stroke-dasharray="3" stroke-linecap="butt" class="apexcharts-xcrosshairs" x="0" y="0" width="1" height="206" fill="#b1b9c4" filter="none" fill-opacity="0.9" stroke-width="1"></line>
                                                <g id="SvgjsG1073" class="apexcharts-grid">
                                                    <g id="SvgjsG1074" class="apexcharts-gridlines-horizontal" style="display: none;">
                                                        <line id="SvgjsLine1077" x1="0" y1="0" x2="320" y2="0" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                                        <line id="SvgjsLine1078" x1="0" y1="68.66666666666667" x2="320" y2="68.66666666666667" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                                        <line id="SvgjsLine1079" x1="0" y1="137.33333333333334" x2="320" y2="137.33333333333334" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                                        <line id="SvgjsLine1080" x1="0" y1="206" x2="320" y2="206" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                                    </g>
                                                    <g id="SvgjsG1075" class="apexcharts-gridlines-vertical" style="display: none;"></g>
                                                    <line id="SvgjsLine1082" x1="0" y1="206" x2="320" y2="206" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line>
                                                    <line id="SvgjsLine1081" x1="0" y1="1" x2="0" y2="206" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line>
                                                </g>
                                                <g id="SvgjsG1076" class="apexcharts-grid-borders" style="display: none;"></g>
                                                <g id="SvgjsG1063" class="apexcharts-area-series apexcharts-plot-series">
                                                    <g id="SvgjsG1064" class="apexcharts-series" zIndex="0" seriesName="series-1" data:longestSeries="true" rel="1" data:realIndex="0">
                                                        <path id="SvgjsPath1071" d="M 0 206 L 0 148.77777777777777C 11.2 148.77777777777777 20.8 54.93333333333334 32 54.93333333333334C 43.2 54.93333333333334 52.8 112.15555555555555 64 112.15555555555555C 75.2 112.15555555555555 84.8 2.288888888888863 96 2.288888888888863C 107.2 2.288888888888863 116.8 61.79999999999998 128 61.79999999999998C 139.2 61.79999999999998 148.8 148.77777777777777 160 148.77777777777777C 171.2 148.77777777777777 180.8 105.28888888888888 192 105.28888888888888C 203.2 105.28888888888888 212.8 178.53333333333333 224 178.53333333333333C 235.2 178.53333333333333 244.8 123.6 256 123.6C 267.2 123.6 276.8 185.4 288 185.4C 299.2 185.4 308.8 82.39999999999999 320 82.39999999999999C 320 82.39999999999999 320 82.39999999999999 320 206M 320 82.39999999999999z" fill="url(#SvgjsLinearGradient1067)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-area" index="0" clip-path="url(#gridRectMasknqrmdv8q)" pathTo="M 0 206 L 0 148.77777777777777C 11.2 148.77777777777777 20.8 54.93333333333334 32 54.93333333333334C 43.2 54.93333333333334 52.8 112.15555555555555 64 112.15555555555555C 75.2 112.15555555555555 84.8 2.288888888888863 96 2.288888888888863C 107.2 2.288888888888863 116.8 61.79999999999998 128 61.79999999999998C 139.2 61.79999999999998 148.8 148.77777777777777 160 148.77777777777777C 171.2 148.77777777777777 180.8 105.28888888888888 192 105.28888888888888C 203.2 105.28888888888888 212.8 178.53333333333333 224 178.53333333333333C 235.2 178.53333333333333 244.8 123.6 256 123.6C 267.2 123.6 276.8 185.4 288 185.4C 299.2 185.4 308.8 82.39999999999999 320 82.39999999999999C 320 82.39999999999999 320 82.39999999999999 320 206M 320 82.39999999999999z" pathFrom="M -1 206 L -1 206 L 32 206 L 64 206 L 96 206 L 128 206 L 160 206 L 192 206 L 224 206 L 256 206 L 288 206 L 320 206"></path>
                                                        <path id="SvgjsPath1072" d="M 0 148.77777777777777C 11.2 148.77777777777777 20.8 54.93333333333334 32 54.93333333333334C 43.2 54.93333333333334 52.8 112.15555555555555 64 112.15555555555555C 75.2 112.15555555555555 84.8 2.288888888888863 96 2.288888888888863C 107.2 2.288888888888863 116.8 61.79999999999998 128 61.79999999999998C 139.2 61.79999999999998 148.8 148.77777777777777 160 148.77777777777777C 171.2 148.77777777777777 180.8 105.28888888888888 192 105.28888888888888C 203.2 105.28888888888888 212.8 178.53333333333333 224 178.53333333333333C 235.2 178.53333333333333 244.8 123.6 256 123.6C 267.2 123.6 276.8 185.4 288 185.4C 299.2 185.4 308.8 82.39999999999999 320 82.39999999999999" fill="none" fill-opacity="1" stroke="#ff6c2f" stroke-opacity="1" stroke-linecap="butt" stroke-width="2" stroke-dasharray="0" class="apexcharts-area" index="0" clip-path="url(#gridRectMasknqrmdv8q)" pathTo="M 0 148.77777777777777C 11.2 148.77777777777777 20.8 54.93333333333334 32 54.93333333333334C 43.2 54.93333333333334 52.8 112.15555555555555 64 112.15555555555555C 75.2 112.15555555555555 84.8 2.288888888888863 96 2.288888888888863C 107.2 2.288888888888863 116.8 61.79999999999998 128 61.79999999999998C 139.2 61.79999999999998 148.8 148.77777777777777 160 148.77777777777777C 171.2 148.77777777777777 180.8 105.28888888888888 192 105.28888888888888C 203.2 105.28888888888888 212.8 178.53333333333333 224 178.53333333333333C 235.2 178.53333333333333 244.8 123.6 256 123.6C 267.2 123.6 276.8 185.4 288 185.4C 299.2 185.4 308.8 82.39999999999999 320 82.39999999999999" pathFrom="M -1 206 L -1 206 L 32 206 L 64 206 L 96 206 L 128 206 L 160 206 L 192 206 L 224 206 L 256 206 L 288 206 L 320 206" fill-rule="evenodd"></path>
                                                        <g id="SvgjsG1065" class="apexcharts-series-markers-wrap apexcharts-hidden-element-shown" data:realIndex="0">
                                                            <g class="apexcharts-series-markers">
                                                                <circle id="SvgjsCircle1102" r="0" cx="0" cy="0" class="apexcharts-marker wsp0tgx9t no-pointer-events" stroke="#ffffff" fill="#ff6c2f" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" default-marker-size="0"></circle>
                                                            </g>
                                                        </g>
                                                    </g>
                                                    <g id="SvgjsG1066" class="apexcharts-datalabels" data:realIndex="0"></g>
                                                </g>
                                                <line id="SvgjsLine1083" x1="0" y1="0" x2="320" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" stroke-linecap="butt" class="apexcharts-ycrosshairs"></line>
                                                <line id="SvgjsLine1084" x1="0" y1="0" x2="320" y2="0" stroke-dasharray="0" stroke-width="0" stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line>
                                                <g id="SvgjsG1085" class="apexcharts-xaxis" transform="translate(0, 0)">
                                                    <g id="SvgjsG1086" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g>
                                                </g>
                                                <g id="SvgjsG1099" class="apexcharts-yaxis-annotations"></g>
                                                <g id="SvgjsG1100" class="apexcharts-xaxis-annotations"></g>
                                                <g id="SvgjsG1101" class="apexcharts-point-annotations"></g>
                                            </g>
                                        </svg>
                                        <div class="apexcharts-tooltip apexcharts-theme-light">
                                            <div class="apexcharts-tooltip-series-group" style="order: 1;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(255, 108, 47);"></span>
                                                <div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                                    <div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div>
                                                    <div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div>
                                                    <div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light">
                                            <div class="apexcharts-yaxistooltip-text"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer border-top gap-1 hstack">
                            <a href="#!" class="btn btn-primary w-100">Send</a>
                            <a href="#!" class="btn btn-light w-100">Receive</a>
                            <a href="#!" class="btn btn-soft-dark d-inline-flex align-items-center justify-content-center rounded avatar-sm"><i class="bx bx-plus fs-18"></i></a>
                        </div>
                    </div>


                </div>
            </div>-->
        </div>
    </div>
</div>
<!-- End Container Fluid -->
<!-- Modal -->
@include('backend.layouts.common-modal-form')
<!-- modal--->
@endsection
@push('scripts')


@endpush