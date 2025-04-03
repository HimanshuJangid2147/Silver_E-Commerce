<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    protected $table = 'our_policies'; // Specify the table name
    protected $primaryKey = 'id'; // Specify the primary key
    protected $connection = 'mysql';
}
?>
