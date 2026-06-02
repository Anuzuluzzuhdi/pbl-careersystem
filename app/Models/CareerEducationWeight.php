<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['career_id', 'education_id', 'frequency', 'weight'])]
class CareerEducationWeight extends Model
{
    use HasFactory;

    protected $table = 'career_education_weights';
    protected $primaryKey = null;
    public $incrementing = false;
    protected $keyType = 'int';
    public $timestamps = false;

    public function career(): BelongsTo
    {
        return $this->belongsTo(Career::class, 'career_id', 'career_id');
    }

    public function education(): BelongsTo
    {
        return $this->belongsTo(Education::class, 'education_id', 'education_id');
    }
}
