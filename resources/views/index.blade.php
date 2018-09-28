<!DOCTYPE html>
<html>
   <head>
      <title>Datatables</title>
      <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
   </head>
   <body>
      <div class="container" style="margin-top: 50px;">
         <div class="row">
            <div class="col-md-12">
               <div class="panel panel-default" style="margin-left: -60px; margin-right: -60px;">
                <button type="button" name="add" id="Tambah" class="btn btn-primary pull-right" style="margin-right: 15px; margin-top: 10px; margin-bottom: 10px">Add Data</button>
                  <div class="panel panel-header">
                     <h3 align="center">DataTables Daftar Siswa</h3>
                  </div>
                  <div class="panel panel-body">
                     <table id="student_table" class="table table-bordered" style="width:100%">
                        <thead>
                           <tr>
                              <th>Nama Siswa</th>
                              <th>Jenis Kelamin</th>
                              <th>Tanggal Lahir</th>
                              <th>Jurusan</th>
                              <th>Kelas</th>
                              <th>Alamat</th>
                              <th>Hobi</th>
                              <th>Gambar</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                     </table>
                     <button type="button" class="btn btn-primary pull-left"><a href="exportdata"><font color="white">Export PDF</font></a></button>
                  </div>
               </div>
            </div>
         </div>
      </div>

      @include('tampilan')
      <script type="text/javascript" src="{{asset ('loading-overlay/dist/loadingoverlay.min.js')}}"></script>

      <script>

        $(document).ready(function() {

          $.LoadingOverlay("show", {
            image: "{{asset('apa/Gear.gif')}}",
          });
          $('#student_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/json',
            columns:[
                  { data: 'Nama_Siswa', name: 'Nama_Siswa' },
                  { data: 'Jenis_Kelamin', name: 'Jenis_Kelamin'},
                  { data: 'Tanggal_Lahir', name: 'Tanggal_Lahir'},
                  { data: 'Jurusan', name: 'Jurusan' },
                  { data: 'Kelas', name: 'Kelas' },
                  { data: 'Alamat', name: 'Alamat'},
                  { data: 'Hobi', name: 'Hobi'},
                  { data: 'show_Foto', name: 'show_Foto'},
                  { data: 'action'}
              ],
            });
          $.LoadingOverlay('hide');

          $('#Tambah').click(function(){
            $.LoadingOverlay('show',{
              image: "{{asset('apa/Spin.gif')}}",
            });
            $.LoadingOverlay('hide');

            $('#studentModal').modal('show');
            $('#student_form')[0].reset();
            $('.modal-title').text('Add Data');
            $('#aksi').val('Tambah');
            $('.summernote').summernote("reset");

            state = "insert";

            });

          //menyeting error modal ke tampilan awal
          $('#studentModal').on('hidden.bs.modal',function(e){
            $(this).find('#student_form')[0].reset();
            $('span.has-error').text('');
            $('.form-group.has-error').removeClass('has-error');
            });

          $('#student_form').submit(function(e){
            $.ajaxSetup({
              header: {
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
              }
            });

            //menambah kan data
            e.preventDefault();

            if (state == 'insert'){

              $.ajax({
                type: "POST",
                url: "{{url ('/store')}}",
                data: new FormData(this),
               // data: $('#student_form').serialize(),
                contentType: false,
                processData: false,
                dataType: 'json',

                success: function (data){
                  console.log(data);
                  $('#studentModal').modal('hide');
                  $('#student_table').DataTable().ajax.reload();
                  swal({
                    title: 'Add Data Success',
                    text: data.message,
                    type: 'success',
                    timer: '3500'
                  });
                },

                //menampilkan validasi error
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
            else
            {
              //mengupdate data yang telah diedit
              $.ajax({
                type: "POST",
                url: "{{url ('/siswa/edit')}}"+ '/' + $('#id').val(),
                // data: $('#student_form').serialize(),
                data: new FormData(this),
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (data){
                  console.log(data);
                  $('#studentModal').modal('hide');
                  swal({
                    title: 'Update Success',
                    text: data.message,
                    type: 'success',
                    timer: '3500'
                  })
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

          //mengambil data yang ingin diedit
          $(document).on('click', '.edit', function(){
            $.LoadingOverlay('show',{
              image: "{{asset('apa/Spin.gif')}}",
            });
            $.LoadingOverlay('hide');

            var bebas = $(this).data('id');
            $('#form_output').html('');
            $.ajax({
              url:"{{url('siswa/getedit')}}" + '/' + bebas,
              method:'get',
              data:{id:bebas},
              dataType:'json',
              success:function(data){
                console.log(data);
                var hobi = data.Hobi;
                var hobi_array = hobi.split(',');
                console.log(hobi_array);
                state = "update";

                $('#id').val(data.id);
                $('#Nama_Siswa').val(data.Nama_Siswa);
                  if (data.Jenis_Kelamin == 'Laki-laki') {
                    $('#laki').prop('checked', true);
                  }
                  else
                  {
                    $('#wanita').prop('checked', true);
                  }
                  $('#tl').val(data.Tanggal_Lahir);
                  $('#Jurusan').val(data.Jurusan);
                  $('#Kelas').val(data.Kelas);
                  $('#Alamat').val(data.Alamat).summernote('focus');

                  for (i=0; i<hobi_array.length; i++) {
                    var checkbox = $("input[type='checkbox'][value='"+hobi_array[i]+"']");
                    checkbox.attr("checked","checked");
                  }

                  // var i = 0;
                    // while(i<hobi_array.length){
                    //   var checkbox = $("input[type='checkbox'][value='"+hobi_array[i]+"']");
                    //   checkbox.prop("checked", true);
                    //   i++;
                    // }

                  $('#studentModal').modal('show');
                  $('#aksi').val('Simpan');
                  $('.modal-title').text('Edit Data');
                }
              });
          });

          $(document).on('hide.bs.modal','#studentModal', function() {
            $('#student_table').DataTable().ajax.reload();
          });

          //proses delete ada
          $(document).on('click', '.delete', function(){
            var bebas = $(this).attr('id');
              if (confirm("Yakin Dihapus ?")) {

                $.ajax({
                  url: "{{route('ajaxdata.removedata')}}",
                  method: "get",
                  data:{id:bebas},
                  success: function(data){
                    swal({
                      title:'Success Delete!',
                      text:'Data Berhasil Dihapus',
                      type:'success',
                      timer:'1500'
                    });
                    $('#student_table').DataTable().ajax.reload();
                  }
                })
              }
              else
              {
                swal({
                  title:'Batal',
                  text:'Data Tidak Jadi Dihapus',
                  type:'error',
                  });
                return false;
              }
            });
        });

      </script>
   </body>
</html>