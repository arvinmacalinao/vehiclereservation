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
        @php
            $vehicle =  \App\Models\Vehicle::where('v_id', $id)->first();
        @endphp
        <h3 class="card-title">Vehicle: <Strong>{{ $vehicle->equipment_name }} - {{ $vehicle->plate_number }}</Strong></h3>
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
                    <th>Date of Travel</th> 
                    <th class="text-nowrap">Driver</th>
                    <th class="text-nowrap">Destination</th>
                    <th class="text-nowrap">Purpose</th>
                    <th class="text-center" width="30%">Status</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $ctr = $rows->firstItem();
             ?>
            <tbody>
                @foreach ($rows as $row)
                    @php
                        // Parse the reservation date or set a default if null
                        $reservationDate = $row->start_date ? \Carbon\Carbon::parse($row->start_date) : null;
            
                        // Determine row class based on the date
                        if ($reservationDate->isToday()) {
                            $dateClass = 'table-success';
                        } elseif ($reservationDate->isFuture()) {
                            $dateClass = 'table-primary';
                        } else {
                            $dateClass = 'table-secondary';
                        }
                    @endphp
                    <tr class="{{ $dateClass }}">
                        <td>{{ $ctr++ }}</td>
                        <td class="text-nowrap"><div>{!! $row->reservation_dates ?? 'N/A' !!}</div></td>
                        <td class="text-nowrap">{!! optional($row->drivers)->fullName ?? 'N/A' !!}</td>
                        <td class="">{!! nl2br($row->destination ?? 'N/A') !!}</td>
                        <td>{{ $row->purpose ?? 'N/A' }}</td>
                        <td class="text-center">{{ optional($row->status)->name ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
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