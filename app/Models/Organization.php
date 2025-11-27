<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Represents an organization and its relationships.
 */
class Organization extends Model
{
    use HasFactory;

    protected $table = 'organizations';
    public $timestamps = true;
    protected $fillable = ['id', 'name', 'user_id', 'created_at', 'updated_at'];
    protected $casts = [
        // Add attribute casting here if needed
    ];

    /**
     * The users belonging to this organization.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function members()
    {
        // Many-to-many relationship with pivot 'role' and timestamps
        return $this->belongsToMany(User::class, 'organization_user')
                    ->withPivot('role')
                    ->withTimestamps();
    }

    /**
     * The owner of the organization.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        // Belongs-to relationship to the User model via 'user_id'
        return $this->belongsTo(User::class, 'user_id');
    }
}
