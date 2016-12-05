<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /**
     * The table associated with the model
     * @var string
     */
    protected $table = 'settings';

    /**
     * Primary key is 'key'
     * @var string
     */
    public $primaryKey = 'key';

    /**
     * Do not increment, add this so that
     * when retrieving the 'key' it is not 0.
     * @var bool
     */
    public $incrementing = false;

}
