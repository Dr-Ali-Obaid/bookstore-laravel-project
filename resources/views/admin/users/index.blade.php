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
    عرض المستخدمين
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <table id="books-table" class="table table-striped table-bordered text-end" width='100%' cellspacing="0">
                <thead>
                    <tr>
                        <th>الاسم</th>
                        <th>البريد الإلكتروني</th>
                        <th>نوع المستخدم</th>
                        <th>خيارات</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->isSuperAdmin() ? 'مدير عام' : ($user->isAdmin() ? 'مدير' : 'مستخدم') }}</td>
                            <td>
                                <form action="{{ route('users.update', $user) }}" class="me-4 form-inline" method="POST"
                                    style="display: inline-block">
                                    @method('patch')
                                    @csrf
                                    <select name="administration_level" class="form-control form-control-sm role-selector">
                                        <option value="" disabled selected>اختر نوعا</option>
                                        <option value="0" >مستخدم</option>
                                        <option value="1">مدير</option>
                                        <option value="2">مدير عام</option>
                                    </select>
                                    <button type="submit" class="btn btn-info btn-sm update-btn" disabled = 'true'><i
                                            class="fa-solid fa-pen-to-square"></i>تعديل</button>
                                </form>
                                <form action="{{ route('users.destroy', $user) }}" method="POST"
                                    style="display: inline-block">
                                    @method('delete')
                                    @csrf
                                    @if (auth()->user() != $user)
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('هل أنت متأكد ')"><i
                                                class="fa-solid fa-trash"></i>حذف</button>
                                    @else
                                        <div class="btn btn-danger btn-sm disabled"><i class="fa-solid fa-trash"></i>حذف
                                        </div>
                                    @endif
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

    document.querySelectorAll('.role-selector').forEach(selector =>{
        selector.addEventListener('change', function(){
            this.closest('form').querySelector('.update-btn').disabled = this.value === ''
        })
    })
     
    </script>
    </script>
@endsection
