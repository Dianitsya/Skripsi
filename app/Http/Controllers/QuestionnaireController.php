<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuestionnaireResult;
use App\Models\LearningStyleResult;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class QuestionnaireController extends Controller {

    public function store(Request $request) {
        $request->validate([
            'answers' => 'required|array',
        ]);

        // 🔹 Menghitung total skor minat
        $totalScore = array_sum($request->answers);

        // 🔹 Menentukan kategori minat berdasarkan skor total
        if ($totalScore >= 56) {
            $category = "Minat Tinggi 🟩";
        } elseif ($totalScore >= 36) {
            $category = "Minat Sedang 🟨";
        } else {
            $category = "Minat Rendah 🟥";
        }

        // 🔹 Simpan hasil minat ke database (table: questionnaire_results)
        QuestionnaireResult::updateOrCreate(
            ['user_id' => Auth::id()], // Jika sudah ada, update; jika belum, buat baru
            ['skor' => $totalScore, 'minat' => $category]
        );

        return redirect()->route('questionnaire2.show')->with('success', 'Lanjutkan ke kuisioner gaya belajar.');
    }

    public function showLearningStyle() {
        // 🔹 Cek apakah user sudah mengisi kuisioner minat
        $minatResult = QuestionnaireResult::where('user_id', Auth::id())->first();
        if (!$minatResult) {
            return redirect()->route('questionnaire.show')->with('error', 'Harap isi kuisioner minat terlebih dahulu.');
        }

        $questionsLearningStyle = [
            "Saya lebih mudah memahami konsep pemrograman jika ada diagram, flowchart, atau ilustrasi.",
            "Saya lebih suka membaca buku atau artikel pemrograman yang disertai banyak gambar dan contoh kode berwarna.",
            "Saat belajar pemrograman, saya sering membuat mind map atau catatan berisi sketsa dan diagram.",
            "Saya lebih suka menonton video tutorial dengan tampilan yang jelas dibanding hanya membaca teks.",
            "Saya merasa lebih nyaman saat belajar menggunakan slide presentasi dibanding mendengar penjelasan lisan.",
            "Saya lebih mudah memahami konsep jika ada seseorang yang menjelaskan langsung kepada saya.",
            "Saya suka mendengarkan podcast atau rekaman suara untuk memahami suatu konsep.",
            "Saya lebih suka belajar pemrograman dengan berdiskusi bersama teman atau mengikuti sesi tanya-jawab.",
            "Saya sering mengulang informasi dengan cara mengucapkannya kembali atau menjelaskan kepada orang lain.",
            "Saya lebih suka mendengarkan instruksi dibanding membaca panduan sendiri.",
            "Saya lebih mudah memahami konsep pemrograman ketika langsung mencoba mengetik kode sendiri daripada membaca teori.",
            "Saya lebih suka mengikuti kursus yang menyediakan latihan praktik daripada hanya menonton atau membaca.",
            "Saya lebih nyaman belajar pemrograman dengan cara bereksperimen dan mencoba hal-hal baru secara langsung.",
            "Saya suka belajar dengan cara melakukan simulasi atau mempraktikkan langsung daripada hanya menghafal teori.",
            "Saya lebih cepat memahami konsep saat mengerjakan proyek atau tugas praktik dibanding hanya mendengarkan atau membaca."
        ];

        $options = [
            5 => "Sangat Setuju",
            4 => "Setuju",
            2 => "Tidak Setuju",
            1 => "Sangat Tidak Setuju"
        ];

        return view('questionnaire2', compact('questionsLearningStyle', 'options'));
    }

    public function storeLearningStyle(Request $request) {
        $request->validate([
            'answers' => 'required|array',
        ]);

        $visualScore = array_sum(array_slice($request->answers, 0, 5));
        $auditoryScore = array_sum(array_slice($request->answers, 5, 5));
        $kinestheticScore = array_sum(array_slice($request->answers, 10, 5));

        $learningStyles = [
            'Visual' => $visualScore,
            'Auditori' => $auditoryScore,
            'Kinestetik' => $kinestheticScore,
        ];

        $maxScore = max($learningStyles);
        $dominantStyles = array_keys($learningStyles, $maxScore);


// Cek apakah lebih dari satu gaya belajar yang dominan
if (count($dominantStyles) > 1) {
    $dominantStyle = implode(' & ', $dominantStyles); // Misal: "Visual & Auditori"
} else {
    $dominantStyle = $dominantStyles[0]; // Misal: "Visual"
}
        LearningStyleResult::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'visual_score' => $visualScore,
                'auditory_score' => $auditoryScore,
                'kinesthetic_score' => $kinestheticScore,
                'dominant_style' => $dominantStyle
            ]
        );

        // 🔹 Ambil hasil kuisioner minat
        $questionnaire = QuestionnaireResult::where('user_id', Auth::id())->first();

        if ($questionnaire) {
            // 🔹 Tentukan kategori berdasarkan minat
            $categoryMap = [
                'Minat Tinggi 🟩' => 'Lanjutan',
                'Minat Sedang 🟨' => 'Menengah',
                'Minat Rendah 🟥' => 'Pemula',
            ];

            $categoryName = $categoryMap[$questionnaire->minat] ?? 'Pemula';

            // 🔹 Ambil ID kategori dari tabel categories
            $category = \App\Models\Category::where('name', $categoryName)->first();

            // 🔹 Update category_id user
            $user = Auth::user();
            if ($category && $user->category_id !== $category->id) {
                $user->category_id = $category->id;
                $user->save();
            }
        }

        return redirect()->route('questionnaire.result')->with('success', 'Kuisioner berhasil dikirim!');
    }

    public function result() {
        $user = Auth::user();

        $minatResult = QuestionnaireResult::where('user_id', $user->id)->first();
        $learningResult = LearningStyleResult::where('user_id', $user->id)->first();

        if (!$minatResult) {
            return redirect()->route('questionnaire.show')->with('error', 'Anda belum mengisi kuisioner minat.');
        }

        if (!$learningResult) {
            return redirect()->route('questionnaire2.show')->with('error', 'Anda belum mengisi kuisioner gaya belajar.');
        }

        return view('questionnaire_result', compact('minatResult', 'learningResult'));
    }

    public function show() {
        $questionsMinat = [
            "Saya merasa senang ketika belajar atau mencoba memahami konsep pemrograman.",
            "Saya penasaran dengan bagaimana sebuah aplikasi atau website dibuat.",
            "Saya merasa bersemangat saat berhasil menyelesaikan masalah pemrograman.",
            "Saya ingin mendalami pemrograman lebih jauh di luar kelas.",
            "Saya lebih suka belajar pemrograman dibanding mata kuliah lain.",
            "Saya sering mencoba menulis kode atau membuat program sendiri.",
            "Saya pernah mengerjakan proyek pemrograman di luar tugas kuliah.",
            "Saya mengikuti kursus online, membaca artikel, atau menonton video tentang pemrograman.",
            "Saya pernah mengikuti kompetisi atau lomba terkait pemrograman.",
            "Saya sering memperbaiki atau mengembangkan kode yang saya buat sendiri.",
            "Saya belajar pemrograman karena saya merasa itu penting untuk karier saya.",
            "Saya ingin menjadi seorang programmer atau bekerja di bidang teknologi.",
            "Saya belajar pemrograman karena ingin membuat aplikasi atau proyek sendiri.",
            "Saya belajar pemrograman karena minat sendiri.",
            "Saya percaya bahwa menguasai pemrograman akan memberi saya keuntungan di masa depan."
        ];

        $options = [
            5 => "Sangat Setuju",
            4 => "Setuju",
            2 => "Tidak Setuju",
            1 => "Sangat Tidak Setuju"
        ];

        return view('questionnaire', compact('questionsMinat', 'options'));
    }
}
