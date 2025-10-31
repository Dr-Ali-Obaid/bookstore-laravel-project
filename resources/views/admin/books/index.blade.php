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
    عرض الكتب
@endsection

@section('content')
    <a href="{{ route('books.create') }}" class="btn btn-primary "><i class="fa-solid fa-plus ms-2"></i>أضف كتابا جديدا</a>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <table id="books-table" class="table table-striped table-bordered text-end" width='100%' cellspacing="0">
                <thead>
                    <tr>
                        <th>العنوان</th>
                        <th>الرقم التسلسلي</th>
                        <th>التصنيف</th>
                        <th>المؤلفون</th>
                        <th>الناشر</th>
                        <th>السعر</th>
                        <th>خيارات</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($books as $book)
                        <tr>
                            <td><a href="{{ route('books.show', $book) }}">{{ $book->title }}</a></td>
                            <td>{{ $book->isbn }}</td>
                            <td>{{ $book->category != null ? $book->category->name : '' }}</td>
                            <td>
                                @if ($book->authors->count() > 0)
                                    @foreach ($book->authors as $author)
                                        {{ $loop->first ? '' : ' و ' }}
                                        {{ $author->name }}
                                    @endforeach
                                @endif
                            </td>
                            <td>{{ $book->publisher != null ? $book->publisher->name : '' }}</td>
                            <td>{{ $book->price }} $</td>
                            <td class="d-flex justify-content-end gap-2">
                                <a href="{{ route('books.edit', $book) }}" class="btn btn-info btn-sm"> <i
                                        class="fa-solid fa-pen-to-square"></i> تعديل</a>
                                <form action="{{ route('books.destroy', $book) }}" method="POST">
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
