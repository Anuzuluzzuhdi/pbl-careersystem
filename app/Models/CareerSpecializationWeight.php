<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['career_id', 'specialization_id', 'frequency', 'weight'])]
class CareerSpecializationWeight extends Model
{
    use HasFactory;

    protected $table = 'career_specialization_weights';
    protected $primaryKey = null;
    public $incrementing = false;
    protected $keyType = 'int';
    public $timestamps = false;

    public function career(): BelongsTo
    {
        return $this->belongsTo(Career::class, 'career_id', 'career_id');
    }

    public function specialization(): BelongsTo
    {
        return $this->belongsTo(Specialization::class, 'specialization_id', 'specialization_id');
    }
}
