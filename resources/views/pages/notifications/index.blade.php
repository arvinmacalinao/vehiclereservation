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
                    <th>Notification Message</th>
                    <th>created_at</th>
                    <th>updated_at</th>
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
                    <td>{{ $row->not_message }}</td>
                    <td>{{ $row->created_at }}</td>
                    <td>{{ $row->updated_at }}</td>
                    <td  class="project-actions text-right">
                      @if($row->app_id != null)
                      @php
                        $r_id =  App\Models\Approval::where('app_id', $row->app_id)->value('r_id');
                      @endphp
                        <a class="btn btn-primary btn-sm approve_btn" href="{{ route('reservation.view', ['id' => $r_id, 'app_id' => $row->app_id]) }}"><i class="fas fa-folder"></i> View Approval</a>
                      @elseif($row->new_user_id != null)
                        <a class="btn btn-primary btn-sm newuser_btn" href="{{ route('user.profile', ['id' => $row->new_user_id]) }}"><i class="fas fa-folder"></i> View New User</a>
                      @elseif($row->r_id != null)
                        <a class="btn btn-primary btn-sm reservation_btn" href="{{ route('reservation.view.view', ['id' => $row->r_id]) }}"><i class="fas fa-folder"></i> View Reservation</a>
                      @endif
                        <a class="btn btn-info btn-sm  row-delete-btn" href="{{ route('mark-single-as-read', ['notification' => $row]) }}" data-msg="Delete this item?" data-text="#{{ $ctr }}" title="Delete"><i class="fas fa-check"></i> Mark as Read</a>
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