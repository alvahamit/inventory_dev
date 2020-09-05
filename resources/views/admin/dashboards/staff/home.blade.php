<!-- 
    Author:     Alvah Amit Halder
    Document:   Dashboard for Employees. 
    Theme:      SB Admin 2
    Controller: HomeController
-->
@extends('theme.default')

@section('title', __('VSF-Staff Home'))

@section('logo', __('VSF Distribution'))

@section('pageheading', __('Welcome to Staff Dashboard'))

@section('content')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item active">
        <a href="#">Dashboard</a>
    </li>
</ol>

@include('admin.dashboards.staff.components.cards')

<div class="row">
    <!-- Area Chart -->
    @include('admin.dashboards.staff.components.area_chart')
    <!-- Pie Chart -->
    @include('admin.dashboards.staff.components.pie_chart')
</div>

@stop

@section('footer', __('Copyright © Alvah Amit Halder 2019'))

@section('scripts')
<!-- Page level plugins -->
<script src="{!! asset('theme/vendor/chart.js/Chart.min.js') !!}"></script>

<!-- Page level custom scripts -->
<script src="{!! asset('theme/js/demo/chart-area-demo.js') !!}"></script>
<script src="{!! asset('theme/js/demo/chart-pie-demo.js') !!}"></script>

<script type="text/javascript">
$(document).ready(function(){
    var updateChart = function(){
        var action = '{{ route("admin.areachart.data") }}';
        var method = 'GET';
        $.ajax({
            data: {"_token": "{{ csrf_token() }}"},
            url: action,
            type: method,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                myBarChart.data.datasets[0].data = data.mot;
                myBarChart.data.datasets[1].data = data.mit;
                myBarChart.data.datasets[2].data = data.mct;
                myBarChart.update();
            },
            error: function (data) {
                console.log(data);
            }
        }); // Ajax call
    }
    
    var updatePieChart = function(){
        var action = '{{ route("test") }}';
        var method = 'GET';
        $.ajax({
            data: {"_token": "{{ csrf_token() }}"},
            url: action,
            type: method,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                myPieChart.data.labels = data.labels;
                myPieChart.data.datasets[0].data = data.data;
                myPieChart.data.datasets[0].backgroundColor = data.color;
                myPieChart.data.datasets[0].hoverBackgroundColor = data.color;
                myPieChart.update();
            },
            error: function (data) {
                console.log(data);
            }
        }); // Ajax call
    }
    
    updateChart();
    updatePieChart();
});

</script>
@stop