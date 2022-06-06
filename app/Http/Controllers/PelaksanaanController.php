<?php

namespace App\Http\Controllers;

use App\Exports\PelaksanaanExport;
use App\Models\FileLaporan;
use App\Models\FilePelaksanaan;
use App\Models\FilePerwaktu;
use App\Models\JenisKegiatan;
use App\Models\Pelaksanaan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class PelaksanaanController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$users = User::where('nama_pengguna', \auth()->user()->nama_pengguna)->get();
		$jenisKegiatan = JenisKegiatan::all();
		$daftarPelaksanaan = Pelaksanaan::paginate(5);

		return \view('dashboard.pelaksanaan.index', [
			'daftarPelaksanaan' => $daftarPelaksanaan,
			'title' => 'Daftar Pelaksanaan',
			'jeniskegiatan' => $jenisKegiatan,
			'users' => $users
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

	public function export(Request $request)
	{
		return Excel::download(new PelaksanaanExport(Pelaksanaan::all()), 'pelaksanaan.xlsx');
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
			'bulan_tahun' => 'required',
			'jenis_kegiatan' => 'required',
			'no_sprint' => 'required',
			'waktu' => 'required',
			'personal' => 'required',
			'outcome' => 'required',
			'file_pelaksanaan.*' => 'mimes:pdf,jpeg,png,jpg',
			'file_laporan.*' => 'mimes:pdf,jpeg,png,jpg',
			'file_perwaktu.*' => 'mimes:pdf,jpeg,png,jpg',
		]);

		$pelaksanaan = Pelaksanaan::create($request->all());
		$id_pelaksanaan = $pelaksanaan->id;

		if ($request->file('file_pelaksanaan')) {
			foreach ($request->file('file_pelaksanaan') as $file) {
				$fileName = Str::random(8) . "_" . $file->getClientOriginalName();

				$filePelaksanaan = new FilePelaksanaan();
				$filePelaksanaan->id_pelaksanaan = $id_pelaksanaan;
				$filePelaksanaan->nama_file = $fileName;
				$file->move(public_path("file/pelaksanaan/$id_pelaksanaan/file_pelaksanaan/"), $fileName);

				$filePelaksanaan->save();
			}
		}

		if ($request->file('file_laporan')) {
			foreach ($request->file('file_laporan') as $file) {
				$fileName = Str::random(8) . "_" . $file->getClientOriginalName();

				$fileLaporan = new FileLaporan();
				$fileLaporan->id_pelaksanaan = $id_pelaksanaan;
				$fileLaporan->nama_file = $fileName;
				$file->move(public_path("file/pelaksanaan/$id_pelaksanaan/file_laporan/"), $fileName);

				$fileLaporan->save();
			}
		}

		if ($request->file('file_perwaktu')) {
			foreach ($request->file('file_perwaktu') as $file) {
				$fileName = Str::random(8) . "_" . $file->getClientOriginalName();

				$filePerwaktu = new FilePerwaktu();
				$filePerwaktu->id_pelaksanaan = $id_pelaksanaan;
				$filePerwaktu->nama_file = $fileName;
				$file->move(public_path("file/pelaksanaan/$id_pelaksanaan/file_perwaktu/"), $fileName);

				$filePerwaktu->save();
			}
		}

		return \redirect()->route('pelaksanaan.index')->with('success', 'Berhasil menambah pelaksanaan!');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$users = User::where('nama_pengguna', \auth()->user()->nama_pengguna)->get();
		$jenisKegiatan = JenisKegiatan::all();
		$pelaksanaan = Pelaksanaan::find($id);

		return \view('dashboard.pelaksanaan.detail', [
			'pelaksanaan' => $pelaksanaan,
			'title' => 'Daftar Pelaksanaan',
			'jeniskegiatan' => $jenisKegiatan,
			'users' => $users
		]);
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
		$this->validate($request, [
			'bulan_tahun' => 'required',
			'jenis_kegiatan' => 'required',
			'no_sprint' => 'required',
			'waktu' => 'required',
			'personal' => 'required',
			'outcome' => 'required'
		]);

		$pelaksanaan = Pelaksanaan::find($id);
		$pelaksanaan->update($request->all());

		return \redirect()->route('pelaksanaan.show', $id)->with('success', 'Successfully added new file');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$pelaksanaan = Pelaksanaan::find($id);

		foreach ($pelaksanaan->filePelaksanaan as $file) {
			File::delete(\public_path('file/pelaksanaan/' . $id . '/file_pelaksanaan/' . $file->nama_file));
			$file->delete();
		}

		foreach ($pelaksanaan->fileLaporan as $file) {
			File::delete(\public_path('file/pelaksanaan/' . $id . '/file_laporan/' . $file->nama_file));
			$file->delete();
		}

		foreach ($pelaksanaan->filePerwaktu as $file) {
			File::delete(\public_path('file/pelaksanaan/' . $id . '/file_perwaktu/' . $file->nama_file));
			$file->delete();
		}

		$pelaksanaan->delete();

		return \redirect()->route('pelaksanaan.index')->with('success', 'Berhasil menghapus pelaksanaan');
	}

	public function addFile(Request $request, $id)
	{
		$this->validate($request, [
			'type' => 'required',
			'file' => 'required|mimes:pdf,jpeg,jpg,png'
		]);

		$file = $request->file('file');
		$fileName = Str::random(8) . "_" . $file->getClientOriginalName();

		if ($request->type == 'file_pelaksanaan') {
			$fileModel = new FilePelaksanaan();
			$fileModel->id_pelaksanaan = $id;
			$fileModel->nama_file = $fileName;
			$file->move(public_path('file/pelaksanaan/' . $id . '/file_pelaksanaan/'), $fileName);

			$fileModel->save();
		} else if ($request->type == 'file_laporan') {
			$fileModel = new FileLaporan();
			$fileModel->id_pelaksanaan = $id;
			$fileModel->nama_file = $fileName;
			$file->move(public_path('file/pelaksanaan/' . $id . '/file_laporan/'), $fileName);

			$fileModel->save();
		} else if ($request->type == 'file_perwaktu') {
			$fileModel = new FilePerwaktu();
			$fileModel->id_pelaksanaan = $id;
			$fileModel->nama_file = $fileName;
			$file->move(public_path('file/pelaksanaan/' . $id . '/file_perwaktu/'), $fileName);

			$fileModel->save();
		}

		return \redirect()->route('pelaksanaan.show', $id)->with('success', 'Successfully added new file');
	}

	public function removeFile(Request $request, $id)
	{
		$this->validate($request, [
			'type' => 'required',
			'id_file' => 'required'
		]);

		if ($request->type == 'file_pelaksanaan') {
			$file = FilePelaksanaan::find($request->id_file);
			File::delete(\public_path('file/pelaksanaan/' . $id . '/file_pelaksanaan/' . $file->nama_file));
		} else if ($request->type == 'file_laporan') {
			$file = FileLaporan::find($request->id_file);
			File::delete(\public_path('file/pelaksanaan/' . $id . '/file_laporan/' . $file->nama_file));
		} else if ($request->type == 'file_perwaktu') {
			$file = FilePerwaktu::find($request->id_file);
			File::delete(\public_path('file/pelaksanaan/' . $id . '/file_perwaktu/' . $file->nama_file));
		}

		$file->delete();

		return \redirect()->route('pelaksanaan.show', $id)->with('success', 'Successfully deleted file');
	}
}
