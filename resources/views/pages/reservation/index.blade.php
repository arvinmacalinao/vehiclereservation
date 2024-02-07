@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'reservation'
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
        <div class="row">
            <div class="col-md-6">
                <a class="btn btn-success btn-sm m-2" href="{{ route('reservation.add') }}">
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
                    <th>Date of Travel</th>
                    <th class="text-nowrap">Plate Number</th>
                    <th class="text-nowrap">Driver</th>
                    <th class="text-nowrap">Destination</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Created At</th>
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
                    <td class="text-nowrap"><div>{!! $row->reservation_dates !!}</div></td>
                    <td></td>
                    {{-- <a class="text-primary" data-toggle="tooltip" data-placement="left" title="{{ $reservation->passenger_names() }}" href="#">{{ $reservation->vehicle == null ? '' : $reservation->vehicle->plate_number }}</a> --}}
                    <td class="text-nowrap">{!! $row->driver_name !!}</td>
                    <td class="w-50 mw-0 long-text"><a class="text-primary" data-placement="left" data-toggle="tooltip" data-placement="top" title="{{ $row->purpose }}" href="#">{!! nl2br($row->destination) !!}</a></td> 
                    <td class="text-center"></td>                
                    {{-- @include('layouts.status', ['approvals' => $reservation]) --}}
                    <td class="text-center text-nowrap">{!! $reservation->created_at->format('F d, Y h:i A') !!}</td>
                    <td  class="project-actions text-right">
                        <a class="btn btn-primary btn-sm" href="#">
                            <i class="fas fa-folder">
                            </i>
                            View
                        </a>
                        <a class="btn btn-success btn-sm" href="{{ route('driver.edit', ['id' => $row->d_id]) }}">
                            <i class="fas fa-pencil-alt">
                            </i>
                            Edit
                        </a>
                        <a class="btn btn-danger btn-sm  row-delete-btn" href="{{ route('driver.delete', ['id' => $row->d_id]) }}" data-msg="Delete this item?" data-text="#{{ $ctr }}" title="Delete">
                            <i class="fas fa-trash">
                            </i>
                            Delete
                        </a>
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
    setup_grid_delete_btns();
    setup_confirm_modal_btns();

    $(".alert").delay(4000).slideUp(200, function() {
        $(this).alert('close');
    });

    $('#page-select').change(function() {
        window.location.href = $(this).val();
    });
});
</script>
@endpush