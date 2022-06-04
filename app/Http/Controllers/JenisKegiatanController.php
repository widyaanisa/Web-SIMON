<?php

namespace App\Http\Controllers;

use App\Models\JenisKegiatan;
use Illuminate\Http\Request;

class JenisKegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jeniskegiatan = JenisKegiatan::paginate(10);
        return view('dashboard.mainadmin.jeniskegiatan', [
            'title' => 'Jenis Kegiatan',
            'jeniskegiatan' => $jeniskegiatan
        ]);
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
        $request->validate([
            'namakegiatan'  => 'required'
        ]);

        JenisKegiatan::create($request->all());

        return \back()->with('success', 'Berhasil menambah jenis kegiatan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'namakegiatan'  => 'required'
        ]);

        $jeniskegiatan = JenisKegiatan::find($id);
        $jeniskegiatan->update($request->all());

        return \back()->with('success', 'Berhasil mengubah jenis kegiatan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jeniskegiatan = JenisKegiatan::find($id);
        $jeniskegiatan->delete();

        return \back()->with('success', 'Berhasil menghapus jenis kegiatan');
    }
}
