
@extends('admin.layout_admin')
@section('home')
<div class="col-md-12 mt-5">
<h3 class="card-title">Danh sách Khách hàng</h3>
  <div class="text-right">
      <a class="btn btn-success mb-3" href="javascript:void(0)" id="create-khachhang"> Thêm khách hàng</a>
  </div>
</div>
<div class="container-fluid">
    <table class="display" id="khachhang-list" style="width:100%">
        <thead>
            <tr>
                <th>Mã khách hàng</th>
                <th>Tên khách hàng</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Tổng giao dịch</th>
                <th>Tác vụ</th>
            </tr>
        </thead>
</table>
</div>

<div class="modal fade" id="ajax-khachhang-modal" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="khachhangCrudModal"></h4>
        </div>
        <div class="modal-body">
            <form action="{{URL('/admin/dskhachhang-add')}}" method="post" id="khachhangForm" >
                @csrf
                <div class="form-group">
                    <label for="id_khachhang" class="col-sm-5 control-label">Mã khách hàng</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="id_khachhang" name="id_khachhang" value="" maxlength="50" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="tenkh" class="col-sm-5 control-label">Tên khách hàng(*)</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="tenkh" name="tenkh" value="" maxlength="50" required >
                        @if($errors->has('tenkh'))
                        <div class="text-danger">
                        {{$errors->first('tenkh')}}
                        </div>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="sdt" class="col-sm-5 control-label">Số điện thoại(*)</label>
                    <div class="col-sm-12">
                        <input type="number" class="form-control" id="sdt" name="sdt" value=""  max="" required >
                        @if($errors->has('sdt'))
                        <div class="text-danger">
                        {{$errors->first('sdt')}}
                        </div>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-5 control-label">Email(*)</label>
                    <div class="col-sm-12">
                        <input type="email" class="form-control" id="email" name="email" value="" maxlength="50" required>
                        @if($errors->has('email'))
                        <div class="text-danger">
                        {{$errors->first('email')}}
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-sm-offset-2 col-sm-10">
                 <button type="submit" class="btn btn-success" id="btn-save" value="create" >Lưu</button>
                </div>
            </form>
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
                $('#khachhang-list').DataTable({
                   processing: true,
                   serverSide: true,
                   ajax : '{!! route('getKhachhang') !!}',
                   columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name'},
                    { data: 'email', name: 'email'},
                    { data: 'sdt', name: 'sdt'},
                    { data: 'tonggd', name: 'tonggd'},
                    {data: 'action',name: 'action',orderable: false},

                   ]
               });
//Show form Thêm
               $('#create-khachhang').click(function () {
               $('#btn-save').val("create-khachhang");
               $('#khachhangForm').trigger("reset");
               $('#khachhangCrudModal').html("Thêm Khách Hàng");
               $('#ajax-khachhang-modal').modal('show');
            });

 //Show form sửa
           $('body').on('click', '#edit-khachhang', function () {
             var id = $(this).data('id');
             $.get('/admin/dskhachhang-edit/'+id, function (data) {
                $('#khachhangCrudModal').html("Sửa Khách Hàng");
                 $('#btn-save').val("edit-khachhang");
                 $('#ajax-khachhang-modal').modal('show');
                 $('#id_khachhang').val(data.id);
                 $('#tenkh').val(data.name);
                 $('#sdt').val(data.sdt);
                 $('#email').val(data.email);
             })
          });

//Xóa Thương hiệu
            $('body').on('click', '#delete-khachhang', function () {
                var id = $(this).data("id");
                if(confirm("Bạn có chắc muốn xóa khách hàng!")){
                $.ajax({
                      type: "GET",
                      url:'/admin/dskhachhang-delete/'+id,
                      success: function (data) {
                      var oTable = $('#khachhang-list').dataTable();
                      oTable.fnDraw(false);
                     //console.log(product_id);
                      },
                       error: function (data) {
                           console.log('Error:', data);
                       }
                });
            }
        });
 });

</script>
@endpush
