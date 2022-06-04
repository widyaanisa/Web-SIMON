<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FileRencanaKegiatan;
use App\Models\User;
use App\Models\Rencanakegiatan;
use App\Models\JenisKegiatan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class rencanakegiatanController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$rencanakegiatan = Rencanakegiatan::latest()->paginate(5);
		$jeniskegiatan = JenisKegiatan::all();
		return view('dashboard.mainadmin.manageuser', ["title" => "Rencana Kegiatan"], compact('rencanakegiatan', 'jeniskegiatan'))
			->with('i', (request()->input('page', 1) - 1) * 5);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Request $request)
	{
		$rencanaKegiatan = new Rencanakegiatan();
		$rencanaKegiatan->bulan_tahun = $request->bulan_tahun;
		$rencanaKegiatan->jeniskegiatan = $request->jeniskegiatan;
		$rencanaKegiatan->personal = $request->personal;
		$rencanaKegiatan->save();

		if ($request->hasFile('tentang')) {
			foreach ($request->file('tentang') as $file) {
				$fileName = Str::random(8) . "_" . $file->getClientOriginalName();

				$fileRencanaKegiatan = new FileRencanaKegiatan();
				$fileRencanaKegiatan->id_rencana_kegiatan = $rencanaKegiatan->id_rencana;
				$fileRencanaKegiatan->nama_file = $fileName;
				$file->move(public_path('file/'), $fileName);

				$fileRencanaKegiatan->save();
			}
		}

		return \back()->with('success', ' Rencana Kegiatan baru berhasil dibuat.');
	}

	public function detail($id)
	{
		$jeniskegiatan = JenisKegiatan::all();
		$users = User::where('id_user', $id)->get();
		$rencana = Rencanakegiatan::find($id);
		return \view('dashboard.detailrencanakegiatan', ['title' => 'Detail', 'rencana' => $rencana, 'jeniskegiatan' => $jeniskegiatan, 'users' => $users]);
	}

	public function delete(Request $request)
	{
		$this->validate($request, [
			'id' => 'required'
		]);

		$rencana = Rencanakegiatan::find($request->id);

		foreach ($rencana->fileRencanaKegiatan as $file) {
			File::delete(\public_path('file/' . $file->nama_file));
			$file->delete();
		}

		$rencana->delete();

		return \back()->with('success', ' Rencana Kegiatan berhasil dihapus.');
	}

	public function update(Request $request)
	{
		$this->validate($request, [
			'id' => 'required',
			'bulan_tahun' => 'required',
			'jeniskegiatan' => 'required',
			'personal' => 'required',
		]);

		$rencana = Rencanakegiatan::find($request->id);
		$rencana->update([
			'bulan_tahun' => $request->bulan_tahun,
			'jeniskegiatan' => $request->jeniskegiatan,
			'personal' => $request->personal
		]);

		return redirect()->route('mainadmin.rencanakegiatan')->with('success', ' Rencana Kegiatan berhasil diubah.');
	}

	public function addFile(Request $request, $id)
	{
		$this->validate($request, [
			'file' => 'required|mimes:pdf'
		]);

		$file = $request->file('file');
		$fileName = Str::random(8) . "_" . $file->getClientOriginalName();

		$fileRencanaKegiatan = new FileRencanaKegiatan();
		$fileRencanaKegiatan->id_rencana_kegiatan = $id;
		$fileRencanaKegiatan->nama_file = $fileName;
		$file->move(public_path('file/'), $fileName);

		$fileRencanaKegiatan->save();

		return \redirect()->route('mainadmin.rencanakegiatan.detail', $id)->with('success', 'Successfully added new file');
	}

	public function removeFile(Request $request, $id)
	{
		$this->validate($request, [
			'id_file' => 'required'
		]);

		$file = FileRencanaKegiatan::find($request->id_file);
		File::delete(\public_path('file/' . $file->nama_file));

		$file->delete();

		return \redirect()->route('mainadmin.rencanakegiatan.detail', $id)->with('success', 'Successfully deleted file');
	}
}
