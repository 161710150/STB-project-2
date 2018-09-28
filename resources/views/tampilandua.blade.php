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
      <script type="text/javascript" src="{{ asset('sweetalert2/sweetalert2.min.js')}}"></script>
      <script type="text/javascript" src="{{ asset('sweetalert2/sweetalert2.min.css')}}"></script>
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
      <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
      <link href="{{ asset('/summernote/dist/summernote.css')}}" rel="stylesheet">
      <script src="{{ asset('/summernote/dist/summernote.js')}}"></script>
   </head>
   <body>
      <div id="studentModal2" class="modal fade" role="dialog" aria-hidden="true" data-backdrop="static">
      <div class="modal-dialog">
         <div class="modal-content">
            <form method="post" id="student_form" enctype="multipart/form-data">
               <div class="modal-header" style="background-color: lightblue;">
                  <button type="button" class="close" data-dismiss="modal" >&times;</button>
                  <h4 class="modal-title" >Add Data</h4>
               </div>

               <div class="modal-body">
                  {{csrf_field()}} {{ method_field('POST') }}
                  <span id="form_output"></span>
               
                  <div class="form-group">
                     <input type="hidden" name="id" id="id">
               
                     <label>Nama Siswa</label>
                     <input type="text" name="Nama_Siswa" id="Nama_Siswa" class="form-control" placeholder="masukan nama anda" />
                     <span class="help-block has-error Nama_Siswa_error"></span>
                  </div>
               
                  <div class="form-group">
                     <label>Jenis Kelamin</label>
                     <form>
                        <p><input type="radio" id="laki" name="Jenis_Kelamin" value="Laki-laki" > Laki-laki</p>
                           <input type="radio" id="wanita" name="Jenis_Kelamin" value="Perempuan" > Perempuan
                     </form>
                           <span class="help-block has-error Jenis_Kelamin_error"></span>
                  </div>

                  <div class="form-group">
                     <label>Tanggal Lahir</label>
                           <input type="date" name="Tanggal_Lahir" id="tl" class="form-control" />
                           <span class="help-block has-error Tanggal_Lahir_error"></span>
                  </div>
            
                  <div class="form-group">
                     <label>Jurusan</label>
                           <input type="text" name="Jurusan" id="Jurusan" class="form-control" placeholder="masukan nama jurusan" />
                           <span class="help-block has-error Jurusan_error"></span>
                  </div>

                  <div class="form-group">
                     <label>Kelas</label>
                     <select class="form-control" name="Kelas" id="Kelas">
                        <option disabled selected>Pilih Kelas</option>
                        <option value="X   ( Sepuluh )">X ( Sepuluh )</option>
                        <option value="XI  ( Sebelas )">XI ( Sebelas )</option>
                        <option value="XII ( Duabelas )">XII ( Dua Belas )</option>
                     </select>
                     <span class="help-block has-error Kelas_error"></span>
                  </div>

                  <div class="form-group">
                     <label>Alamat</label>
                           <textarea type="text" name="Alamat" class="summernote" id="Alamat" class="form-control" placeholder="masukan alamat anda"></textarea>
                     <span class="help-block has-error Alamat_error"></span>
                  </div>
      
                  <div class="form-group">
                     <label>Pilih Hobi</label>
                           <p><input type="checkbox" name="Hobi[]" value="Sepak Bola" > Sepak Bola</p>
                           <p><input type="checkbox" name="Hobi[]" value="Volly" > Volly</p>
                           <p><input type="checkbox" name="Hobi[]" value="Futsal" > Futsal</p>
                           <p><input type="checkbox" name="Hobi[]" value="Badminton" > Badminton</p>
                           <p><input type="checkbox" name="Hobi[]" value="Basket" > Basket</p>
                           <span class="help-block has-error Hobi_error"></span>
                  </div>

                  <div class="form-group">
                     <label>Gambar</label>
                           <input type="file" name="Foto" id="Foto" class="form-control" placeholder="masukan nama jurusan" />
                           <span class="help-block has-error Foto_error"></span>
                  </div>

                  <div class="modal-footer">
                        <input type="submit" name="submit" id="aksi" value="Tambah" class="btn btn-info" />
                  </div>
               </form>
            </div>
         </div>
      </div>
   </body>
</html>