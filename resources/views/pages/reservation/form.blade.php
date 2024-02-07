@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'vehicle'
])
@section('content')
<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        @if($id == 0)
        <h3 class="card-title">New {{ $data['page'] }} Record</h3>
        @else
        <h3 class="card-title">Update {{ $data['page'] }} Record</h3>
        @endif
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
                <a class="btn btn-primary btn-sm" href="{{ url()->previous() }}" title="Back"><span class="fa fa-caret-left"></span> Back</a>
            </div>
            <div class="border-bottom mt-0 mb-2"></div>
        </div>
        <div class="flex-grow-1">
            <form method="POST" action="{{ route('driver.store', ['id' => $id]) }}">
                @csrf
                <div class="form-group row">
                    <div class="col-md-4">
                        <label for="start_date">Start Date <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('start_date') }}</i></label>
                        <input type="text" name="start_date" id="start_date" value="{{ old('start_date', $r->start_date == null ? '' : $r->start_date->format('m/d/Y')) }}" class="form-control form-control-sm" {{ $id != 0 ? 'disabled' : '' }}>
                    </div>
                    <div class="col-md-4">
                        <label for="end_date">End Date <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('end_date') }}</i></label>
                        <input type="text" name="end_date" id="end_date" value="{{ old('end_date', $r->end_date == null ? '' : $	$r->end_date->format('m/d/Y')) }}" class="form-control form-control-sm" {{ $id != 0 ? 'disabled' : '' }}>
                    </div>
                    <div class="col-md-4">
                        <label for="vehicle_id">Vehicle <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('vehicle_id') }}</i></label>
                        <input type="text" name="vehicle_id" value="{{ old('vehicle_id', $r->vehicle_id) }}" id="vehicle_id" hidden>
                        <input type="text" name="plate_number" value="{{ old('plate_number', $r->vehicle == null ? '' : $r->vehicle->plate_number) }}" id="plate_number" class="form-control form-control-sm" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row" id="vehicle_label" hidden="true">
                        <div class="col-md-12">
                            <label>Select Vehicle <span class="text-danger">*</span></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="vehicles"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="time">Time of Departure <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('time') }}</i></label>
                        <input type="time" name="time" value="{{ old('time', $r->time) }}" id="time" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="form-group">
                    <label for="passengers">Employees <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('passengers') }}</i></label>
                    <select name="passengers[]" id="passengers" class="form-control" multiple data-placeholder="DOST IV-A Personnel">
                        @foreach($users as $u)
                            <option value="{{ $u->id }}" {{ collect(old('passengers', $r->passengers->pluck('id') ?? []))->contains($u->id) ? 'selected' : '' }}>{{ $u->order_by_last_name }}</option>
                        @endforeach
                    </select>
                </div>                
                <div class="form-group">
                    <label for="destination">Destination <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('destination') }}</i></label>
                    <textarea name="destination" id="destination" class="form-control form-control-sm rounded-0" rows="3">{{ old('destination', $r->destination) }}</textarea>
                </div>
                <div class="form-group">
                    <label for="purpose">Purpose <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('purpose') }}</i></label>
                    <textarea name="purpose" id="purpose" class="form-control form-control-sm rounded-0" rows="3">{{ old('purpose', $r->purpose) }}</textarea>
                </div>
                <div class="form-group">
                    <label for="remarks">Remarks</label>
                    <textarea name="remarks" id="remarks" class="form-control form-control-sm rounded-0" rows="3">{{ old('remarks', $r->remarks) }}</textarea>
                </div>
                <br>
                <div class="d-grid gap-2">
                    <input class="btn btn-primary btn-sm" type="submit" name="form-submit" id="form-submit" value="Save">
                </div>
            </form>
        </div>
    
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </section>
  <!-- /.content -->
@endsection
@push('scripts')
    <script>
        $(document).ready(function(){
            $('#start_date').datepicker({
                format: 'yyyy-mm-dd', // Set the desired date format
                todayHighlight:'TRUE',
                autoclose: true,
            });

            $('#end_date').datepicker({
                format: 'yyyy-mm-dd', // Set the desired date format
                todayHighlight:'TRUE',
                autoclose: true,
            });
        });
    </script>
@endpush