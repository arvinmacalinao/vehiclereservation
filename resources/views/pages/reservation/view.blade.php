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
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
            <i class="fas fa-times"></i>
          </button>
        </div>
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
          <div class="form-group row">
            <div class="col-md-2">
                <label for="start_date">Start Date</label>
                <input type="text" class="form-control form-control-sm" value="{{ $r->start_date == null ? '' : $r->start_date->format('m/d/Y') }}" readonly>
            </div>
            <div class="col-md-2">
                <label for="end_date">End Date</label>
                <input type="text" class="form-control form-control-sm" value="{{ $r->end_date == null ? '' : $r->end_date->format('m/d/Y') }}" readonly>
            </div>
            <div class="col-md-2">
                <label for="time">Time of Departure</label>
                <input type="text" class="form-control form-control-sm" value="{{ $r->time }}" readonly>
            </div>
            <div class="col-md-3">
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