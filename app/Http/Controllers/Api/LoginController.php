<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $credentials = $request->only('email', 'password');

        // Try to authenticate with admin guard first
        if (Auth::guard('admin')->attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            $user = Auth::guard('admin')->user();
            $token = $user->createToken('admin_token')->plainTextToken;
            
            return response()->json([
                'success' => true,
                'message' => 'Login berhasil!',
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'role' => 'admin',
                        'sekolah' => $user->sekolah
                    ],
                    'token' => $token,
                    'token_type' => 'Bearer'
                ]
            ]);
        }
        
        // Try to authenticate with guru guard using email
        if (Auth::guard('guru')->attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            $user = Auth::guard('guru')->user();
            $token = $user->createToken('guru_token')->plainTextToken;
            
            return response()->json([
                'success' => true,
                'message' => 'Login berhasil!',
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'nip' => $user->nip,
                        'nama_guru' => $user->nama_guru,
                        'email' => $user->email,
                        'no_hp' => $user->no_hp,
                        'jk' => $user->jk,
                        'role' => 'guru',
                        'sekolah' => $user->sekolah
                    ],
                    'token' => $token,
                    'token_type' => 'Bearer'
                ]
            ]);
        }
        
        // Try to authenticate with siswa guard using username
        if (Auth::guard('siswa')->attempt(['username' => $credentials['email'], 'password' => $credentials['password']])) {
            $user = Auth::guard('siswa')->user();
            $token = $user->createToken('siswa_token')->plainTextToken;
            
            return response()->json([
                'success' => true,
                'message' => 'Login berhasil!',
                'data' => [
                    'user' => [
                        'id' => $user->kode_siswa,
                        'nisn' => $user->nisn,
                        'nis' => $user->nis,
                        'nama_siswa' => $user->nama_siswa,
                        'username' => $user->username,
                        'email' => $user->email,
                        'no_hp' => $user->no_hp,
                        'jk' => $user->jk,
                        'foto' => $user->foto,
                        'role' => 'siswa',
                        'kelas' => $user->kelas,
                        'sekolah' => $user->sekolah
                    ],
                    'token' => $token,
                    'token_type' => 'Bearer'
                ]
            ]);
        }
        
        // Try to authenticate with siswa guard using email
        if (Auth::guard('siswa')->attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            $user = Auth::guard('siswa')->user();
            $token = $user->createToken('siswa_token')->plainTextToken;
            
            return response()->json([
                'success' => true,
                'message' => 'Login berhasil!',
                'data' => [
                    'user' => [
                        'id' => $user->kode_siswa,
                        'nisn' => $user->nisn,
                        'nis' => $user->nis,
                        'nama_siswa' => $user->nama_siswa,
                        'username' => $user->username,
                        'email' => $user->email,
                        'no_hp' => $user->no_hp,
                        'jk' => $user->jk,
                        'foto' => $user->foto,
                        'role' => 'siswa',
                        'kelas' => $user->kelas,
                        'sekolah' => $user->sekolah
                    ],
                    'token' => $token,
                    'token_type' => 'Bearer'
                ]
            ]);
        }

        // If all attempts fail, return error
        return response()->json([
            'success' => false,
            'message' => 'Email/Username atau password salah.'
        ], 401);
    }

    public function logout(Request $request)
    {
        try {
            // Check if user is authenticated
            if (!$request->user()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada user yang terautentikasi'
                ], 401);
            }

            // Revoke the token that was used to authenticate the current request
            $user = $request->user();
            
            // Get current token and delete it
            $currentToken = $user->currentAccessToken();
            if ($currentToken) {
                $currentToken->delete();
            }

            return response()->json([
                'success' => true,
                'message' => 'Logout berhasil!'
            ]);

        } catch (\Exception $e) {
            Log::error('Logout error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat logout'
            ], 500);
        }
    }

    public function profile(Request $request)
    {
        $user = $request->user();
        
        // Get user role based on guard
        $role = 'user';
        if ($user instanceof \App\Models\Admin) {
            $role = 'admin';
        } elseif ($user instanceof \App\Models\Guru) {
            $role = 'guru';
        } elseif ($user instanceof \App\Models\Siswa) {
            $role = 'siswa';
        }

        return response()->json([
            'success' => true,
            'data' => [
                'user' => $user,
                'role' => $role
            ]
        ]);
    }

    public function refresh(Request $request)
    {
        $user = $request->user();
        
        // Revoke current token
        $request->user()->currentAccessToken()->delete();
        
        // Create new token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'data' => [
                'token' => $token,
                'token_type' => 'Bearer'
            ]
        ]);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'role' => 'required|in:admin,guru,siswa',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'errors' => $validator->errors()
            ], 422);
        }

        $email = $request->email;
        $role = $request->role;

        try {
            $user = null;
            $userModel = null;

            // Find user based on role
            switch ($role) {
                case 'admin':
                    $userModel = \App\Models\Admin::where('email', $email)->first();
                    break;
                case 'guru':
                    $userModel = \App\Models\Guru::where('email', $email)->first();
                    break;
                case 'siswa':
                    $userModel = \App\Models\Siswa::where('email', $email)->first();
                    break;
            }

            if (!$userModel) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email tidak ditemukan untuk role ' . $role
                ], 404);
            }

            // Generate reset token (simplified - in production, use proper token generation)
            $resetToken = strtoupper(substr(md5(uniqid()), 0, 8));
            $resetExpires = now()->addHours(1);

            // Store reset token (you might want to add a password_resets table)
            // For now, we'll just return the token (in production, send via email)
            
            return response()->json([
                'success' => true,
                'message' => 'Token reset password telah dibuat',
                'data' => [
                    'reset_token' => $resetToken, // In production, send via email
                    'expires_at' => $resetExpires,
                    'user_info' => [
                        'id' => $userModel->id ?? $userModel->kode_siswa,
                        'name' => $userModel->name ?? $userModel->nama_guru ?? $userModel->nama_siswa,
                        'email' => $userModel->email,
                        'role' => $role,
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat membuat token reset password'
            ], 500);
        }
    }

    public function confirmPasswordReset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reset_token' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,guru,siswa',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // In production, verify the reset token from database
            // For now, we'll just update the password directly
            $resetToken = $request->reset_token;
            $newPassword = $request->new_password;
            $role = $request->role;

            // Find user by reset token (simplified)
            // In production, you should have a password_resets table to track tokens
            
            // For demo purposes, we'll require user identification
            if (!$request->has('email')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email diperlukan untuk konfirmasi reset password'
                ], 422);
            }

            $email = $request->email;
            $userModel = null;

            // Find user based on role and email
            switch ($role) {
                case 'admin':
                    $userModel = \App\Models\Admin::where('email', $email)->first();
                    break;
                case 'guru':
                    $userModel = \App\Models\Guru::where('email', $email)->first();
                    break;
                case 'siswa':
                    $userModel = \App\Models\Siswa::where('email', $email)->first();
                    break;
            }

            if (!$userModel) {
                return response()->json([
                    'success' => false,
                    'message' => 'User tidak ditemukan'
                ], 404);
            }

            // Update password
            $userModel->password = Hash::make($newPassword);
            $userModel->save();

            return response()->json([
                'success' => true,
                'message' => 'Password berhasil diperbarui'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui password'
            ], 500);
        }
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();

        try {
            // Verify current password
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Password saat ini tidak sesuai'
                ], 400);
            }

            // Update password
            $user->password = Hash::make($request->new_password);
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Password berhasil diubah'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengubah password'
            ], 500);
        }
    }
}
