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
              @if (!$r->approvals || $r->approvals->where('status_id', '2')->isEmpty())
              <form action="{{ route('approval.approve', ['id' => $app_id]) }}" method="post" style="display: inline;">
                  @csrf
                  <button type="submit" class="btn btn-success btn-sm" title="Approve"><span class="fa fa-thumbs-up"></span> Approve</button>
              </form>
              @endif
                <a class="btn btn-primary btn-sm" href="{{ url()->previous() }}" title="Back"><span class="fa fa-caret-left"></span> Back</a>
            </div>
            <div class="border-bottom mt-0 mb-2"></div>
        </div>
        <div>
          <input type="hidden" name="app_id" value="{{ $app_id }}">
              @php
                // Get the authenticated user
                $user = auth()->user();
                // Check if the user belongs to the RDU group
                $belongsToRDUGroup = $user->user_groups()->where('g_id', 3)->exists();
              @endphp
              @if ($belongsToRDUGroup)
                <form action="{{ route('approval.approve', ['id' => $app_id]) }}" method="post" style="display: inline;">
                    @csrf
                    <div class="card border-primary mb-3" style="">
                      @php
                              $approval_status = \App\Models\Approval::where('app_id', $app_id)->first();
                      @endphp
                      @if($approval_status->status_id == 2)
                      <div class="card-header">Assigned Vehicle and Driver</div>
                      <div class="form-row align-items-center">
                        <div class="col-sm-3 my-1 ml-3">
                          <label class="sr-only" for="inlineFormInputGroupUsername"></label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <div class="input-group-text">Vehicle</div>
                            </div>
                            <input type="text" class="form-control" id="inlineFormInputGroupUsername" placeholder="" value="{{ $r->vehicle->equipment_name ?? '-' }} - {{ $r->vehicle->plate_number ?? '-' }}">
                          </div>
                        </div>
                      </div>
                      <div class="form-row align-items-center">
                        <div class="col-sm-3 my-1 ml-3">
                          <label class="sr-only" for="inlineFormInputGroupUsername"></label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <div class="input-group-text">Driver</div>
                            </div>
                            <input type="text" class="form-control" id="inlineFormInputGroupUsername" placeholder="" value="{{ $r->drivers->FullName ?? '-' }}">
                          </div>
                        </div>
                      </div>
                      @else
                      <div class="card-header">Assign Vehicle and Driver</div>
                      <div class="card-body">
                        <form>
                          <div class="form-group">
                            <label for="v_id">Select Vehicle</label>
                            <select name="v_id" id="v_id" class="form-control" required>
                                <option value="">-- Select Vehicle --</option>
                                @foreach($availableVehicles as $vehicle)
                                    <option value="{{ $vehicle->v_id }}"  {{ old('v_id', $vehicle->v_id) == $r->v_id ? 'selected' : '' }}>{{ $vehicle->equipment_name }} - {{ $vehicle->plate_number }}</option>
                                @endforeach
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="d_id">Select Driver</label>
                            <select name="driver_id" id="d_id" class="form-control" required>
                                <option value="">-- Select Driver --</option>
                                @foreach($availableDrivers as $driver)
                                    <option value="{{ $driver->u_id }}"  {{ old('driver_id', $driver->u_id) == $r->driver_id ? 'selected' : '' }}>{{ $driver->FullName }}</option>
                                @endforeach
                            </select>
                          </div>
                        </form>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <button type="submit" class="btn btn-success btn-sm btn-block" title="Approve"><span class="fa fa-thumbs-up"></span> Submit and Approve</button>
                        </div>
                        <div class="col-md-6">
                          <a href="{{ route('approval.unavailable', [ 'id' => $app_id ]) }}" class="btn btn-warning btn-sm btn-block text-light"><span class="fa fa-ban"></span> No Available Vehicle/Driver</a>
                        </div>
                      </div>
                      @endif
                    </div>
                </form>
              @endif
            <div class="form-group row">
            <div class="col-md-2">
                <label for="start_date">Start Date</label>
                <input type="text" class="form-control form-control-sm" value="{{ $r->start_date }}" readonly>
            </div>
            <div class="col-md-2">
              <label for="time">Time of Departure</label>
              <input type="text" class="form-control form-control-sm" value="{{ \Carbon\Carbon::parse($r->start_time)->format('h:i a') }}" readonly>
          </div>
            <div class="col-md-2">
                <label for="end_date">End Date</label>
                <input type="text" class="form-control form-control-sm" value="{{ $r->end_date }}" readonly>
            </div>
            <div class="col-md-2">
              <label for="time">Time of Arrival</label>
              <input type="text" class="form-control form-control-sm" value="{{ \Carbon\Carbon::parse($r->end_time)->format('h:i a') }}" readonly>
          </div>
            
            <div class="col-md-2">
                <label for="vtype_id">Select Vehicle Type</label>
                <input type="text" class="form-control form-control-sm" value="{{ $r->vehicle_type->name }}" readonly>
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