<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman form untuk edit profil.
     */
    public function edit(Request $request)
    {
        return view('student.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Memperbarui informasi profil pengguna.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        // Validasi input
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        // Update nama dan email
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        // Jika email diubah, reset status verifikasi
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Jika ada password baru, update password
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('siswa.profile.edit')->with('status', 'profil-updated');
    }
}
