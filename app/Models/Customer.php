<?php

namespace App\Models;

use App\Models\Admin\AddressCustomer;
use App\Models\Admin\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        "firstname",
        "lastname",
        "middle_name",
        "gender",
        "identityNumber_id",
        "email",
        "date_of_birth"
    ];

    public function getFullnameAttribute(){
        return "{$this->firstname} {$this->lastname}";
    }

    public function order(){
        return $this->belongsToMany(Order::class);
    }

    public function addressCustomers() : HasMany{
        return $this->hasMany(AddressCustomer::class);
    }
}
