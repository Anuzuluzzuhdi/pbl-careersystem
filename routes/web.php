<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function (Request $request) {
    $careers = DB::table('careers')->orderBy('career_name')->get();
    $educations = DB::table('educations')->orderBy('education_level')->get();
    $skills = DB::table('skills')->orderBy('skill_name')->get();
    $specializations = DB::table('specializations')->orderBy('specialization_name')->get();
    $certifications = DB::table('certifications')->orderBy('certification_name')->get();

    $criteria = [
        'education_id' => $request->query('education_id'),
        'skill_ids' => collect($request->query('skill_ids', []))->filter()->values()->all(),
        'specialization_ids' => collect($request->query('specialization_ids', []))->filter()->values()->all(),
        'certification_id' => $request->query('certification_id'),
    ];

    $searchResults = collect();
    if ($criteria['education_id'] || !empty($criteria['skill_ids']) || !empty($criteria['specialization_ids']) || $criteria['certification_id']) {
        $scores = [];

        if ($criteria['education_id']) {
            foreach (DB::table('career_education_weights')->where('education_id', $criteria['education_id'])->get() as $row) {
                $scores[$row->career_id] = ($scores[$row->career_id] ?? 0) + floatval($row->weight);
            }
        }

        if (!empty($criteria['skill_ids'])) {
            foreach (DB::table('career_skill_weights')->whereIn('skill_id', $criteria['skill_ids'])->get() as $row) {
                $scores[$row->career_id] = ($scores[$row->career_id] ?? 0) + floatval($row->weight);
            }
        }

        if (!empty($criteria['specialization_ids'])) {
            foreach (DB::table('career_specialization_weights')->whereIn('specialization_id', $criteria['specialization_ids'])->get() as $row) {
                $scores[$row->career_id] = ($scores[$row->career_id] ?? 0) + floatval($row->weight);
            }
        }

        if ($criteria['certification_id']) {
            foreach (DB::table('career_certification_weights')->where('certification_id', $criteria['certification_id'])->get() as $row) {
                $scores[$row->career_id] = ($scores[$row->career_id] ?? 0) + floatval($row->weight);
            }
        }

        if (!empty($scores)) {
            $careerIds = array_keys($scores);
            $searchResults = DB::table('careers')
                ->whereIn('career_id', $careerIds)
                ->get()
                ->map(function ($career) use ($scores) {
                    $career->score = $scores[$career->career_id] ?? 0;
                    return $career;
                })
                ->sortByDesc('score')
                ->values();
        }
    }

    return view('dashboard', compact(
        'careers',
        'educations',
        'skills',
        'specializations',
        'certifications',
        'searchResults',
        'criteria'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
