<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class MemberLoginDetail extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'member_login_details';
    protected $fillable = ['full_name', 'email', 'phone_number', 'password'];
    protected $primaryKey = 'id';
    public $timestamps = true;

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }
    public function getAuthPassword()
    {
        return $this->password;
    }
}
