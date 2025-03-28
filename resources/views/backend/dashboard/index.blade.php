@extends('backend.layouts.master')
@section('title','Dashboard')
@push('styles')
    <!-- <link href="{{ asset('css/styles.css') }}" rel="stylesheet"> -->
@endpush
@section('main-content')
   <div class="container-fluid">
      <!-- Start here.... -->
      <div class="row">
         <div class="col-xxl-12">
            <div class="row">
               
               <div class="col-md-3">
                  <div class="card overflow-hidden">
                     <div class="card-body">
                        <a href="{{route('category')}}">
                           <div class="row">
                              <div class="col-3">
                                 <div class="avatar-md bg-soft-primary rounded">
                                    <i class="bx bx-box avatar-title fs-24 text-primary"></i>
                                 </div>
                              </div>
                              <!-- end col -->
                              <div class="col-9 text-end">
                                 <p class="text-muted mb-0 text-truncate">Category</p>
                                 <h3 class="text-dark mt-1 mb-0">{{ $data['category_count'] }}</h3>
                              </div>
                              <!-- end col -->
                           </div>
                        </a>
                        <!-- end row-->
                     </div>
                  </div>
                  <!-- end card -->
               </div>
               <!-- end col -->
               <div class="col-md-3">
                  <div class="card overflow-hidden">
                     <div class="card-body">
                        <a href="{{ route('product.index') }}">
                           <div class="row">
                              <div class="col-3">
                                 <div class="avatar-md bg-soft-primary rounded">
                                    <i class="bx bx-cart avatar-title fs-24 text-primary"></i>
                                 </div>
                              </div>
                              <!-- end col -->
                              <div class="col-9 text-end">
                                 <p class="text-muted mb-0 text-truncate">Producs</p>
                                 <h3 class="text-dark mt-1 mb-0">{{ $data['product_count'] }}</h3></h3>
                              </div>
                              <!-- end col -->
                           </div>
                        </a>
                        <!-- end row-->
                     </div>
                  </div>
                  <!-- end card -->
               </div>
               <!-- end col -->
               <div class="col-md-3">
                  <div class="card overflow-hidden">
                     <div class="card-body">
                        <a href="{{route('attributes')}}">
                           <div class="row">
                              <div class="col-3">
                                 <div class="avatar-md bg-soft-primary rounded">
                                    <i class="bx bxs-extension avatar-title fs-24 text-primary"></i>
                                 </div>
                              </div>
                              <!-- end col -->
                              <div class="col-9 text-end">
                                 <p class="text-muted mb-0 text-truncate">Attributes</p>
                                 <h3 class="text-dark mt-1 mb-0">{{ $data['attribute_count'] }}</h3>
                              </div>
                              <!-- end col -->
                           </div>
                        </a>
                        <!-- end row-->
                     </div>
                  </div>
                  <!-- end card -->
               </div>
               <!-- end col -->
               <div class="col-md-3">
                  <div class="card overflow-hidden">
                     <div class="card-body">
                        <a href="{{route('attributes')}}">
                           <div class="row">
                              <div class="col-3">
                                 <div class="avatar-md bg-soft-primary rounded">
                                    <i class="bx bx-capsule avatar-title text-primary fs-24"></i>
                                 </div>
                              </div>
                              <!-- end col -->
                              <div class="col-9 text-end">
                                 <p class="text-muted mb-0 text-truncate">Attributes Value</p>
                                 <h3 class="text-dark mt-1 mb-0">{{ $data['attributeValue_count'] }}</h3>
                              </div>
                              <!-- end col -->
                           </div>
                        </a>
                        <!-- end row-->
                     </div>
                     
                  </div>
                  <!-- end card -->
               </div>
               <div class="col-md-3">
                  <div class="card overflow-hidden">
                     <div class="card-body">
                        <a href="{{route('manage-customer')}}">
                           <div class="row">
                              <div class="col-3">
                                 <div class="avatar-md bg-soft-primary rounded">
                                    <i class="bx bx-user avatar-title text-primary fs-24"></i>
                                 </div>
                              </div>
                              <!-- end col -->
                              <div class="col-9 text-end">
                                 <p class="text-muted mb-0 text-truncate">Customer</p>
                                 <h3 class="text-dark mt-1 mb-0">{{ $data['customer_count'] }}</h3>
                              </div>
                              <!-- end col -->
                           </div>
                        </a>
                        <!-- end row-->
                     </div>
                     
                  </div>
                  <!-- end card -->
               </div>
               <div class="col-md-3">
                  <div class="card overflow-hidden">
                     <div class="card-body">
                        <a href="{{route('order-list')}}">
                           <div class="row">
                              <div class="col-3">
                                 <div class="avatar-md bg-soft-primary rounded">
                                    <i class="bx bx-cart avatar-title text-primary fs-24"></i>
                                 </div>
                              </div>
                              <!-- end col -->
                              <div class="col-9 text-end">
                                 <p class="text-muted mb-0 text-truncate">Total Order</p>
                                 <h3 class="text-dark mt-1 mb-0">{{ $data['order_count'] }}</h3>
                              </div>
                              <!-- end col -->
                           </div>
                        </a>
                        <!-- end row-->
                     </div>
                     
                  </div>
                  <!-- end card -->
               </div>
               @php
                  $statusIcons = [
                     1 => 'bx bx-check',
                     2 => 'bx bx-package',
                     4 => 'bx bx-check-circle',
                     5 => 'bx bx-check-double',
                     6 => 'bx bx-cross',
                     
                  ];
               @endphp
               @if($data['order_status_count']->isNotEmpty())
                  @foreach($data['order_status_count'] as $status)
                     <div class="col-md-3">
                        <div class="card overflow-hidden">
                           <div class="card-body">
                              <a href="{{ route('order-list', ['order-status' => $status->id]) }}">
                                 <div class="row">
                                    <div class="col-3">
                                       <div class="avatar-md bg-soft-primary rounded">
                                          <i class="{{ $statusIcons[$status->id] ?? 'bx bx-question-mark' }} avatar-title text-primary fs-24"></i>
                                       </div>
                                    </div>
                                    <!-- end col -->
                                    <div class="col-9 text-end">
                                       <p class="text-muted mb-0 text-truncate">
                                          {{ $status->status_name }}
                                       </p>
                                       <h3 class="text-dark mt-1 mb-0">
                                          {{ $status->orders_count }} orders
                                       </h3>
                                    </div>
                                    <!-- end col -->
                                 </div>
                              </a>
                              <!-- end row-->
                           </div>
                           
                        </div>
                        <!-- end card -->
                     </div>
                  @endforeach
               @endif
               @php
                  $counterIcons = [
                     1 => 'bx ti-click',
                     2 => 'bx ti-click',                     
                  ];
               @endphp
               @if($data['button_counter']->isNotEmpty())
                  @foreach($data['button_counter'] as $counter)
                     <div class="col-md-3">
                        <div class="card overflow-hidden">
                           <div class="card-body">
                              <a href="">
                                 <div class="row">
                                    <div class="col-3">
                                       <div class="avatar-md bg-soft-primary rounded">
                                          <i class="{{ $counterIcons[$counter->id] ?? 'bx bx-question-mark' }} avatar-title text-primary fs-24"></i>
                                       </div>
                                    </div>
                                    <!-- end col -->
                                    <div class="col-9 text-end">
                                       <p class="mb-0 text-danger">
                                          {{ $counter->title }} Button
                                       </p>
                                       <h3 class="text-dark mt-1 mb-0">
                                          {{ $counter->counter }} Click
                                       </h3>
                                    </div>
                                    <!-- end col -->
                                 </div>
                              </a>
                              <!-- end row-->
                           </div>
                           
                        </div>
                        <!-- end card -->
                     </div>
                  @endforeach
               @endif
               <!-- end col -->
            </div>
            <!-- end row -->
         </div>
         <!-- end col -->
         <div class="col-xxl-6">
            <div class="card">
               <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center">
                     <h4 class="card-title">Added Product Month Wise</h4>
                     <div>
                        <button type="button" class="btn btn-sm btn-outline-light" data-filter="all">ALL</button>
                        <button type="button" class="btn btn-sm btn-outline-light" data-filter="1M">1M</button>
                        <button type="button" class="btn btn-sm btn-outline-light" data-filter="6M">6M</button>
                        <button type="button" class="btn btn-sm btn-outline-light active" data-filter="1Y">1Y</button>
                     </div>

                  </div>
                  <!-- end card-title-->
                  <div dir="ltr">
                     <div id="product-chart" class="apex-charts"></div>
                  </div>
               </div>
               <!-- end card body -->
            </div>
            <!-- end card -->
         </div>
         <div class="col-xxl-6">
            <div class="card">
               <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center">
                     <h4 class="card-title">Daily Visitor Come</h4>
                     <a href="{{route('get-visitor-list')}}" data-title="View details" data-bs-toggle="tooltip" class="btn btn-sm btn-info" data-bs-original-title="View details">
                       View Details
                     </a>
                  </div>
                  <!-- end card-title-->
                  <div dir="ltr">
                     <div id="visitor_graphs" class="apex-charts"></div>
                  </div>
               </div>
               <!-- end card body -->
            </div>
            <!-- end card -->
         </div>
         <!-- end col -->
      </div>
   </div>

