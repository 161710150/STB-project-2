<?php

namespace App\Http\Controllers;

use App\DaftarSiswa;
use Illuminate\Http\Request;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Datatables;

class DaftarSiswaController extends Controller
{
    public function json()
    {
        $siswa = DaftarSiswa::select('id', 'Nama_Siswa','Jenis_Kelamin','Jurusan', 'Kelas');
     return Datatables::of($siswa)
            ->addColumn('action', function($siswa){
                return '<a href="#" class="btn btn-xs btn-primary edit" data-id="'.$siswa->id.'"><i class="glyphicon glyphicon-edit"></i> Edit</a>&nbsp;
                <a href="#" class="btn btn-xs btn-danger delete" id="'.$siswa->id.'"><i class="glyphicon glyphicon-remove"></i> Delete</a>';
            })
            ->make(true);
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
            'Jurusan' => 'required',
            'Kelas' => 'required'
        ],[
            'Nama_Siswa.unique' => 'Nama Sudah Ada',
            'Nama_Siswa.required' => 'Nama Tidak Boleh Kosong',
            'Jenis_Kelamin.required' => 'Tidak Boleh Kosong',
            'Jurusan.required' => 'Jurusan Tidak Boleh Kosong',
            'Kelas.required' => 'Kelas Tidak Boleh Kosong'
        ]);
        $request->get('button_action')== 'insert';
        $isi = DaftarSiswa::create($request->all());
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
        $siswa = DaftarSiswa::find($id);
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
            'Jurusan'=>'required',
            'Kelas'=>'required'
        ],[
            'Nama_Siswa.unique' => 'Nama Sudah Ada',
            'Nama_Siswa.required' => 'Nama Tidak Boleh Kosong',
            'Jenis_Kelamin.required' => 'Tidak Boleh Kosong',
            'Jurusan.required' => 'Jurusan Tidak Boleh Kosong',
            'Kelas.required' => 'Kelas Tidak Boleh Kosong'
        ]);
        $siswa = DaftarSiswa::find($id);
        $siswa->Nama_Siswa = $request->Nama_Siswa;
        $siswa->Jenis_Kelamin = $request->Jenis_Kelamin;
        $siswa->Jurusan = $request->Jurusan;
        $siswa->Kelas = $request->Kelas;
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
            echo 'Data Deleted';
        }
    }
    public function fetchdata(Request $request)
    {
        $id = $request->input('id');
        $siswa = DaftarSiswa::find($id);
        $output = array(
            'Nama_Siswa'    =>  $siswa->Nama_Siswa,
            'Jenis_Kelamin' => $siswa->Jenis_Kelamin,
            'Jurusan' => $siswa->Jurusan,
            'Kelas'     =>  $siswa->Kelas
        );
        echo json_encode($output);
    }
}
