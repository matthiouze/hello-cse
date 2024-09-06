<?php

namespace App\Models;

use App\Enum\Status;
use App\Observers\ProfileObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Profile extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'firstname',
        'status',
        'image_path',
    ];

    protected $casts = [
        'statut' => Status::class,
    ];

    protected static function booted(): void
    {
        self::observe(ProfileObserver::class);
    }

    /**
     * @return HasOne
     */
    public function admin(): HasOne
    {
        return $this->hasOne(Admin::class);
    }

    /**
     * @return HasOne
     */
    public function comments(): HasOne
    {
        return $this->hasOne(Comment::class);
    }
}
