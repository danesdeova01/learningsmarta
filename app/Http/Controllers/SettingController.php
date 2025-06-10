<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Hash;


class SettingController extends Controller
{
    public function index()
    {
        return view('admin.setting', [
            'menuActive' => false
        ]);
    }

public function update(Request $request)
{
    $user = User::find(Auth::id());

    if ($request->password != null) {
        // Hash password baru
        $password = Hash::make($request->password);
    } else {
        // Gunakan password lama jika tidak ada perubahan
        $password = $user->password;
    }

    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'password' => $password,
    ]);

    Alert::success('Berhasil', ucwords('Pengaturan profil telah diperbarui'));

    return redirect('admin/setting');
}
}