@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'view'
])
@section('content')
<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">{{ $data['page'] }} Details</h3>
      </div>
      <div class="card-body p-0">
        <!-- This will display any message upon submission. -->
		@if(strlen($msg) > 0)
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close pull-right" data-bs-dismiss="alert" aria-label="Close">x</button>
            {{ $msg }}
        </div>
    @endif
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-8">
            </div>
            <div class="col-4 text-right mb-2">
                @php
                    $endDateTime = Carbon\Carbon::parse($r->end_date . ' ' . $r->end_time, 'Asia/Singapore');
                    $timetoday = Carbon\Carbon::now('Asia/Singapore');


                    // Get the authenticated user
                    $user = auth()->user();
                    // Check if the user belongs to the RDU group
                    $belongsToRDUGroup = $user->user_groups()->where('g_id', 3)->exists();
              @endphp
              @if ($belongsToRDUGroup)
                    @if($endDateTime > $timetoday)
                        <a class="btn btn-success btn-sm" href="{{ route('reservation.arrived', ['id' => $r->r_id]) }}" title="Arrived"><span class="fa fa-check-circle"></span> Arrived</a>
                    @endif
                @endif
                <a class="btn btn-primary btn-sm" href="{{ url()->previous() }}" title="Back"><span class="fa fa-caret-left"></span> Back</a>
            </div>
            <div class="border-bottom mt-0 mb-2"></div>
        </div>
        <div>
          <div class="form-group row">
            @if($r->status_id == 1)
              <div class="col-md-6">
                <label for="start_date">Assigned Vehicle</label>
                <input type="text" class="form-control form-control-sm" value="{{ $r->vehicle->equipment_name }}" readonly>
            </div>
            <div class="col-md-6">
                <label for="end_date">Assigned Driver</label>
                @php
                    $name = App\Models\User::where('u_id', $r->driver_id)->first();
                @endphp
                <input type="text" class="form-control form-control-sm" value="{{ $name->fullName ?? '' }}" readonly>
            </div>
            @endif
            <div class="col-md-2">
                <label for="start_date">Start Date</label>
                <input type="text" class="form-control form-control-sm" value="{{ $r->start_date }}" readonly>
            </div>
            <div class="col-md-2">
                <label for="time">Time of Departure</label>
                <input type="text" class="form-control form-control-sm" value="{{ \Carbon\Carbon::parse($r->start_time)->format('h:i a') }}
                " readonly>
            </div>
            <div class="col-md-2">
                <label for="end_date">End Date</label>
                <input type="text" class="form-control form-control-sm" value="{{ $r->end_date }}" readonly>
            </div>
            <div class="col-md-2">
                <label for="time">Time of Arrival</label>
                <input type="text" class="form-control form-control-sm" value="{{ \Carbon\Carbon::parse($r->end_time)->format('h:i a') }}
                " readonly>
            </div>
            <div class="col-md-2">
                <label for="vtype_id">Select Vehicle Type</label>
                <input type="text" class="form-control form-control-sm" value="{{ $r->type->name ?? ''}}" readonly>
            </div>
            <div class="col-md-2">
                <label for="passenger">No. of Passengers</label>
                <input type="text" class="form-control form-control-sm" value="{{ $r->passenger }}" readonly>
            </div>
        </div>
        <div class="form-group">
            <label for="destination">Destination</label>
            <textarea class="form-control form-control-sm rounded-0" rows="3" readonly>{{ $r->destination }}</textarea>
        </div>
        <div class="form-group">
            <label for="purpose">Purpose</label>
            <textarea class="form-control form-control-sm rounded-0" rows="3" readonly>{{ $r->purpose }}</textarea>
        </div>
        <div class="form-group">
            <label for="remarks">Remarks</label>
            <textarea class="form-control form-control-sm rounded-0" rows="3" readonly>{{ $r->remarks }}</textarea>
        </div>
        </div>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  <!-- /.content -->
@endsection
@push('scripts')
    <script>
    
    </script>
@endpush