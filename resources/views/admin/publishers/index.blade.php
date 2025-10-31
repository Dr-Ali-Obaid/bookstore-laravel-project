@extends('theme.default')

@section('head')
    <!-- DataTables Bootstrap 5 CSS from CDN -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        table.dataTable thead th,
        table.dataTable thead td,
        table.dataTable tfoot th,
        table.dataTable tfoot td {
            text-align: right !important;
        }
    </style>
@endsection

@section('heading')
    عرض الناشرين
@endsection

@section('content')
    <a href="{{ route('publishers.create') }}" class="btn btn-primary "><i class="fa-solid fa-plus ms-2"></i>أضف ناشرا جديدا</a>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <table id="books-table" class="table table-striped table-bordered text-end" width='100%' cellspacing="0">
                <thead>
                    <tr>
                        <th>الاسم</th>
                        <th>العنوان</th>
                        <th>خيارات</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($publishers as $publisher)
                        <tr>
                            <td>{{ $publisher->name }}</td>
                            <td>{{ $publisher->address }}</td>
                            <td class="d-flex justify-content-end gap-2">
                                <a href="{{ route('publishers.edit', $publisher) }}" class="btn btn-info btn-sm"> <i
                                        class="fa-solid fa-pen-to-square"></i> تعديل</a>
                                <form action="{{ route('publishers.destroy', $publisher) }}" method="POST">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('هل أنت متأكد')"><i
                                            class="fa-solid fa-trash"></i>حذف</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
@endsection

@section('script')
    <!-- DataTables JS from CDN -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#books-table').DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/2.3.2/i18n/ar.json"
                },
            })
        })
    </script>
@endsection
