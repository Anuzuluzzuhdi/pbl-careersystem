<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['certification_name'])]
class Certification extends Model
{
    use HasFactory;

    protected $table = 'certifications';
    protected $primaryKey = 'certification_id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    public function careerWeights(): HasMany
    {
        return $this->hasMany(CareerCertificationWeight::class, 'certification_id', 'certification_id');
    }

    public function careers(): BelongsToMany
    {
        return $this->belongsToMany(
            Career::class,
            'career_certification_weights',
            'certification_id',
            'career_id'
        )->withPivot(['frequency', 'weight']);
    }
}
