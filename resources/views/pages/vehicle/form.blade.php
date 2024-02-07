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
            <form method="POST" action="{{ route('vehicle.store', ['id' => $id]) }}">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-2">
                            <label class="form-label fw-bold" for="plate_number">Plate Number<span class="text-danger">*</span></label>
                            <input style="text-transform:uppercase" placeholder="Plate Number" class="form-control @error('plate_number') is-invalid @enderror" type="text" maxlength="255" name="plate_number" id="plate_number" value="{{ old('plate_number', $v->plate_number) }}" required>
                            <div class="invalid-feedback">@error('plate_number') {{ $errors->first('plate_number') }} @enderror</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label class="form-label fw-bold" for="equipment_name">Equipment Name<span class="text-danger">*</span></label>
                            <input placeholder="Equipment Name" class="form-control @error('equipment_name') is-invalid @enderror" type="text" maxlength="255" min="1" name="equipment_name" id="equipment_name" value="{{ old('equipment_name', $v->equipment_name) }}" required>
                            <div class="invalid-feedback">@error('equipment_name') {{ $errors->first('equipment_name') }} @enderror</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label class="form-label fw-bold" for="code_number">Code Number<span class="text-danger">*</span></label>
                            <input placeholder="Code Number" class="form-control @error('code_number') is-invalid @enderror" type="number" maxlength="255" min="1" name="code_number" id="code_number" value="{{ old('code_number', $v->code_number) }}" required>
                            <div class="invalid-feedback">@error('code_number') {{ $errors->first('code_number') }} @enderror</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label class="form-label fw-bold" for="model_number">Model Number<span class="text-danger">*</span></label>
                            <input placeholder="Model Number" class="form-control @error('model_number') is-invalid @enderror" type="number" maxlength="255" min="1" name="model_number" id="model_number" value="{{ old('model_number', $v->model_number) }}" required>
                            <div class="invalid-feedback">@error('model_number') {{ $errors->first('model_number') }} @enderror</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label class="form-label fw-bold" for="serial_number">Serial Number<span class="text-danger">*</span></label>
                            <input placeholder="Serial Number" class="form-control @error('serial_number') is-invalid @enderror" type="number" maxlength="255" min="1" name="serial_number" id="serial_number" value="{{ old('serial_number', $v->serial_number) }}" required>
                            <div class="invalid-feedback">@error('serial_number') {{ $errors->first('serial_number') }} @enderror</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label class="form-label fw-bold" for="vehicle_type">Vehicle Type</label>
                            <select class="form-control @error('vehicle_type') is-invalid @enderror" name="vehicle_type" id="vehicle_type" value="{{ old('vehicle_type', $v->vehicle_type) }}">                                
                                    <option value="Sedan">Sedan</option>
                                    <option value="Van">Van</option>
                                    <option value="SUV">SUV</option>
                            </select>
                            <div class="invalid-feedback">@error('vehicle_type') {{ $errors->first('vehicle_type') }} @enderror</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        
                    </div>
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label class="form-label fw-bold" for="remarks">Remarks</label>
                            <textarea class="form-control" name="remarks" id="remarks" value="" placeholder="Remarks">{{ old('remarks', $v->remarks) }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        
                    </div>
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
            $('.date_start').datepicker({
                format: 'yyyy-mm-dd', // Set the desired date format
                todayHighlight:'TRUE',
                autoclose: true,
            });

            $('.date_end').datepicker({
                format: 'yyyy-mm-dd', // Set the desired date format
                todayHighlight:'TRUE',
                autoclose: true,
            });
        });
    </script>
@endpush