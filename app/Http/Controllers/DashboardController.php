<?php

namespace App\Http\Controllers;

use App\Models\Career;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $careers = DB::table('careers')->orderBy('career_name')->get();
        $educations = DB::table('educations')->orderBy('education_level')->get();
        $skills = DB::table('skills')->orderBy('skill_name')->get();
        $specializations = DB::table('specializations')->orderBy('specialization_name')->get();
        $certifications = DB::table('certifications')->orderBy('certification_name')->get();

        $educationId = $request->query('education_id');
        $skillIds = collect($request->query('skill_ids', []))->filter()->values()->all();
        $specializationIds = collect($request->query('specialization_ids', []))->filter()->values()->all();
        $certificationId = $request->query('certification_id');

        $criteria = [
            'education_id' => $educationId,
            'skill_ids' => $skillIds,
            'specialization_ids' => $specializationIds,
            'certification_id' => $certificationId,
        ];

        $careerPayloads = Career::with([
                'educationWeights',
                'skillWeights',
                'specializationWeights',
                'certificationWeights',
            ])
            ->orderBy('career_name')
            ->get()
            ->map(function ($career) {
                return [
                    'career_id' => $career->career_id,
                    'educationWeights' => $career->educationWeights->map(function ($weight) {
                        return [
                            'education_id' => $weight->education_id,
                            'weight' => floatval($weight->weight),
                            'frequency' => intval($weight->frequency),
                        ];
                    })->toArray(),
                    'skillWeights' => $career->skillWeights->map(function ($weight) {
                        return [
                            'skill_id' => $weight->skill_id,
                            'weight' => floatval($weight->weight),
                            'frequency' => intval($weight->frequency),
                        ];
                    })->toArray(),
                    'specializationWeights' => $career->specializationWeights->map(function ($weight) {
                        return [
                            'specialization_id' => $weight->specialization_id,
                            'weight' => floatval($weight->weight),
                            'frequency' => intval($weight->frequency),
                        ];
                    })->toArray(),
                    'certificationWeights' => $career->certificationWeights->map(function ($weight) {
                        return [
                            'certification_id' => $weight->certification_id,
                            'weight' => floatval($weight->weight),
                            'frequency' => intval($weight->frequency),
                        ];
                    })->toArray(),
                ];
            })->toArray();

        $flaskApi = new FlaskController();
        $result = $flaskApi->getResult([
            'careers' => $careerPayloads,
            'criteria' => $criteria,
        ]);

        $ranked = $result->json('ranked', []);
        $ids = collect($ranked)->pluck('career_id')->all();
        $scoreMap = collect($ranked)->pluck('score', 'career_id')->all();

        if (empty($ids)) {
            $searchResults = Career::orderBy('career_name')->get();
        } else {
            $idList = implode(',', array_map('intval', $ids));
            $searchResults = Career::whereIn('career_id', $ids)
                ->orderByRaw("FIELD(career_id, $idList)")
                ->get()
                ->map(function ($career) use ($scoreMap) {
                    $career->score = round(($scoreMap[$career->career_id] ?? 0) * 100, 2);
                    return $career;
                });
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
    }
}
// $searchResults = collect();
        // if ($educationId || !empty($skillIds) || !empty($specializationIds) || $certificationId) {
        //     $scores = [];

        //     if ($educationId) {
        //         foreach (DB::table('career_education_weights')->where('education_id', $educationId)->get() as $row) {
        //             $scores[$row->career_id] = ($scores[$row->career_id] ?? 0) + floatval($row->weight);
        //         }
        //     }

        //     if (!empty($skillIds)) {
        //         foreach (DB::table('career_skill_weights')->whereIn('skill_id', $skillIds)->get() as $row) {
        //             $scores[$row->career_id] = ($scores[$row->career_id] ?? 0) + floatval($row->weight);
        //         }
        //     }

        //     if (!empty($specializationIds)) {
        //         foreach (DB::table('career_specialization_weights')->whereIn('specialization_id', $specializationIds)->get() as $row) {
        //             $scores[$row->career_id] = ($scores[$row->career_id] ?? 0) + floatval($row->weight);
        //         }
        //     }

        //     if ($certificationId) {
        //         foreach (DB::table('career_certification_weights')->where('certification_id', $certificationId)->get() as $row) {
        //             $scores[$row->career_id] = ($scores[$row->career_id] ?? 0) + floatval($row->weight);
        //         }
        //     }

        //     if (!empty($scores)) {
        //         $careerIds = array_keys($scores);

        //         $searchResults = DB::table('careers')
        //             ->whereIn('career_id', $careerIds)
        //             ->get()
        //             ->map(function ($career) use ($scores) {
        //                 $career->score = $scores[$career->career_id] ?? 0;
        //                 return $career;
        //             })
        //             ->sortByDesc('score')
        //             ->values();
        //     }
        // }