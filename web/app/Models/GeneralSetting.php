<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    protected $table = 'generalsettings';
    protected $primaryKey = 'id';
    protected $connection = 'mysql';
}
