<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Product Stock Level</h6>
    </div>
    <div class="card-body">
        <!--Original Demo Code-->
        <!--<h4 class="small font-weight-bold">Margarine <span class="float-right">20%</span></h4>
        <div class="progress mb-4">
            <div class="progress-bar bg-danger" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <h4 class="small font-weight-bold">Whip Cream <span class="float-right">40%</span></h4>
        <div class="progress mb-4">
            <div class="progress-bar bg-warning" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <h4 class="small font-weight-bold">Vanila Premix <span class="float-right">60%</span></h4>
        <div class="progress mb-4">
            <div class="progress-bar" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <h4 class="small font-weight-bold">Chocolate Premix <span class="float-right">80%</span></h4>
        <div class="progress mb-4">
            <div class="progress-bar bg-info" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <h4 class="small font-weight-bold">Account Setup <span class="float-right">Complete!</span></h4>
        <div class="progress">
            <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
        </div>-->
        
        <!--My Cusotm Code-->
        @php($class = ['bg-danger', 'bg-warning', '', 'bg-info', 'bg-success']) 
        @foreach($projectData as $key => $value)
        <h4 class="small font-weight-bold">{!! $value['name'] !!} <span class="float-right">{!! $value['percentage'] !!}%</span></h4>
        <div class="progress mb-4">
            <div class="progress-bar {{$class[array_rand($class)]}}" role="progressbar" style="width: {!! $value['percentage'] !!}%" aria-valuenow="{!! $value['percentage'] !!}" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        @endforeach
        
    </div>
</div>