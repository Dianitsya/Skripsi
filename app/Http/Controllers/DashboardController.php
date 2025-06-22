<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\User;
use App\Models\QuestionnaireResult;
use App\Models\LearningStyleResult;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller {
    public function index()
    {
        $user = Auth::user();

        if ($user->id == 1) {
            // Statistik pengguna
            $totalUsers = User::count();
            $totalAdmins = User::where('is_admin', true)->count();
            $totalReguler = max(0, $totalUsers - $totalAdmins);

            // Data distribusi gaya belajar berdasarkan minat
            $learningStyleDistribution = DB::table('questionnaire_results')
                ->join('learning_style_results', 'questionnaire_results.user_id', '=', 'learning_style_results.user_id')
                ->select(
                    'questionnaire_results.minat',
                    'learning_style_results.dominant_style',
                    DB::raw('count(*) as count')
                )
                ->groupBy('questionnaire_results.minat', 'learning_style_results.dominant_style')
                ->get()
                ->groupBy('minat')
                ->map(function ($group) {
                    return $group->pluck('count', 'dominant_style');
                });

            return view('dashboard.admin', compact(
                'totalUsers', 'totalAdmins', 'totalReguler', 'learningStyleDistribution'
            ));
        }

        // Cek apakah user sudah mengisi kuisioner
        $questionnaire = QuestionnaireResult::where('user_id', $user->id)->first();
        if (!$questionnaire) {
            return redirect()->route('questionnaire.show');
        }

        // Tentukan kategori berdasarkan hasil kuisioner
        $categoryMap = [
            'Minat Tinggi 🟩'  => 'Lanjutan',
            'Minat Sedang 🟨'  => 'Menengah',
            'Minat Rendah 🟥'  => 'Pemula',
        ];

        $categoryName = $categoryMap[$questionnaire->minat] ?? 'Pemula'; // Default ke Pemula jika tidak ada kecocokan

        // Update category_id jika berbeda dengan hasil kuisioner
        $category = Category::where('name', $categoryName)->first();
        if ($category && $user->category_id !== $category->id) {
            $user->category_id = $category->id;
            $user->save();
            Auth::setUser($user);
        }

        return match ($categoryName) {
            'Lanjutan'  => redirect()->route('dashboard.advanced'),
            'Menengah'  => redirect()->route('dashboard.intermediate'),
            'Pemula'    => redirect()->route('dashboard.beginner'),
        };
    }

    public function admin()
    {
        $modules = Module::all(); // Ambil semua modul

        // Hitung data Interest
        $questionnaireResult = QuestionnaireResult::select('minat', \DB::raw('count(*) as count'))
        ->whereNotNull('minat')
        ->groupBy('minat')
        ->pluck('count', 'minat')
        ->toArray();

        // Hitung data Learning Style
        $learningStyleData = LearningStyleResult::select('dominant_style', \DB::raw('count(*) as count'))
            ->whereNotNull('dominant_style')
            ->groupBy('dominant_style')
            ->pluck('count', 'dominant_style')
            ->toArray() ?? [];


        return view('dashboard.admin', compact('modules', 'questionnaireResult', 'learningStyleData'));
    }

    public function beginner()
    {
        $user = Auth::user();
        $modules = Module::where('category_id', $user->category_id)->get();

        return view('dashboard.beginner', compact('modules', 'user'));
    }

    public function intermediate()
    {
        $user = Auth::user();
        $modules = Module::where('category_id', $user->category_id)->get();

        return view('dashboard.intermediate', compact('modules', 'user'));
    }

    public function advanced()
    {
        $user = Auth::user();
        $modules = Module::where('category_id', $user->category_id)->get();

        if ($modules->isEmpty()) {
            return view('dashboard.advanced', [
                'modules' => $modules,
                'user' => $user,
                'message' => 'Belum ada modul tersedia untuk kategori Lanjut.'
            ]);
        }

        return view('dashboard.advanced', compact('modules', 'user'));
    }
}
