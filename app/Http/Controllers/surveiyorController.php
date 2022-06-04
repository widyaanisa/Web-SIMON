<?php

namespace App\Http\Controllers;

use App\Exports\PelaksanaanExport;
use App\Exports\RencanakegiatanExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\FileRencanaKegiatan;
use App\Models\Rencanakegiatan;
use App\Models\JenisKegiatan;
use App\Models\Pelaksanaan;
use App\Rules\MatchCurrentPassword;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class surveiyorController extends Controller
{
	public function homefrontend()
	{
		$bulanIni = Carbon::now()->format('m-Y');
		$pelaksanaanBulanIni = Pelaksanaan::where('bulan_tahun', $bulanIni)->count();

		$pelaksanaanPerBulan = [];
		$tahunIni = Carbon::now()->format('Y');
		$bulanTahunIni = [
			"01-$tahunIni",
			"02-$tahunIni",
			"03-$tahunIni",
			"04-$tahunIni",
			"05-$tahunIni",
			"06-$tahunIni",
			"07-$tahunIni",
			"08-$tahunIni",
			"09-$tahunIni",
			"10-$tahunIni",
			"11-$tahunIni",
			"12-$tahunIni",
		];

		foreach ($bulanTahunIni as $bulan) {
			\array_push($pelaksanaanPerBulan, Pelaksanaan::where('bulan_tahun', $bulan)->count());
		}

		$tahunArray = [];

		for ($i = -4; $i <= 0; $i++) {
			\array_push($tahunArray, Carbon::now()->addYear($i)->format('Y'));
		}

		$pelaksanaanPerTahun = [];
		$rencanaPerTahun = [];
		$masterPerTahun = [];

		foreach ($tahunArray as $tahun) {
			$bulanTahun = [
				"01-$tahun",
				"02-$tahun",
				"03-$tahun",
				"04-$tahun",
				"05-$tahun",
				"06-$tahun",
				"07-$tahun",
				"08-$tahun",
				"09-$tahun",
				"10-$tahun",
				"11-$tahun",
				"12-$tahun",
			];

			$rencanaTahun = 0;
			$pelaksanaanTahun = 0;
			$masterTahun = 0;

			foreach ($bulanTahun as $bulan) {
				$rencanaTahun += Rencanakegiatan::where('bulan_tahun', $bulan)->count();
				$pelaksanaanTahun += Pelaksanaan::where('bulan_tahun', $bulan)->count();
				$masterTahun = $rencanaTahun - $pelaksanaanTahun;
			}

			array_push($rencanaPerTahun, $rencanaTahun);
			array_push($pelaksanaanPerTahun, $pelaksanaanTahun);
			array_push($masterPerTahun, $masterTahun);
		}

		$terlaksana = Pelaksanaan::get(['bulan_tahun', 'jenis_kegiatan', 'status_id']);

		return view('dashboard.surveiyor.home', [
			"title" => "Home",
			'bulanTahunIni' => $bulanTahunIni,
			'daftarTahun' => $tahunArray,
			'pelaksanaanPerBulan' => $pelaksanaanPerBulan,
			'pelaksanaanBulanIni' => $pelaksanaanBulanIni,
			'rencanaPerTahun' => $rencanaPerTahun,
			'pelaksanaanPerTahun' => $pelaksanaanPerTahun,
			'masterPerTahun' => $masterPerTahun,
			'terlaksana' => $terlaksana
		]);
	}

	public function datamasterfrontend(Request $request)
	{
		$data = $request->get('data', 'rencana');
		$search = $request->get('search', "");
		if ($data == 'rencana') {
			$rencanakegiatan = Rencanakegiatan::where('jeniskegiatan', 'LIKE', '%' . $search . '%')
				->orWhere('bulan_tahun', 'LIKE', '%' . $search . '%')
				->orWhere('personal', 'LIKE', '%' . $search . '%')
				->with('fileRencanaKegiatan')
				->paginate(5);

			return view('dashboard.surveiyor.datamaster', ["title" => "Data Master", "data" => $data, 'rencanakegiatan' => $rencanakegiatan]);
		} else if ($data == 'pelaksanaan') {
			$daftarPelaksanaan = Pelaksanaan::where('jenis_kegiatan', 'LIKE', '%' . $search . '%')
				->orWhere('bulan_tahun', 'LIKE', '%' . $search . '%')
				->orWhere('personal', 'LIKE', '%' . $search . '%')
				->orWhere('outcome', 'LIKE', '%' . $search . '%')
				->paginate(5);

			return view('dashboard.surveiyor.datamaster', ["title" => "Data Master", "data" => $data, 'daftarPelaksanaan' => $daftarPelaksanaan]);
		}
	}

	public function datamasterexport(Request $request)
	{
		$data = $request->get('data', 'rencana');
		$search = $request->get('search', "");
		if ($data == 'rencana') {
			$rencanakegiatan = Rencanakegiatan::where('jeniskegiatan', 'LIKE', '%' . $search . '%')
				->orWhere('bulan_tahun', 'LIKE', '%' . $search . '%')
				->orWhere('personal', 'LIKE', '%' . $search . '%')
				->with('fileRencanaKegiatan')
				->get();

			return Excel::download(new RencanakegiatanExport($rencanakegiatan), 'rencanakegiatan.xlsx');
		} else if ($data == 'pelaksanaan') {
			$daftarPelaksanaan = Pelaksanaan::where('jenis_kegiatan', 'LIKE', '%' . $search . '%')
				->orWhere('bulan_tahun', 'LIKE', '%' . $search . '%')
				->orWhere('personal', 'LIKE', '%' . $search . '%')
				->orWhere('outcome', 'LIKE', '%' . $search . '%')
				->get();

			return Excel::download(new PelaksanaanExport($daftarPelaksanaan), 'pelaksanaan.xlsx');
		}
	}

	public function pelaksanaanfrontend()
	{
		return view('dashboard.surveiyor.pelaksanaan', ["title" => "Data Pelaksanaan"]);
	}

	public function rencanakegiatanfrontend()
	{
		$rencanakegiatan = Rencanakegiatan::paginate(5);
		$jeniskegiatan = JenisKegiatan::all();
		$users = User::all();
		return view('dashboard.surveiyor.rencanakegiatan', ["title" => "Data Rencana Kegiatan"], compact('rencanakegiatan', 'jeniskegiatan', 'users'));
	}

	public function rencanakegiatancreate(Request $request)
	{
		$this->validate($request, [
			'bulan_tahun' => 'required',
			'jeniskegiatan' => 'required',
			'personal' => 'required',
			'tentang.*' => 'mimes:pdf,jpeg,png,jpg',
		]);

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

		return redirect()->route('surveiyor.rencanakegiatan')->with('success', ' Rencana Kegiatan baru berhasil dibuat.');
	}

	public function rencanakegiatandetail($id)
	{
		$jeniskegiatan = JenisKegiatan::all();
		$users = User::all();
		$rencana = Rencanakegiatan::find($id);
		return \view('dashboard.surveiyor.detailrencanakegiatan', ['title' => 'Detail', 'rencana' => $rencana, 'jeniskegiatan' => $jeniskegiatan, 'users' => $users]);
	}

	public function rencanakegiatandelete(Request $request)
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

		return redirect()->route('surveiyor.rencanakegiatan')->with('success', ' Rencana Kegiatan berhasil dihapus.');
	}

	public function rencanakegiatanupdate(Request $request)
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

		return redirect()->route('surveiyor.rencanakegiatan')->with('success', ' Rencana Kegiatan berhasil diubah.');
	}

	public function rencanakegiatanaddFile(Request $request, $id)
	{
		$this->validate($request, [
			'file' => 'required|mimes:pdf,jpeg,jpg,png'
		]);

		$file = $request->file('file');
		$fileName = Str::random(8) . "_" . $file->getClientOriginalName();

		$fileRencanaKegiatan = new FileRencanaKegiatan();
		$fileRencanaKegiatan->id_rencana_kegiatan = $id;
		$fileRencanaKegiatan->nama_file = $fileName;
		$file->move(public_path('file/'), $fileName);

		$fileRencanaKegiatan->save();

		return \redirect()->route('surveiyor.rencanakegiatan.detail', $id)->with('success', 'Successfully added new file');
	}

	public function rencanakegiatanremoveFile(Request $request, $id)
	{
		$this->validate($request, [
			'id_file' => 'required'
		]);

		$file = FileRencanaKegiatan::find($request->id_file);
		File::delete(\public_path('file/' . $file->nama_file));

		$file->delete();

		return \redirect()->route('surveiyor.rencanakegiatan.detail', $id)->with('success', 'Successfully deleted file');
	}

	public function profilfrontend()
	{
		return view('dashboard.surveiyor.profil', ["title" => "Profil"]);
	}

	public function editprofilfrontend()
	{
		return view('dashboard.surveiyor.editprofil', ["title" => "Edit Profil"]);
	}

	public function ubahpasswordfrontend()
	{
		return view('dashboard.surveiyor.ubahpassword', ["title" => "Change Password"]);
	}

	public function changePassword(Request $request)
	{
		$request->validate([
			'current_password' => ['required', new MatchCurrentPassword],
			'new_password' => ['required'],
			'new_confirm_password' => ['same:new_password'],
		]);
		User::find(auth()->user()->id_user)->update(['password' => Hash::make($request->new_password)]);

		return \redirect()->route('surveiyor.changepassword')->with('success', 'Successfully changed password');
	}
}
