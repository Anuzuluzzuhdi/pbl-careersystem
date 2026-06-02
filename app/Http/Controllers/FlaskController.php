<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class FlaskController extends Controller
{
    protected $baseUrl;
    public function __construct()
    {
        $this->baseUrl = config('services.flask.url', 'http://localhost:5000');
    }
    public function getResult(array $payload)
    {
        return Http::post(
            "{$this->baseUrl}/cbf/careerRecommendation",
            $payload
        );
    }
}
