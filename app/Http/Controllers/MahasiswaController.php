<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa; 
use Illuminate\Http\Request;
use App\Models\kelas;
use Illuminate\Support\Facades\DB;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        // //fungsi eloquent menampilkan data menggunakan pagination 
        // $mahasiswas = Mahasiswa::all(); 
        // Mengambil semua isi tabel 
        // $mahasiswas = Mahasiswa::orderBy('Nim', 'asc')
        // ->paginate(5); 
        // return view('mahasiswas.index', compact('mahasiswas')); 
        // with('i', (request()->input('page', 1) - 1) * 5); 

        $mahasiswas = Mahasiswa::with('kelas')->get();
        $paginate = Mahasiswa::orderBy('nim', 'asc')->paginate(3);
        return view('mahasiswas.index', ['Mahasiswa'=> $mahasiswas,'paginate'=>$paginate]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kelas = Kelas::all();
        return view('mahasiswas.create',['kelas' => $kelas]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        //melakukan validasi data 
        $request->validate([ 
            'Nim' => 'required', 
            'Nama' => 'required', 
            'Jurusan' => 'required', 
            // 'No_Handphone' => 'required', 
            // 'email' => 'required',
            // 'tgl_lahir' => 'required'
        ]); 

        $Mahasiswa = new Mahasiswa;
        $Mahasiswa->nim = $request->get('Nim');
        $Mahasiswa->nama = $request->get('Nama');
        $Mahasiswa->jurusan = $request->get('Jurusan');
        $Mahasiswa->no_handphone = $request->get('No_Handphone');
        $Mahasiswa->email = $request->get('email');
        $Mahasiswa->tgl_lahir = $request->get('tgl_lahir');
        $Mahasiswa->save();

        $kelas = new Kelas;
        $kelas->id = $request->get('kelas');

        //fungsi eloquent untuk menambah data dengan relasi belongsTo
        $Mahasiswa->kelas()->associate($kelas);
        $Mahasiswa->save();

        // //fungsi eloquent untuk menambah data 
        // Mahasiswa::create($request->all()); 
        
        //jika data berhasil ditambahkan, akan kembali ke halaman utama 
        return redirect()->route('mahasiswas.index') 
        ->with('success', 'Mahasiswa Berhasil Ditambahkan'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($Nim)
    { 
        //menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa 
        // $Mahasiswa = Mahasiswa::find($Nim); 
        $mahasiswas = Mahasiswa::with('kelas')->where('nim',$Nim)->first(); 
        return view('mahasiswas.detail', ['Mahasiswa' => $mahasiswas]); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $Nim
     * @return \Illuminate\Http\Response
     */
    public function edit($Nim)
    {
        //menampilkan detail data dengan menemukan berdasarkan Nim Mahasiswa untuk diedit 
        // $Mahasiswa = Mahasiswa::find($Nim); 
        $mahasiswas = Mahasiswa::with('kelas')->where('nim',$Nim)->first(); 
        $kelas = Kelas::all();
        return view('mahasiswas.edit', compact('mahasiswas','kelas')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $Nim)
    { 
        //melakukan validasi data 
        $request->validate([ 
            'Nim' => 'required', 
            'Nama' => 'required', 
            'Kelas' => 'required', 
            'Jurusan' => 'required', 
            // 'No_Handphone' => 'required',
            // 'email' => 'required',
            // 'tgl_lahir' => 'required'
            ]); 
       
        $mahasiswas = Mahasiswa::with('kelas')->where('nim',$Nim)->first(); 
        $mahasiswas->nim = $request->get('Nim');
        $mahasiswas->nama = $request->get('Nama');
        $mahasiswas->jurusan = $request->get('Jurusan');
        $mahasiswas->save();

        $kelas = new Kelas;
        $kelas->id = $request->get('kelas');

        //fungsi eloquent untuk mengupdate data dengan relasi belongTo
        $mahasiswas->kelas()->associate($kelas);
        $mahasiswas->save90;
        //fungsi eloquent untuk mengupdate data inputan kita 
        // Mahasiswa::find($Nim)->update($request->all()); 
        
        //jika data berhasil diupdate, akan kembali ke halaman utama 
        return redirect()->route('mahasiswas.index') 
        ->with('success', 'Mahasiswa Berhasil Diupdate'); 
    } 

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($Nim)
    {
        //fungsi eloquent untuk menghapus data 
        Mahasiswa::find($Nim)->delete(); 
        return redirect()->route('mahasiswas.index') 
        -> with('success', 'Mahasiswa Berhasil Dihapus'); 
    }

    public function cari (Request $request)
    {
        $cari = $request -> get ('cari');
        if ($cari) {
            $mahasiswas = Mahasiswa::where('Nama','like','%'.$cari.'%')->paginate(5);
        } else {
            $mahasiswas = Mahasiswa::paginate(5);
        }
        $post = Mahasiswa::orderBy('Nim', 'desc')->paginate(6);
        return view('mahasiswas.index', compact('mahasiswas')); 
        with('i', (request()->input('page', 1) - 1) * 5); 
    }
}
