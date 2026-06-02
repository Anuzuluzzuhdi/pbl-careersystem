<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['career_name'])]
class Career extends Model
{
    use HasFactory;

    protected $table = 'careers';
    protected $primaryKey = 'career_id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    public function educationWeights(): HasMany
    {
        return $this->hasMany(CareerEducationWeight::class, 'career_id', 'career_id');
    }

    public function skillWeights(): HasMany
    {
        return $this->hasMany(CareerSkillWeight::class, 'career_id', 'career_id');
    }

    public function specializationWeights(): HasMany
    {
        return $this->hasMany(CareerSpecializationWeight::class, 'career_id', 'career_id');
    }

    public function certificationWeights(): HasMany
    {
        return $this->hasMany(CareerCertificationWeight::class, 'career_id', 'career_id');
    }

    public function educations(): BelongsToMany
    {
        return $this->belongsToMany(
            Education::class,
            'career_education_weights',
            'career_id',
            'education_id'
        )->withPivot(['frequency', 'weight']);
    }

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(
            Skill::class,
            'career_skill_weights',
            'career_id',
            'skill_id'
        )->withPivot(['frequency', 'weight']);
    }

    public function specializations(): BelongsToMany
    {
        return $this->belongsToMany(
            Specialization::class,
            'career_specialization_weights',
            'career_id',
            'specialization_id'
        )->withPivot(['frequency', 'weight']);
    }

    public function certifications(): BelongsToMany
    {
        return $this->belongsToMany(
            Certification::class,
            'career_certification_weights',
            'career_id',
            'certification_id'
        )->withPivot(['frequency', 'weight']);
    }
}
