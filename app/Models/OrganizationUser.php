<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Pivot model representing the relationship between users and organizations.
 * Stores the role of each user within the organization.
 */
class OrganizationUser extends Model
{
    use HasFactory;

    protected $table = 'organization_user';
    public $timestamps = true;
    protected $fillable = ['id', 'user_id', 'organization_id', 'role', 'created_at', 'updated_at'];
    protected $casts = [
        // Add attribute casting here if needed
    ];
}
