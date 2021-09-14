@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    @if($roles == 'Admin')

                    Είστε συνδεδεμένος
                    
                    @else
                    Νέα Δρομολόγια

                    @endif
                </div>

                <div class="card-body">
                    @if(session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif


     @if($roles !== 'Admin')
@foreach($itineraries as $itinerary)
<div class="row itinerary">

<div class="col-md-8">
    <p>{{ $itinerary->datetime}}</p>
    <p> Από: <b>{{ $itinerary->from }}</b> -  Σε: <b>{{ $itinerary->to }}</b></p>
    @if(!empty($itinerary->map_point))
        <p><a href="{{$itinerary->map_point}}" target="_blank">Προβολή Χάρτη</a></p>
    @endif
</div>

<div class="col-md-4">
    <a class="btn btn-success" href="{{route('admin.itineraries.accept', ['id' => $itinerary->id])}}">Αποδοχή</a>
</div>


</div>

@endforeach
    @endif



                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent

@endsection