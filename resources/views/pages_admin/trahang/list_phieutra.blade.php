
@extends('admin.layout_admin')
@section('home')
<div class="col-md-12">
<h3 class="card-title">Danh sách phiếu trả</h3>
  <div class="text-right">
      <a class="btn btn-success mb-3" href="javascript:void(0)"
          id="create-phieutra"> Thêm Phiếu trả</a>
  </div>
</div>
<div class="container-fluid">
    <table class="display" id="phieutra-list" style="width:100%">
        <thead>
            <tr>
                <th>Mã phiếu trả</th>
                <th>Tên khách hàng</th>
                <th>Trạng thái</th>
                <th>Hoàn tiền</th>
                <th>Nhận lại hàng</th>
                <th>Tổng tiền</th>
                <th>Tác vụ</th>
            </tr>
        </thead>
    </table>
</div>


{{-- //Modal tạo phiếu trả --}}
<div class="modal fade" id="ajax-donhang-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="donhangCrudModal"></h4>
        </div>
        <div class="modal-body">
            <table class="display" id="donhang-list" style="width:100%">
                <thead>
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>khách hàng</th>
                        <th>Trạng thái</th>
                        <th>Tổng tiền</th>
                        <th>Tác vụ</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="modal-footer">

        </div>
    </div>
    </div>
    </div>
@endsection

@push('scripts')
<script type="text/javascript">
 $(document).ready( function () {
              $.ajaxSetup({
                 headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 }
             });
                $('#phieutra-list').DataTable({
                   processing: true,
                   serverSide: true,
                   ajax : '{!! route('getPhieutra') !!}',
                   columns: [
                    { data: 'id', name: 'id' },
                    { data: 'tenkh', name: 'tenkh'},
                    { data: 'trangthai', name: 'trangthai'},
                    { data: 'hoantien', name: 'hoantien'},
                    { data: 'nhanhang', name: 'nhanhang'},
                    { data: 'tongtien', name: 'tongtien'},
                    {data: 'action',name: 'action',orderable: false},

                   ]
               });

               $('#donhang-list').DataTable({
                   processing: true,
                   serverSide: true,
                   lengthMenu: [5],
                   lengthChange: false,
                   info: false,
                   ajax : '{!! route('getDonhangPT') !!}',
                   columns: [
                    { data: 'id', name: 'id' },
                    { data: 'hoten', name: 'hoten'},
                    { data: 'trangthai', name: 'trangthai'},
                    { data: 'tongtien', name: 'tongtien'},
                    {data: 'action',name: 'action',orderable: false},

                   ]
               });



//Show form Thêm
               $('#create-phieutra').click(function () {
               $('#btn-save').val("create-phieutra");
               $('#donhangForm').trigger("reset");
               $('#donhangCrudModal').html("Chọn đơn hàng cần trả");
               $('#ajax-donhang-modal').modal('show');
            });



//             $('#btn-save').click(function(e){
//                 e.preventDefault();
//                 $.ajaxSetup({
//                     headers: {
//                         'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
//                     }
//                 });
//                 $.ajax({
//                     url: "{{ url('/admin/dsphieutra-add')}}",
//                     method: 'post',
//                     data: {
//                         id: $('#id_th').val(),
//                         ten: $('#tenth').val(),
//                     },
//                     success: function(result){
//                         if(result.errors)
//                         {
//                             $('.alert-danger').html('');

//                             $.each(result.errors, function(key, value){
//                                 $('.alert-danger').show();
//                                 $('.alert-danger').append('<li>'+value+'</li>');
//                             });
//                             //tắt thông báo sau 3s
//                             setTimeout(function(){
//                                 $('.alert-danger').hide('');
//                             }, 3000);
//                         }
//                         else
//                         {
//                             location.reload('/admin/dsphieutra');
//                         }
//                     }
//                 });
//             });

//Xóa phiếu trả
            $('body').on('click', '#delete-phieutra', function () {
                var id = $(this).data("id");
                if(confirm("Bạn có chắc muốn xóa phiếu trả này!")){
                $.ajax({
                      type: "GET",
                      url:'/admin/dsphieutra-delete/'+id,
                      success: function (data) {
                            var oTable = $('#phieutra-list').dataTable();
                             oTable.fnDraw(false);
                             alertify.success("Đã xóa phiếu trả!");
                      },
                       error: function (data) {
                        //    console.log('Error:', data);
                        alertify.error("Không thể xóa phiếu trả này!");
                       }
                });
            }
        });
 });

</script>
@endpush
