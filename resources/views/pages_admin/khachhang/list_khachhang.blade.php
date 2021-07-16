@extends('admin.layout_admin')
@section('home')
<div class="col-md-12">
<h3 class="card-title">Danh sách khách hàng </h3>
  <div class="text-right">
      <a class="btn btn-success mb-3" href="{{ url('admin/danhsachkhachhang-add')}}"
          id="create-new-user"> Thêm khách hàng</a>
  </div>
</div>

<table class="display" id="user-list" style="width:100%">
        <thead>
            <tr>
                <th>Mã khách hàng</th>
                <th>Tên khách hàng</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Tác vụ</th>

            </tr>
        </thead>
</table>
@endsection

@push('scripts')
<script type="text/javascript">
 $(document).ready( function () {
              $.ajaxSetup({
                 headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 }
             });
                $('#user-list').DataTable({
                   processing: true,
                   serverSide: true,
                   ajax : '{!! route('getKhachhang') !!}',
                   columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name'},
                    { data: 'email', name: 'email'},
                    { data: 'sdt', name: 'sdt'},
                    {data: 'action',name: 'action',orderable: false},

                   ]
               });

 });
      $('body').on('click', '#delete-user', function () {

             var user_id = $(this).data("id");

             if(confirm("Bạn có chắc muốn xóa khách hàng này !")){
               $.ajax({
                   type: "GET",
                   url:'/admin/danhsachkhachhang-delete/'+user_id,
                   success: function (data) {
                   var oTable = $('#user-list').dataTable();
                   oTable.fnDraw(false);
                  //console.log(user_id);
                   },
                    error: function (data) {
                        console.log('Error:', data);
                    }
               });
             }
        });

</script>
@endpush




