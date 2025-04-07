<?php

namespace App;

use App\Contracts\Uploader;
use App\Traits\HasJWT;
use App\Traits\UploadsFiles;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject, Uploader
{
    use Notifiable, SoftDeletes, HasJWT, UploadsFiles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes used for uploads.
     *
     * @var array
     */
    protected $uploadAttributes = [
        'directory',
        'filename',
        'original_filename',
        'filesize',
        'thumbnail_filesize',
        'url',
        'thumbnail_url'
    ];

    /**
     * Get the directory for uploads.
     *
     * @return string
     */
    public function getDirectory(): string
    {
        return 'users/' . $this->getKey();
    }

    /**
     * Get the upload attributes
     *
     * @return array
     */
    public function getUploadAttributes(): array
    {
        return $this->uploadAttributes;
    }

    public function task_reviewers(): HasMany
    {
        return $this->hasMany(TaskReviewer::class);
    }
}
