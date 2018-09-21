<!DOCTYPE html>
<html>
   <head>
      <title>Datatables</title>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
      <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
      <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>       
      <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
   </head>
   <body>
      <div id="studentModal" class="modal fade" role="dialog" aria-hidden="true" data-backdrop="static">
      <div class="modal-dialog">
         <div class="modal-content">
            <form method="post" id="student_form">
               <div class="modal-header" style="background-color: lightblue;">
                  <button type="button" class="close" data-dismiss="modal" >&times;</button>
                  <h4 class="modal-title" >Add Data</h4>
               </div>
               <div class="modal-body">
                  {{csrf_field()}}
                  <span id="form_output"></span>
                  <div class="form-group">
                     <input type="hidden" name="id" id="id">
                     <label>Nama Siswa</label>
                     <input type="text" name="Nama_Siswa" id="Nama_Siswa" class="form-control" placeholder="masukan nama anda" />
                     <span class="help-block has-error Nama_Siswa_error"></span>
                  </div>
                  <div class="form-group">
                  <label>Jenis Kelamin</label>
                  <br>
                  <form>
                  <input type="radio" id="laki" name="Jenis_Kelamin" value="Laki-laki" > Laki-laki
                  <input type="radio" id="wanita" name="Jenis_Kelamin" value="Perempuan" > Perempuan
                  </form>
                  <span class="help-block has-error Jenis_Kelamin_error"></span>
                  </div>
                  <div class="form-group">
                     <label>Jurusan</label>
                     <input type="text" name="Jurusan" id="Jurusan" class="form-control" placeholder="masukan nama jurusan" />
                     <span class="help-block has-error Jurusan_error"></span>
                  </div>
                  <div class="form-group">
                     <label>Kelas</label>
                     <input type="text" name="Kelas" id="Kelas" class="form-control" placeholder="masukan kelas anda" />
                     <span class="help-block has-error Kelas_error"></span>
                  </div>
                  <div class="modal-footer">
                     <input type="hidden" name="student_id" id="student_id" value="" />
                     <input type="hidden" name="button_action" id="button_action" value="insert" />
                     <input type="submit" name="submit" id="aksi" value="Tambah" class="btn btn-info" />
                  </div>
            </form>
            </div>
         </div>
      </div>
   </body>
</html>
