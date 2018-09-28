<?php

namespace App\Http\Controllers;

use App\DaftarSiswa;
use Illuminate\Http\Request;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Datatables;
use PDF;

class DaftarSiswaController extends Controller
{
    public function json()
    {
        $siswa = DaftarSiswa::all();
        return Datatables::of($siswa)
        ->addColumn('show_Foto', function($siswa){
            if($siswa->Foto == null){
                return 'no image';
            }

            return '<center><img class="rounded-square" width="70" height="70" src="' . url($siswa->Foto) . '?'.time().'" alt=""></center>';

            })

        ->addColumn('action', function($siswa){
            return '<a href="#" class="btn btn-xs btn-primary edit" data-id="'.$siswa->id.'">
            <i class="glyphicon glyphicon-edit"></i> Edit</a>&nbsp;
            <a href="#" class="btn btn-xs btn-danger delete" id="'.$siswa->id.'">
            <i class="glyphicon glyphicon-remove"></i> Delete</a>';

            })
        ->rawColumns(['action','show_Foto','Alamat'])->make(true);

        }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'Nama_Siswa' => 'required|unique:daftar_siswas,Nama_Siswa',
            'Jenis_Kelamin' => 'required',
            'Tanggal_Lahir' => 'required',
            'Jurusan' => 'required',
            'Kelas' => 'required',
            'Alamat' => 'required',
            'Hobi' => 'required',
        ],[
            'Nama_Siswa.unique' => 'Nama Sudah Ada',
            'Nama_Siswa.required' => 'Nama Tidak Boleh Kosong',
            'Jenis_Kelamin.required' => 'Harus Diisi',
            'Tanggal_Lahir.required' => 'Harus Diisi',
            'Jurusan.required' => 'Jurusan Tidak Boleh Kosong',
            'Kelas.required' => 'Kelas Tidak Boleh Kosong',
            'Alamat.required' => 'Tidak Boleh Kosong',
            'Hobi.required' => 'Tidak Boleh Kosong',
        ]);
        $data = new DaftarSiswa;
        $data->Nama_Siswa = $request->Nama_Siswa;
        $data->Jenis_Kelamin = $request->Jenis_Kelamin;
        $data->Tanggal_Lahir = $request->Tanggal_Lahir;
        $data->Jurusan = $request->Jurusan;
        $data->Kelas = $request->Kelas;
        $data->Alamat = $request->Alamat;
        $data->Hobi = implode(", ", $request->Hobi);
        
        $data['Foto'] = null;

        if ($request->hasFile('Foto')){
            $data['Foto'] = '/upload/photo/'.str_slug($data['Nama_Siswa'], '-').'.'.$request->Foto->getClientOriginalExtension();
            $request->Foto->move(public_path('/upload/photo/'),$data['Foto']);

        }

        $data->save();
        // $isi = DaftarSiswa::create($request->all());
        return response()->json(['success'=>true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DaftarSiswa  $daftarSiswa
     * @return \Illuminate\Http\Response
     */
    public function show(DaftarSiswa $daftarSiswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DaftarSiswa  $daftarSiswa
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $siswa = DaftarSiswa::findOrFail($id);
        return $siswa;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DaftarSiswa  $daftarSiswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'Nama_Siswa'=>'required',
            'Jenis_Kelamin'=>'required',
            'Tanggal_Lahir'=>'required',
            'Jurusan'=>'required',
            'Kelas'=>'required',
            'Alamat'=>'required',
        ],[
            'Nama_Siswa.unique' => 'Nama Sudah Ada',
            'Nama_Siswa.required' => 'Nama Tidak Boleh Kosong',
            'Jenis_Kelamin.required' => 'Tidak Boleh Kosong',
            'Tanggal_Lahir.required' => 'Harus Diisi',
            'Jurusan.required' => 'Jurusan Tidak Boleh Kosong',
            'Kelas.required' => 'Kelas Tidak Boleh Kosong',
            'Alamat.required' => 'Tidak Boleh Kosong',
        ]);
        $siswa = DaftarSiswa::findOrFail($id);
        $siswa->Nama_Siswa = $request->Nama_Siswa;
        $siswa->Jenis_Kelamin = $request->Jenis_Kelamin;
        $siswa->Tanggal_Lahir = $request->Tanggal_Lahir;
        $siswa->Jurusan = $request->Jurusan;
        $siswa->Kelas = $request->Kelas;
        $siswa->Alamat = $request->Alamat;
        $siswa->Hobi = implode(", ", $request->Hobi);

        $siswa['Foto'] = $siswa->Foto;

        if ($request->hasFile('Foto')){
            if (!$siswa->Foto == null ){
                unlink(public_path($siswa->Foto));
            }
            $siswa['Foto'] = '/upload/photo/'.str_slug($siswa['Nama_Siswa'], '-').'.'.$request->Foto->getClientOriginalExtension();
            $request->Foto->move(public_path('/upload/photo/'),$siswa['Foto']);
        }

        $success = $siswa->save();
        if ($success){
            return response()->json([
                'success'=>true,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DaftarSiswa  $daftarSiswa
     * @return \Illuminate\Http\Response
     */
    public function destroy(DaftarSiswa $daftarSiswa)
    {
        DaftarSiswa::destroy($id);
    }
    public function removedata(Request $request)
    {
        $siswa = DaftarSiswa::find($request->input('id'));
        if($siswa->delete())
        {
            if (!$siswa->Foto == null ){
                unlink(public_path($siswa->Foto));
            }
            echo 'Data Deleted';
        }
    }
    public function fetchdata(Request $request)
    {
        $id = $request->input('id');
        $siswa = DaftarSiswa::find($id);
        $output = array(
            'Nama_Siswa' => $siswa->Nama_Siswa,
            'Jenis_Kelamin' => $siswa->Jenis_Kelamin,
            'Tanggal_Lahir' => $siswa->Tanggal_Lahir,
            'Jurusan' => $siswa->Jurusan,
            'Kelas' => $siswa->Kelas,
            'Alamat' => $siswa->Alamat,
            'Hobi' => $siswa->Hobi,
            'Foto' => $siswa->Foto
        );
        echo json_encode($output);
    }
    public function exportdata(){
        $siswa = DaftarSiswa::limit(20)->get();
        $pdf = PDF::loadView('pdf', compact('siswa'));
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream();
        //return $pdf->download('invoice.pdf');
    }
}
