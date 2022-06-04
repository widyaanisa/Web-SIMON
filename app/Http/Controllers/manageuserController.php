<?php

namespace App\Http\Controllers;

use App\Exports\UserExport;
use App\Imports\UserImport;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class manageuserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index(Request $request)

    {
        $keyword = $request->keyword;
        $datauser = User::where('nama_pengguna', 'LIKE', '%' . $keyword . '%')->paginate(5);
        return view('dashboard.mainadmin.manageuser', ["title" => "Data User"], compact('datauser'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function index2(Request $request)

    {
        $keyword = $request->keyword;
        $datauser = User::where('nama_pengguna', 'LIKE', '%' . $keyword . '%')->paginate(5);
        return view('dashboard.admin.manageuser', ["title" => "Data User"], compact('datauser'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function import(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = $file->getClientOriginalName();
            $file->move('uploads/', $filename);

            Excel::import(new UserImport, public_path('uploads/' . $filename));

            return back()->with('success', 'Data berhasil di import');
        }

        // $request->validate([
        //     'file' => 'required|mimes:xlsx,xls'
        // ]);

        // Excel::import(new UserImport, $request->file('file')->store('temp'));

        // return back()->with('success', 'Berhasil mengimpor data user!');
    }

    public function export(Request $request)
    {
        return Excel::download(new UserExport(), 'users.xlsx');
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
            'username' => 'required|unique:users|max:150',
            'password' => 'required',
            'nama_pengguna' => 'required',
            'pangkat' => 'required',
            'NRP' => 'required',
            'jabatan' => 'required',
            'tempatlahir' => 'required',
            'tanggallahir' => 'required',
            'jeniskelamin' => 'required',
            'agama' => 'required',
            'role' => 'required',
            'email' => 'required|email'
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($data['password']);

        $datauser = User::create($data);
        return back()->with('success', ' Data User baru berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $datauser = User::find($id);
        return view('dashboard.mainadmin.manageuser', ["title" => "Data User"], compact('datauser'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $datauser = User::find($id);
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
            'username' => 'required|unique:users|max:150',
            'password' => 'required',
            /*'nama_pengguna' => 'required',
            'pangkat' => 'required',
            'NRP' => 'required',
            'jabatan' => 'required',
            'tempatlahir' => 'required',
            'tanggallahir' => 'required',
            'jeniskelamin' => 'required',
            'agama' => 'required',*/
            'email' => 'required'
        ]);
        $datauser = User::find($id)->update($request->all());

        $datauser->username = $request->input('username');
        $datauser->username = $request->input('password');
        /* $datauser->username = $request->input('nama_pengguna');
        $datauser->username = $request->input('pangkat');
        $datauser->username = $request->input('NRP');
        $datauser->username = $request->input('jabatan');
        $datauser->username = $request->input('tempatlahir');
        $datauser->username = $request->input('tanggallahir');
        $datauser->username = $request->input('jeniskelamin');
        $datauser->username = $request->input('agama');*/
        $datauser->username = $request->input('email');

        $datauser->save();

        return redirect()->route('manageusermainadmin.index')->with('succes', 'User Berhasil di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('dashboard.mainadmain.manageuser')
            ->with('success', 'User Berhasil Dihapus');
    }
}
