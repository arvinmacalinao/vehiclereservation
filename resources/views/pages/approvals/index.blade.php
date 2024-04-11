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
                    <th>Reservation Request</th>
                    {{-- @if(Auth::id())
                    <th>Approved By:</th>
                    @endif --}}
                    <th>Status</th>
                    <th>Remarks</th>
                    <th class="text-right">Action</th>
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
                    <td><small>Requested by: {{ $row->reservation->user->first_name }}</small><br>
                    <small>Date Requested: {{ $row->reservation->start_date }}</small><br>
                    <small>Vehicle Needed: {{ $row->reservation->type->name ?? ''}}</small><br>
                    <small>Destination: {{ $row->reservation->destination }}</small><br>
                    <small>Purpose: {{ $row->reservation->purpose }}</small><br>
                    </td>
                    <td>
                      @if($row->status_id == 1)
                        <i class="fa fa-exclamation-circle text-warning" data-toggle="tooltip" data-title="Pending"> Pending</i>
                      @elseif($row->status_id == 2)
                        <i class="fa fa-check-circle text-success" data-toggle="tooltip" data-title="Pending"> Approved<br>
                          <small>by: {{ $row->user->first_name }}</small><br></i>
                      @elseif($row->status_id == 3)
                      <i class="fa fa-times-circle text-danger" data-toggle="tooltip" data-title="Pending"> Disapproved</i><br>
                      <small>by: {{ $row->user->first_name }}</small><br></i>
                      @else
                      <i class="fa fa-times-circle text-danger" data-toggle="tooltip" data-title="Pending"> Cancelled</i><br>
                      @endif
                    </td>
                    <th>{{ $row->remarks }}</th>
                    <td  class="project-actions text-right">
                    @if($row->status_id != 4)
                        <a class="btn btn-primary btn-sm" href="{{ route('reservation.view', ['id' => $row->r_id, 'app_id' => $row->app_id]) }}">
                            <i class="fas fa-folder">
                            </i>
                            View
                        </a>
                        @if($row->status_id == 1)
                        <a class="btn btn-success btn-sm" href="{{ route('approval.approve', ['id' => $row->app_id]) }}">
                            <i class="fa fa-thumbs-up">
                            </i>
                            Approve
                        </a>
                        @endif
                        <a class="btn btn-danger btn-sm  row-delete-btn" href="{{ route('approval.disapprove', ['id' => $row->app_id]) }}"  title="Disapproved">
                            <i class="fas fa-thumbs-down">
                            </i>
                            Disapproved
                        </a>
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