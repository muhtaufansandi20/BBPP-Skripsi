<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        // Validasi data dasar
        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'e_mail' => 'sometimes|required|email|max:255|unique:users,e_mail,'.auth()->id(),
            'no_hp' => 'sometimes|nullable|string|max:20',
            
            // Tambahan validasi untuk password jika ada
            'current_password' => 'sometimes|required_with:new_password|current_password',
            'new_password' => 'sometimes|required_with:current_password|string|min:8|confirmed',
        ]);

        try {
            $user = auth()->user();
            
            // Update data dasar
            if ($request->has('name')) {
                $user->name = $validatedData['name'];
                $massage = "Nama berhasil diperbarui!";
            }
            if ($request->has('e_mail')) {
                $user->e_mail = $validatedData['e_mail'];
                $massage = "email berhasil diperbarui!";
            }
            if ($request->has('no_hp')) {
                $user->no_hp = $validatedData['no_hp'];
                $massage = "NO Hp berhasil diperbarui!";
            }

            if ($request->has('new_password')) {
                $user->password = Hash::make($validatedData['new_password']);
                $massage = "Password berhasil diperbarui!";
            }
            
            $user->save();

            return back()->with('success', $massage);
            
            
        } catch (\Exception $e) {
            Log::error('Update profile error: '.$e->getMessage());
            return back()->with('error', 'Gagal memperbarui profil: '.$e->getMessage());
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
