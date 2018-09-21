<!DOCTYPE html>
<html>
   <head>
      <title>Datatables</title>
      <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
   </head>
   <body>
      <div class="container" style="margin-top: 50px">
         <div class="row">
            <div class="col-md-12">
               <div class="panel panel-default">
                  <div class="panel panel-header">
                     <h3 align="center">DataTables Daftar Siswa</h3>
                     <button type="button" name="add" id="Tambah" class="btn btn-primary pull-right" style="margin-right: 15px; margin-top: 10px; margin-bottom: 10px">Add Data</button>
                  </div>
                  <div class="panel panel-body">
                     <table id="student_table" class="table table-bordered" style="width:100%">
                        <thead>
                           <tr>
                              <th>Nama Siswa</th>
                              <th>Jenis Kelamin</th>
                              <th>Jurusan</th>
                              <th>Kelas</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
      @include('tampilan')
      <script>
         $(document).ready(function() {
            $('#student_table').DataTable({
              processing: true,
              serverSide: true,
              ajax: '/json',
              columns:[
                  { data: 'Nama_Siswa', name: 'Nama_Siswa' },
                  { data: 'Jenis_Kelamin', name: 'Jenis_Kelamin'},
                  { data: 'Jurusan', name: 'Jurusan' },
                  { data: 'Kelas', name: 'Kelas' },
                  { data: 'action'}
              ],
            });

            $('#Tambah').click(function(){
              $('#studentModal').modal('show');
              $('#student_form')[0].reset();
              state = "insert";
            });
           $('#student_form').submit(function(e){
             $.ajaxSetup({
               header: {
                 'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
               }
             });

             e.preventDefault();

             if (state == 'insert'){
             $.ajax({
               type: "POST",
               url: "{{url ('/store')}}",
               data: $('#student_form').serialize(),
               dataType: 'json',
               success: function (data){
                 console.log(data);
                 $('#studentModal').modal('hide');
                 $('#student_table').DataTable().ajax.reload();
               },
               error: function (data){
                $('input').on('keydown keypress keyup click change', function(){
                  $(this).parent().removeClass('has-error');
                  $(this).next('.help-block').hide()
                });
                var coba = new Array();
                console.log(data.responseJSON.errors);
                $.each(data.responseJSON.errors,function(name, value){
                  console.log(name);
                  coba.push(name);
                  $('input[name='+name+']').parent().addClass('has-error');
                  $('input[name='+name+']').next('.help-block').show().text(value);
                });
                $('input[name='+coba[0]+']').focus();
               }
             }); 
           }else {
            $.ajax({
               type: "POST",
               url: "{{url ('/siswa/edit')}}"+ '/' + $('#id').val(),
               data: $('#student_form').serialize(),
               dataType: 'json',
               success: function (data){
                 console.log(data);
                 $('#studentModal').modal('hide');
                 $('#student_table').DataTable().ajax.reload();
               },
               error: function (data){
                $('input').on('keydown keypress keyup click change', function(){
                  $(this).parent().removeClass('has-error');
                  $(this).next('.help-block').hide()
                });
                var coba = new Array();
                console.log(data.responseJSON.errors);
                $.each(data.responseJSON.errors,function(name, value){
                  console.log(name);
                  coba.push(name);
                  $('input[name='+name+']').parent().addClass('has-error');
                  $('input[name='+name+']').next('.help-block').show().text(value);
                });
                $('input[name='+coba[0]+']').focus();
               }
             }); 
           }
             
           });

           $(document).on('click', '.edit', function(){
             var bebas = $(this).data('id');
             $('#form_output').html('');
             $.ajax({
                url:"{{url('siswa/getedit')}}" + '/' + bebas,
                method:'get',
                data:{id:bebas},
                dataType:'json',
                success:function(data)
                {
                  console.log(data);
                  state = "update";
                  $('#id').val(data.id);
                    $('#Nama_Siswa').val(data.Nama_Siswa);
                    if (data.Jenis_Kelamin == 'Laki-laki') {
                      $('#laki').prop('checked', true);
                    }else{
                      $('#wanita').prop('checked', true);
                    }
                    $('#Jurusan').val(data.Jurusan);
                    $('#Kelas').val(data.Kelas);
                    $('#student_id').val(bebas);
                    $('#studentModal').modal('show');
                    $('#aksi').val('Edit');
                    $('.modal-title').text('Edit Data');
                }
             });
             });

               $(document).on('click', '.delete', function(){
                var bebas = $(this).attr('id');
                if (confirm("Yakin Dihapus ?")) {
                  $.ajax({
                    url: "{{route('ajaxdata.removedata')}}",
                    method: "get",
                    data:{id:bebas},
                    success: function(data){
                      $('#student_table').DataTable().ajax.reload();
                    }
                  })
                }
                else{
                  return false;
                }
               });
             });
          
      </script>
   </body>
</html>