<div class="row">
    <div class="col-md-6">
        <a class="btn sm-btn btn-success btn-sm m-2" href="#">
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
        <hr>
    </div>
</div>

<table class="table table-striped projects">
    <thead>
        <tr>
            <th>#</th>
            <th>Plate Number</th>
            <th>Equipment Name</th>
            <th>Code Number</th>
            <th>Model Number</th>
            <th>Vehicle Type</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td  class="project-actions text-right">
                <a class="btn btn-primary btn-sm" href="#">
                    <i class="fas fa-folder">
                    </i>
                    View
                </a>
                <a class="btn btn-info btn-sm" href="#">
                    <i class="fas fa-pencil-alt">
                    </i>
                    Edit
                </a>
                <a class="btn btn-danger btn-sm" href="#">
                    <i class="fas fa-trash">
                    </i>
                    Delete
                </a>
            </td>
        </tr>
    </tbody>
</table>