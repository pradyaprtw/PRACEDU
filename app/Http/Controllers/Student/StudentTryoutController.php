<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TryoutPackage;
use App\Models\Subtest;
use App\Models\TryoutQuestion;
use App\Models\TryoutAttempt;
use App\Models\TryoutPackageAttempt;
use Illuminate\Support\Facades\Auth;

class StudentTryoutController extends Controller
{
    public function packages()
    {
        $packages = TryoutPackage::all();
        return view('student.tryout.packages', compact('packages'));
    }

    public function subtests($packageId)
    {
        $package = TryoutPackage::findOrFail($packageId);
        $subtests = Subtest::where('package_id', $packageId)->get();

        $user = Auth::user();
        $attemptedSubtests = TryoutAttempt::where('user_id', $user->id)
            ->whereIn('subtest_id', $subtests->pluck('id'))
            ->pluck('subtest_id')
            ->toArray();

        return view('student.tryout.subtests', compact('package', 'subtests', 'attemptedSubtests'));
    }

    public function questions($subtestId)
    {
        $subtest = Subtest::with('tryoutQuestions.answers')->findOrFail($subtestId);
        $durationMinutes = $subtest->duration_minutes;  // ambil dari tabel
        return view('student.tryout.questions', compact('subtest', 'durationMinutes'));
    }


    public function submitSubtest(Request $request, $subtestId)
    {
        $user = Auth::user();
        $questions = TryoutQuestion::where('subtest_id', $subtestId)->get();
        $answers = $request->input('answers', []);

        $score = 0;
        $total = $questions->count();

        foreach ($questions as $question) {
            if (isset($answers[$question->id]) && $answers[$question->id] == $question->correct_answer) {
                $score++;
            }
        }

        TryoutAttempt::updateOrCreate(
            ['user_id' => $user->id, 'subtest_id' => $subtestId],
            [
                'total_questions' => $total,
                'correct_answers' => $score,
                'score_percentage' => $total ? round(($score / $total) * 100, 2) : 0
            ]
        );

        // Cari next subtest
        $subtest = Subtest::findOrFail($subtestId);
        $packageId = $subtest->package_id;

        $nextSubtest = Subtest::where('package_id', $packageId)
            ->where('id', '>', $subtestId)
            ->orderBy('id')
            ->first();

        if ($nextSubtest) {
            return redirect()->route('siswa.tryout.questions', $nextSubtest->id)->with('success', 'Jawaban subtest berhasil disimpan. Lanjut ke subtest berikutnya.');
        } else {
            return redirect()->route('siswa.tryout.subtests', $packageId)->with('success', 'Semua subtest selesai!');
        }
    }


    public function submitPackage(Request $request, $packageId)
    {
        $user = Auth::user();

        // Cek apakah sudah pernah submit paket
        if (TryoutPackageAttempt::where('user_id', $user->id)->where('package_id', $packageId)->exists()) {
            return redirect()->route('siswa.tryout.result', $packageId)->with('error', 'TryOut sudah pernah dikumpulkan.');
        }

        $subtests = Subtest::where('package_id', $packageId)->pluck('id');
        $attempts = TryoutAttempt::where('user_id', $user->id)->whereIn('subtest_id', $subtests)->get();

        $totalQuestions = $attempts->sum('total_questions');
        $correctAnswers = $attempts->sum('correct_answers');
        $percentage = $totalQuestions ? round(($correctAnswers / $totalQuestions) * 100, 2) : 0;

        TryoutPackageAttempt::create([
            'user_id' => $user->id,
            'package_id' => $packageId,
            'total_questions' => $totalQuestions,
            'correct_answers' => $correctAnswers,
            'score_percentage' => $percentage,
        ]);

        return redirect()->route('siswa.tryout.result', $packageId)->with('success', 'Paket tryout berhasil dikumpulkan.');
    }

    public function result($packageId)
    {
        $package = TryoutPackage::findOrFail($packageId);
        $user = Auth::user();

        $attempt = TryoutPackageAttempt::where('user_id', $user->id)
            ->where('package_id', $packageId)
            ->firstOrFail();

        return view('student.tryout.result', compact('package', 'attempt'));
    }
}