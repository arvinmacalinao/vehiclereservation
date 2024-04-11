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
                <a class="btn btn-success btn-sm m-2" href="{{ route('group.add') }}">
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
                    <th>Name</th>
                    <th>Recommending</th>
                    <th>Approval</th>
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
                    <td>{{ $row->name }}</td>
                    <td>{{ $row->recommending }}</td>
                    <td>{{ $row->approval }}</td>
                    <td  class="project-actions text-right">
                        <a class="btn btn-success btn-sm" href="{{ route('group.edit', ['id' => $row->g_id]) }}">
                            <i class="fas fa-pencil-alt">
                            </i>
                            Edit
                        </a>
                        <a class="btn btn-danger btn-sm  row-delete-btn" href=" {{ route('group.delete', ['id' => $row->g_id]) }}" data-msg="Delete this item?" data-text="#{{ $ctr }}" title="Delete">
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

    $(".alert").delay(4000).slideUp(200, function() {
        $(this).alert('close');
    });

    $('#page-select').change(function() {
        window.location.href = $(this).val();
    });
});
</script>
@endpush