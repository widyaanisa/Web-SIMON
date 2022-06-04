<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $id = auth()->user()->id_user;
        $request->validate([
            'username' => [
                'required',
                Rule::unique('users')->ignore($id, 'id_user'),
            ],
            'nama_pengguna' => 'required',
            'pangkat' => 'required',
            'NRP' => 'required',
            'jabatan' => 'required',
            'tempatlahir' => 'required',
            'tanggallahir' => 'required',
            'jeniskelamin' => 'required',
            'agama' => 'required',
            'email' => [
                'required',
                Rule::unique('users')->ignore($id, 'id_user'),
            ],
            'image' => 'mimes:jpg,jpeg'
        ]);

        $user = User::find($id);

        if ($request->has('image')) {
            $file = $request->file('image');
            $file->move(public_path() . '/uploads/',  $user->username . '.' . $file->getClientOriginalExtension());
        }

        $user->update($request->all());

        return back()->with('success', 'Berhasil memperbarui profile');
    }
}
