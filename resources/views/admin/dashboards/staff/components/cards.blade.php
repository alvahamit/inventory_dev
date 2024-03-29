<div class="row">

    <!-- Cash in Market Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Cash in market</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{!! $cashInMarket !!}</div>
                    </div>
                    <div class="col-auto">
                        <!--<i class="fas fa-calendar fa-2x text-gray-300"></i>-->
                        <i class="fas fa-cash-register fa-2x text-gray-300"></i>
                        <!--<i class="fas fa-dollar-sign fa-2x text-gray-300"></i>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Collection of the month Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Collection of the month</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{!! $collectionThisMonth !!}</div>
                    </div>
                    <div class="col-auto">
                        <!--<i class="fas fa-calendar fa-2x text-gray-300"></i>-->
                        <!--<i class="fas fa-cash-register fa-2x text-gray-300"></i>-->
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">New Customers this Month</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{!! $customersThisMonth !!}</div>
                    </div>
                    <div class="col-auto">
                        <!--<i class="fas fa-dollar-sign fa-2x text-gray-300"></i>-->
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
<!--    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Collection of the month</div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                            </div>
                            <div class="col">
                                <div class="progress progress-sm mr-2">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>-->

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">New orders</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{!! $newOrders !!}</div>
                    </div>
                    <div class="col-auto">
                        <!--<i class="fas fa-comments fa-2x text-gray-300"></i>-->
                        <i class="fas fa-shopping-basket fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>