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
            <form method="POST" action="{{ route('user.store', ['id' => $id]) }}">
                @csrf
                <h4>Personal Details</h4>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-2">
                                <label class="form-label fw-bold" for="first_name">First Name<span class="text-danger">*</span></label>
                                <input placeholder="First Name" class="form-control @error('first_name') is-invalid @enderror" type="text" maxlength="255" name="first_name" id="first_name" value="{{ old('first_name', $user->first_name) }}" required="required">
                                <div class="invalid-feedback">@error('first_name') {{ $errors->first('first_name') }} @enderror</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-2">
                                <label class="form-label fw-bold" for="middle_name">Middle Name<span class="text-danger">*</span></label>
                                <input placeholder="Middle Name" class="form-control @error('middle_name') is-invalid @enderror" type="text" maxlength="255" name="middle_name" id="middle_name" value="{{ old('middle_name', $user->middle_name) }}" required="required">
                                <div class="invalid-feedback">@error('middle_name') {{ $errors->first('middle_name') }} @enderror</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-2">
                                <label class="form-label fw-bold" for="last_name">Last Name<span class="text-danger">*</span></label>
                                <input placeholder="Last Name" class="form-control @error('last_name') is-invalid @enderror" type="text" maxlength="255" name="last_name" id="last_name" value="{{ old('last_name', $user->last_name) }}" required="required">
                                <div class="invalid-feedback">@error('last_name') {{ $errors->first('last_name') }} @enderror</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-2">
                            <label class="form-label fw-bold" for="email">E-mail Address<span class="text-danger">*</span></label>
                            <input placeholder="E-mail Address" class="form-control @error('email') is-invalid @enderror" type="text" maxlength="255" name="email" id="email" value="{{ old('email', $user->email) }}" required="required">
                            <div class="invalid-feedback">@error('email') {{ $errors->first('email') }} @enderror</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            
                        </div>
                    </div>
                    <hr>
                    <h4>Account Details</h4>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-2">
                                <label class="form-label fw-bold" for="first_name">Username<span class="text-danger">*</span></label>
                                <input placeholder="Username" class="form-control @error('username') is-invalid @enderror" type="text" maxlength="255" name="username" id="username" value="{{ old('username', $user->username) }}" required="required">
                                <div class="invalid-feedback">@error('username') {{ $errors->first('username') }} @enderror</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-2">
                            <label class="form-label fw-bold" for="password">Password<span class="text-danger">*</span></label>
                            <input placeholder="Password" class="form-control @error('password') is-invalid @enderror" type="password" maxlength="255" name="password" id="password" value="">
                            <div class="invalid-feedback">@error('password') {{ $errors->first('password') }} @enderror</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-2">
                                <label class="form-label fw-bold" for="password_confirmation">Password Confirmation<span class="text-danger">*</span></label>
                                <input placeholder="Password Confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" type="password" maxlength="255" name="password_confirmation" id="password_confirmation" value="">
                                <div class="invalid-feedback">@error('password_confirmation') {{ $errors->first('password_confirmation') }} @enderror</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-2 dd">
                                <label class="form-label fw-bold" for="g_id">User Group<span class="text-danger">*</span></label>
                                <select class="form-control @error('g_id') is-invalid @enderror" name="g_id" id="g_id">
                                    @foreach($groups as $ugroup)
                                    @php
                                        $ugroup_id  = \App\Models\UserGroup::where('u_id', $user->u_id)->value('g_id');
                                    @endphp
                                        <option value="{{ $ugroup->g_id }}" {{ old('g_id', $ugroup_id) == $ugroup->g_id ? 'selected' : '' }}>{{ $ugroup->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">@error('g_id') {{ $errors->first('g_id') }} @enderror</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-2 dd">
                                <label class="form-label fw-bold" for="role_id">Position<span class="text-danger">*</span></label>
                                <select class="form-control @error('role_id') is-invalid @enderror" name="role_id" id="role_id">
                                    @foreach($roles as $role)
                                    @php
                                        $urole_id  = \App\Models\UserRole::where('u_id', $user->u_id)->value('role_id');
                                    @endphp
                                        <option value="{{ $role->role_id }}" {{ old('role_id', $urole_id) == $role->role_id ? 'selected' : '' }}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">@error('role_id') {{ $errors->first('role_id') }} @enderror</div>
                            </div>
                        </div>
                        </div>
                        <div class="col-md-8">
                        </div>
                        <div class="col-md-2">
                            <div class="form-group ml-2">
                              <div class="checkbox">
                                <input class="mr-3 mt-1 text-center" type="checkbox" value="1" name="u_enabled" id="u_enabled" {{ (old('u_enabled', optional($user)->u_enabled) == 1) ? ' checked="checked"' : ''}}>
					            <label class="form-check-label fw-bold" for="u_enabled">Enabled</label>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                                {{-- @if(auth()->user()->u_is_superadmin == 1)
                                    <div class="form-group ml-2">
                                        <div class="checkbox">
                                            <input class="mr-3 mt-1 text-center" type="checkbox" value="1" name="u_is_superadmin" id="u_is_superadmin"{{ (old('u_is_superadmin', optional($user)->u_is_superadmin) == 1) ? ' checked="checked"' : '' }}>
                                            <label class="form-check-label fw-bold" for="u_is_superadmin">Is Superadmin</label>
                                        </div>
                                    </div>
                                @endif --}}
                        </div>
                    </div>
                    <br>
                @if(Str::contains(Request::url(), 'add') || Str::contains(Request::url(), 'edit'))
                <div class="d-grid gap-2">
                    <input class="btn btn-primary btn-sm" type="submit" name="form-submit" id="form-submit" value="Save">
                </div>
                @endif
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