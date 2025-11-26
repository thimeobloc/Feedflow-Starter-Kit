<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $table    = 'organizations';
    public $timestamps  = true;
    protected $fillable = [ 'id', 'name', 'user_id', 'created_at', 'updated_at' ];
    protected $casts = [
    ];

    // Users belonging to this organization
    public function members()
    {
        return $this->belongsToMany(User::class, 'organization_user')->withTimestamps();
    }

    // Owner of the organization
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
