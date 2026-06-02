<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['specialization_name'])]
class Specialization extends Model
{
    use HasFactory;

    protected $table = 'specializations';
    protected $primaryKey = 'specialization_id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    public function careerWeights(): HasMany
    {
        return $this->hasMany(CareerSpecializationWeight::class, 'specialization_id', 'specialization_id');
    }

    public function careers(): BelongsToMany
    {
        return $this->belongsToMany(
            Career::class,
            'career_specialization_weights',
            'specialization_id',
            'career_id'
        )->withPivot(['frequency', 'weight']);
    }
}
