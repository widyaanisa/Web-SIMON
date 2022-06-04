<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;

class manageadminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

  
    public function index()
    {
        $dataadmin = Admin::latest()->paginate(5);
        return view('dashboard.mainadmin.manageadmin',["title" => "Data Admin"], compact('dataadmin'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
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
            'nama'     => 'required',
            'password' => 'required'
        ]);

        $data = $request->all();
      
        $dataadmin = Admin::create($data);
        return back()->with('success',' Data Admin baru berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dataadmin = Admin::find($id);
        return view('dashboard.mainadmin.manageadmin',["title" => "Data Admin"], compact('dataadmin'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dataadmin = Admin::find($id);
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
            'nama'     => 'required',
            'password' => 'required'
        ]);

        $dataadmin = Admin::find($id)->update($request->all());

        $dataadmin->username = $request->input('username');
        $dataadmin->username = $request->input('password');
        $dataadmin->username = $request->input('nama');

        $dataadmin->save();

        return redirect()->route('manageadminmainadmin.index')->with('success','Admin Berhasil di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Admin::find($id)->delete();
        return redirect()->route('dashboard.mainadmain.manageadmin')
            ->with('success', 'Admin Berhasil Dihapus');
    }
}
