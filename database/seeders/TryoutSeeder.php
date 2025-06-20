<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TryoutPackage;
use App\Models\Subtest;
use App\Models\TryoutQuestion;
use App\Models\TryoutAnswer;

class TryoutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $package = TryoutPackage::create([
            'name' => 'Paket UTBK 1',
            'description' => 'Simulasi UTBK full TPS'
        ]);

        $subtest = Subtest::create([
            'package_id' => $package->id,
            'name' => 'Kemampuan Penalaran Umum',
            'total_questions' => 30,
            'duration_minutes' => 30
        ]);

        $question = TryoutQuestion::create([
            'subtest_id' => $subtest->id,
            'question_text' => 'Berapa hasil 2+2?',
            'correct_answer' => 'A',
            'explanation' => 'Karena 2+2 = 4'
        ]);

        TryoutAnswer::create([
            'tryout_question_id' => $question->id,
            'option_label' => 'A',
            'answer_text' => '4',
            'is_correct' => true
        ]);

        TryoutAnswer::create([
            'tryout_question_id' => $question->id,
            'option_label' => 'B',
            'answer_text' => '5',
            'is_correct' => false
        ]);
    }
}