@endsection

@push('scripts')
<!-- <script src="{{asset('backend/assets/vendor/jsvectormap/js/jsvectormap.min.js')}}"></script> -->
<!-- <script src="{{asset('backend/assets/vendor/jsvectormap/maps/world-merc.js')}}"></script> -->
<!-- <script src="{{asset('backend/assets/vendor/jsvectormap/maps/world.js')}}"></script> -->
<!-- <script src="{{asset('backend/assets/js/pages/dashboard.js')}}"></script> -->
 <!-- <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script> -->
<script>
   $(document).ready(function () {
      var options = {
         series: [{
            name: 'Products',
            data: []
         }],
         chart: {
            type: 'bar',
            height: 350
         },
         xaxis: {
            categories: []
         },
         colors: ['#ff6c2f'],
         dataLabels: {
            enabled: false
         },
         
      };

      var chart = new ApexCharts(document.querySelector("#product-chart"), options);
      chart.render();
      $(".btn-outline-light").on("click", function () {
         let filter = $(this).data("filter");
         $(".btn-outline-light").removeClass("active");
         $(this).addClass("active");
         $.ajax({
               //url: "/dashboard/filtered-data",
               url: "{{ route('dashboard.filtered-data') }}",
               type: "GET",
               data: { filter: filter },
               success: function (response) {
                  chart.updateSeries([{
                     name: 'Products',
                     data: response.totals
                  }]);
                  chart.updateOptions({
                     xaxis: {
                        categories: response.months
                     }
                  });
               },
               error: function (xhr, status, error) {
                  console.error("Error fetching data:", error);
               }
         });
      });
      $(".btn-outline-light[data-filter='all']").click();
   });
   /**Visitor Graphs */
   $(document).ready(function () {
    $.ajax({
        url: '/get-visitor-stats',
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            var options = {
                series: [{
                    name: "Visitors",
                    type: "area",
                    data: data.data, // Dynamic data from backend
                }],
                chart: {
                    height: 350,
                    type: "line",
                    toolbar: { show: false },
                },
                stroke: {
                    width: [2],
                    curve: 'smooth'
                },
                fill: {
                    opacity: [1],
                    type: ['gradient'],
                    gradient: {
                        type: "vertical",
                        opacityFrom: 0.5,
                        opacityTo: 0,
                        stops: [0, 90]
                    },
                },
                xaxis: {
                    categories: data.categories, // Dynamic categories (dates)
                },
                yaxis: {
                    min: 0,
                },
                grid: {
                    show: true,
                    strokeDashArray: 3,
                },
                legend: {
                    show: true,
                    horizontalAlign: "center",
                },
                colors: ["#22c55e"],
                tooltip: {
                    shared: true,
                    y: [{
                        formatter: function (y) {
                            return y ? y.toFixed(1) + " visitors" : y;
                        },
                    }],
                },
            };

            var chart = new ApexCharts($("#visitor_graphs")[0], options);
            chart.render();
        },
        error: function (xhr, status, error) {
            console.error('Error fetching visitor stats:', error);
        }
    });
});


</script>
@endpush