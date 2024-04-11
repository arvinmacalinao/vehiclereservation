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
            <form method="POST" action="{{ route('role.store', ['id' => $id]) }}">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-2">
                            <label class="form-label fw-bold" for="name">Position<span class="text-danger">*</span></label>
                            <input style="text-transform:uppercase" placeholder="Position/Role" class="form-control @error('name') is-invalid @enderror" type="text" maxlength="255" name="name" id="name" value="{{ old('name', $role->name) }}" required>
                            <div class="invalid-feedback">@error('name') {{ $errors->first('name') }} @enderror</div>
                        </div>
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