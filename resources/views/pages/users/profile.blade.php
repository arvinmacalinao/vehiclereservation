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
        <h3 class="card-title">{{ $data['page'] }} Profile Record</h3>
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
                <a class="btn btn-success btn-sm" href="{{ route('user.edit', ['id' => $user->u_id]) }}">
                    <i class="fas fa-pencil-alt">
                    </i>
                    Edit Details
                </a>
                <a class="btn btn-primary btn-sm" href="{{ url()->previous() }}" title="Back"><span class="fa fa-caret-left"></span> Back</a>
            </div>
            <div class="border-bottom mt-0 mb-2"></div>
        </div>
        <div class="flex-grow-1">
            <form>
                <h4>Personal Details</h4>
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-2">
                            <label class="form-label fw-bold" for="first_name">First Name</label>
                            <input placeholder="First Name" class="form-control" type="text" maxlength="255" name="first_name" id="first_name" value="{{ $user->first_name }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-2">
                            <label class="form-label fw-bold" for="middle_name">Middle Name</label>
                            <input placeholder="Middle Name" class="form-control" type="text" maxlength="255" name="middle_name" id="middle_name" value="{{ $user->middle_name }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-2">
                            <label class="form-label fw-bold" for="last_name">Last Name</label>
                            <input placeholder="Last Name" class="form-control" type="text" maxlength="255" name="last_name" id="last_name" value="{{ $user->last_name }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-2">
                            <label class="form-label fw-bold" for="email">E-mail Address</label>
                            <input placeholder="E-mail Address" class="form-control" type="text" maxlength="255" name="email" id="email" value="{{ $user->email }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4"></div>
                </div>
                <hr>
                <h4>Account Details</h4>
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-2">
                            <label class="form-label fw-bold" for="username">Username</label>
                            <input placeholder="Username" class="form-control" type="text" maxlength="255" name="username" id="username" value="{{ $user->username }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-2 dd">
                            <label class="form-label fw-bold" for="g_id">User Group</label>
                            <input placeholder="User Group" class="form-control" type="text" maxlength="255" name="g_id" id="g_id" value="{{ $groups ?? '' }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-2 dd">
                            <label class="form-label fw-bold" for="role_id">Position</label>
                            <input placeholder="Position" class="form-control" type="text" maxlength="255" name="role_id" id="role_id" value="{{ $roles ?? '' }}" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-md-8"></div>
                <div class="col-md-2"></div>
                </div>
                <br>
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