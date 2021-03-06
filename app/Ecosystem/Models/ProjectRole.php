<?php

namespace App\Ecosystem\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ProjectRole
 * @package App\Models
 * @version September 25, 2016, 6:11 pm UTC
 */
class ProjectRole extends Model
{
    use SoftDeletes;

    public $table = 'project_roles';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'name',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function projectInfos()
    {
        return $this->hasMany(\App\Ecosystem\Models\ProjectInfo::class);
    }
}
