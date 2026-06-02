<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['education_level'])]
class Education extends Model
{
    use HasFactory;

    protected $table = 'educations';
    protected $primaryKey = 'education_id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    public function careerWeights(): HasMany
    {
        return $this->hasMany(CareerEducationWeight::class, 'education_id', 'education_id');
    }

    public function careers(): BelongsToMany
    {
        return $this->belongsToMany(
            Career::class,
            'career_education_weights',
            'education_id',
            'career_id'
        )->withPivot(['frequency', 'weight']);
    }
}
