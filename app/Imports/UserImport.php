<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new User([
            'role'          => $row['role'] == 'mainadmin' ? 'admin' : $row['role'],
            'username'      => $row['username'],
            'password'      => Hash::make($row['password']),
            'nama_pengguna' => $row['nama'],
            'email'         => $row['email'],
        ]);
    }

    public function headingRow(): int
    {
        return 1;
    }
}
