@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'view'
])
@section('content')
<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">{{ $data['page'] }} Details</h3>
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
              @if (!$r->approvals || $r->approvals->where('status_id', '2')->isEmpty())
              <form action="{{ route('approval.approve', ['id' => $app_id]) }}" method="post" style="display: inline;">
                  @csrf
                  <button type="submit" class="btn btn-success btn-sm" title="Approve"><span class="fa fa-thumbs-up"></span> Approve</button>
              </form>
            @endif
                <a class="btn btn-primary btn-sm" href="{{ url()->previous() }}" title="Back"><span class="fa fa-caret-left"></span> Back</a>
            </div>
            <div class="border-bottom mt-0 mb-2"></div>
        </div>
        <div>
          <input type="hidden" name="app_id" value="{{ $app_id }}">
            asd
        </div>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  <!-- /.content -->
@endsection
@push('scripts')
    <script>
    
    </script>
@endpush