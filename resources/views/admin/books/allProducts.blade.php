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
    جميع المشتريات
@endsection

@section('content')
 
    <div class="row">
        <div class="col-md-12">
            <table id="books-table" class="table table-striped table-bordered text-end" width='100%' cellspacing="0">
                <thead>
                    <tr>
                        <th>المشتري</th>
                        <th>الكتاب </th>
                        <th>السعر</th>
                        <th>عدد النسخ</th>
                        <th>السعر الإجمالي</th>
                        <th>تاريخ الشراء</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($allBooks as $item)
                        <tr>
                            <td>{{$item->user::find($item->user_id)->name}}</td>
                            <td><a href="{{route('book.details', $item->book_id)}}">{{$item->book::find($item->book_id)->title}}</a></td>
                            <td>{{$item->price}}</td>
                            <td>{{$item->number_of_copies}} </td>
                            <td>{{$item->price * $item->number_of_copies }}$</td>
                            <td>{{$item->created_at->diffForHumans() }} $</td>
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
