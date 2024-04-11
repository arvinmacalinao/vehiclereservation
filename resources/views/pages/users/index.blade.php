@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'driver'
])
@section('content')
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="card"><!-- This will display any message upon submission. -->
		@if(strlen($msg) > 0)
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong>{{ $msg }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
    @endif
    <!-- End -->
      <div class="card-header">
        <h3 class="card-title">{{ $data['page'] }}</h3>
      </div>
      <div class="card-body p-0">
        <div class="row">
            <div class="col-md-6">
                <a class="btn btn-success btn-sm m-2" href="{{ route('user.add') }}">
                    <i class="fas fa-folder">
                    </i>
                    Add New {{ $data['page']}}
                </a>
            </div>
            <div class="col-md-6">
                <!-- Pagination section -->
                <div class="text-right m-2">
                    @include('subviews.pagination', ['rows' => $rows])
                </div>
                <!-- End of pagination section -->
            </div>
        </div>
        <hr>
        
        <table class="table table-striped projects">
            <thead>
                <tr>
                    <th>#</th>
                    <th width="20%">Name</th>
                    <th>Designation</th>
                    <th>Role</th>
                    <th>Username</th>
                    <th>Date Registered</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php
                $ctr = $rows->firstItem();
             ?>
            <tbody>
            @foreach ($rows as $row)
                <tr>
                    <td>{{ $ctr++ }}</td>
                    <td>{{ $row->fullName }}</td>
                    <td>
                        @php
                        $userGroupId = App\Models\UserGroup::where('u_id', $row->u_id)->pluck('g_id')->first();
                        $alias = App\Models\Group::where('g_id', $userGroupId)->value('alias');
                        @endphp
                        {{ $alias ?? '-' }}
                    </td>
                    <td>
                        @php
                        $userGroupId = App\Models\UserRole::where('u_id', $row->u_id)->pluck('role_id')->first();
                        $role = App\Models\Role::where('role_id', $userGroupId)->value('name');
                        @endphp
                        {{ $role ?? '-' }}
                    </td>
                    <td>
                        {{ $row->username }}</td>
                    <td>{{ $row->created_at }}</td>
                    <td  class="project-actions text-left">
                        <a class="btn btn-primary btn-sm" href="{{ route('user.profile', ['id' => $row->u_id ]) }}">
                            <i class="fas fa-folder">
                            </i>
                            View
                        </a>
                        <a class="btn btn-info btn-sm" href="{{ route('user.edit', ['id' => $row->u_id]) }}">
                            <i class="fas fa-pencil-alt">
                            </i>
                            Edit
                        </a>
                        @if($row->u_enabled == 0)
                            <a class="btn btn-success btn-sm text-light" href="{{ route('user.enable', ['id' => $row->u_id]) }}" title="Enable"><i class="far fa-check-circle"></i> Enable</a>
                        @else
                            <a class="btn btn-warning btn-sm text-light" href="{{ route('user.disable', ['id' => $row->u_id]) }}" title="Disable"><i class="fa fa-ban"></i> Disable</a>
                        @endif
                    </td>
                </tr>
            </tbody>
            @endforeach
        </table>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

  </section>
  <!-- /.content -->
@endsection
@push('scripts')
<script>
    $(document).ready(function() {

    $(".alert").delay(4000).slideUp(200, function() {
        $(this).alert('close');
    });

    $('#page-select').change(function() {
        window.location.href = $(this).val();
    });
});
</script>
@endpush