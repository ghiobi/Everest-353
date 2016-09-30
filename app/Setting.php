<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /**
     * The table associated with the model
     *
     * @var string
     */
    protected $table = 'settings';

    /**
     * Disable unnecessity of timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Setting primary key as key column
     *
     * @var string
     */
    public $primaryKey = 'key';

}
