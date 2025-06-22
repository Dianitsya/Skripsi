<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureQuestionnaireFilled
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // 🔹 Pastikan user ada
        if (!$user) {
            return redirect()->route('login');
        }

        // 🔹 Jika user adalah admin (ID 1), lanjutkan tanpa perlu isi kuisioner
        if ($user->id == 1) {
            return $next($request);
        }

        // 🔹 Cek apakah user sudah mengisi kuisioner (memiliki category_id)
        if (!$user->category_id) {
            return redirect()->route('questionnaire.show')->with('error', 'Silakan isi kuisioner terlebih dahulu.');
        }


        return $next($request);
    }
}
