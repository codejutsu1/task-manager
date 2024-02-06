<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'is_done'
    ];

    protected $casts = [
        'is_done' => 'boolean'
    ];

    protected $hidden = [
        'updated_at'
    ];

    public function scopeGetAll(Builder $query)
    {
        return QueryBuilder::for(Task::class)
                    ->allowedFilters(['title', 'is_done'])
                    ->defaultSort('created_at')
                    ->allowedSorts(['title', 'is_done', 'created_at'])
                    ->paginate();
    }


    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    protected static function booted(): void
    {
        static::addGlobalScope('creator', function (Builder $builder){
            $builder->where('creator_id', Auth::id());
        });
    }
}
