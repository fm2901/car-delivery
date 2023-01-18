@extends('layouts.app')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"/>
<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">

@section('content')

    <div class="container">
        <div class="row">
            <div class="col">
                <form method="POST" enctype="multipart/form-data" action="{{ route('import') }}">
                    @csrf
                    <div class="p-6 bg-white border-b border-gray-200">
                        <input type="file" value="Загрузить машины" name="import" onchange="this.form.submit()">
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-bordered table-responsive-sm yajra-datatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>LOT</th>
                            <th>Sale date</th>
                            <th>Container</th>
                            <th>Marka model</th>
                            <th>VIN kod</th>
                            <th>Warehouse</th>
                            <th>Owner</th>
                            <th>Photos</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
    $(function () {

        var table = $('.yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            paging: true,
            ajax: "{{ route('cars.list') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'lot', name: 'lot'},
                {data: 'saledate', name: 'saledate'},
                {data: 'container', name: 'container'},
                {data: 'name', name: 'name'},
                {data: 'vincode', name: 'vincode'},
                {data: 'warehouse', name: 'warehouse'},
                {data: 'owner', name: 'owner'},
             //   {data: 'photo', name: 'photo'},
                {
                    data: 'action',
                    name: 'action',
                    orderable: true,
                    searchable: true
                },
            ]
        });

    });
</script>
