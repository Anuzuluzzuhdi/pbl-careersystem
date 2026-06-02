<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['skill_name'])]
class Skill extends Model
{
    use HasFactory;

    protected $table = 'skills';
    protected $primaryKey = 'skill_id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    public function careerWeights(): HasMany
    {
        return $this->hasMany(CareerSkillWeight::class, 'skill_id', 'skill_id');
    }

    public function careers(): BelongsToMany
    {
        return $this->belongsToMany(
            Career::class,
            'career_skill_weights',
            'skill_id',
            'career_id'
        )->withPivot(['frequency', 'weight']);
    }
}
