<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Product Stock Level</h6>
    </div>
    <div class="card-body">
        
        <!--
            Code edited by: Alvah Amit Halder.
        -->
        @php($class = ['bg-danger', 'bg-warning', '', 'bg-info', 'bg-success']) 
        @foreach($projectData as $key => $value)
        <h4 class="small font-weight-bold">
            {!! $value['name'] !!} <span class="float-right">{!! $value['percentage'] !!}%</span>
        </h4>
        <div class="progress mb-4">
            <div 
                class="progress-bar {{$class[array_rand($class)]}}" 
                role="progressbar" 
                style="width: {!! $value['percentage'] !!}%" 
                aria-valuenow="{!! $value['percentage'] !!}" 
                aria-valuemin="0" 
                aria-valuemax="100"></div>
        </div>
        @endforeach
    </div>
</div>