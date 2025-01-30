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
                    <th class="text-nowrap" width="30%">Destination</th>
                    <th class="text-center" width="30%">Status</th>
                    <th class="text-center">Created By</th>
                    <th class="text-center">Created At</th>
                    <th class="text-center" width="40%">Action</th>
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
                    <td>{{ $row->vehicle->equipment_name ?? '-' }}</td>
                    {{-- <a class="text-primary" data-toggle="tooltip" data-placement="left" title="{{ $reservation->passenger_names() }}" href="#">{{ $reservation->vehicle == null ? '' : $reservation->vehicle->plate_number }}</a> --}}
                    <td class="text-nowrap">{!! $row->driver->name ?? '-' !!}</td>
                    <td class="w-30 mw-0 long-text"><a class="text-primary" data-placement="left" data-toggle="tooltip" data-placement="top" title="{{ $row->purpose }}" href="#">{!! nl2br($row->destination) !!}</a></td> 
                    <td class="text-center">
                    @if($row->status_id == 3)
                        <small><i class="fa fa-times-circle text-danger" data-toggle="tooltip" data-placement="top" title="Cancelled"></i> Cancelled</small>
                    @else
                        @php
                            $res_ug_id      = \App\Models\UserGroup::where('u_id', $row->u_id)->value('g_id');
                            $ug_approval    = \App\Models\Approval::where('g_id', $res_ug_id)->where('r_id', $row->r_id)->first();

                            $rdu_approval   = \App\Models\Approval::where('g_id', 3)->where('r_id', $row->r_id)->first();
                        @endphp
                        @if($ug_approval->status_id == 1)
                            <small>For Supervisor Approval: <i class="fa fa-exclamation-circle text-warning" data-toggle="tooltip" data-placement="top" title="Pending"></i></small><br>
                        @elseif($ug_approval->status_id == 4)
                            <small>For Supervisor Approval: <i class="fa fa-exclamation-circle text-warning" data-toggle="tooltip" data-placement="top" title="Pending"></i></small><br>
                        @else
                        <small>
                            Approved by: {!! $ug_approval->user->last_name !!}:
                            {!! $ug_approval->status_id == null ? '<i class="fa fa-exclamation-circle text-warning" data-toggle="tooltip" data-placement="top" title="Pending"></i>' : ($ug_approval->status_id == 2 ? '<i class="fa fa-check-circle text-success" data-toggle="tooltip" data-placement="top" title="Approved"></i>' : '<i class="fa fa-times-circle text-danger" data-toggle="tooltip" data-placement="top" title="Disapproved"></i>') !!}
                            {!! $ug_approval->created_at->format('F d, Y h:i A') ?? '' !!}
                            <br>
                        </small>
                        @endif   
                        @if(!$rdu_approval)
                            <small>For RDU Approval: <i class="fa fa-exclamation-circle text-warning" data-toggle="tooltip" data-placement="top" title="Pending"></i></small>
                        @elseif($rdu_approval->status_id == 1)
                            <small>For RDU Approval: <i class="fa fa-exclamation-circle text-warning" data-toggle="tooltip" data-placement="top" title="Pending"></i></small>
                        @elseif($row->status_id == 5)
                        <small> RDU Approval: Unavailable Car/Driver <i class="fa fa-ban text-warning" data-toggle="tooltip" data-placement="top" title="Unavailable"></i></small>
                        @elseif($rdu_approval->status_id == 2)
                        <small>
                            Approved by: {!! $rdu_approval->user->last_name !!}:
                            {!! $rdu_approval->status_id == null ? '<i class="fa fa-exclamation-circle text-warning" data-toggle="tooltip" data-placement="top" title="Pending"></i>' : ($rdu_approval->status_id == 2 ? '<i class="fa fa-check-circle text-success" data-toggle="tooltip" data-placement="top" title="Approved"></i>' : '<i class="fa fa-times-circle text-danger" data-toggle="tooltip" data-placement="top" title="Disapproved"></i>') !!}
                            {!! $rdu_approval->created_at->format('F d, Y h:i A') ?? '' !!}
                        </small>
                        @endif
                        @endif
                    </td>                
                    <td class="text-center text-nowrap">{{ $row->user->FullName ?? '' }}</td>
                    <td class="text-center text-nowrap">{{ \Carbon\Carbon::parse($row->created_at)->format('Y-m-d') }}</td>
                    <td  class="text-right">
                        @if($row->status_id == 3)
                        
                        @else
                        <a class="btn btn-primary btn-sm" href="{{ route('reservation.view.view', ['id' => $row->r_id]) }}">
                            <i class="fas fa-folder">
                            </i>
                            View
                        </a>
                        @if(!$row->approvals()->where('status_id', 2)->exists())
                        <a class="btn btn-success btn-sm" href="{{ route('reservation.edit', ['id' => $row->r_id]) }}">
                            <i class="fas fa-pencil-alt">
                            </i>
                            Edit
                        </a>
                        @endif
                        
                        <a class="btn btn-danger btn-sm  row-delete-btn" href="{{ route('reservation.cancel', ['id' => $row->r_id]) }}" data-msg="Delete this item?" data-text="#{{ $ctr }}" title="Cancel">
                            <i class="fas fa-times">
                            </i>
                            Cancel
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
        alert(1);
    $(".alert").delay(4000).slideUp(200, function() {
        $(this).alert('close');
    });

    $('#page-select').change(function() {
        window.location.href = $(this).val();
    });
});
</script>
@endpush