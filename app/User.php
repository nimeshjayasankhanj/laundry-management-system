<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;


    protected $table= 'Master_User';
    protected  $primaryKey='idMaster_User';

    public function UserRole(){
        return $this->belongsTo(UserRole::class,'Meta_User_Role');
    }
    public function Invoice(){
        return $this->hasMany(Invoice::class,'Master_User');
    }
    public function SalesOrder()
    {
        return $this->hasMany(SalesOrder::class,'Master_User');
    }
    public function Quotation(){
        return $this->hasMany(Quotation::class,'Master_User');
    }
    public function Supplier(){
        return $this->hasMany(Supplier::class,'Master_User');
    }

    public function Lead(){
        return $this->hasMany(Lead::class,'Master_User');
    }

    public function Customer(){
        return $this->hasMany(Customer::class,'Master_User');
    }

    public function ItemRegistry(){
        return $this->hasMany(ItemRegistry::class,'Master_User');
    }
    public function Category(){
        return $this->hasMany(Category::class,'Master_User');
    }

    public function Production(){
        return $this->hasMany(Production::class,'Master_User');
    }
    public function Staff(){
        return $this->hasMany(Staff::class,'Master_User');
    }
    public function Store(){
        return $this->hasMany(Store::class,'Master_User');
    }
    public function GRN(){
        return $this->hasMany(GRN::class,'Master_User');
    }
    public function Stock(){
        return $this->hasMany(Stock::class,'Master_User');
    }
    public function Voucher(){
        return $this->hasMany(Voucher::class,'Master_User');
    }
    public function Receipt(){
        return $this->hasMany(Receipt::class,'Master_User');
    }
    public function SubContract(){
        return $this->hasMany(SubContract::class,'Master_User');
    }
    public function Vehicle(){
        return $this->hasMany(Vehicle::class,'Master_User');
    }
    public function ServiceRegistry(){
        return $this->hasMany(ServiceRegistry::class,'Master_User');
    }

    public function JobMaster(){
        return $this->hasMany(JobMaster::class,'Master_User');
    }
    public function MetaMeasurement(){
        return $this->hasMany(MetaMeasurement::class,'Master_User_idUser');
    }
    public function OpeningStock(){
        return $this->hasMany(OpeningStock::class,'Master_User');
    }
    public function JobInvoice(){
        return $this->hasMany(JobInvoice::class,'Master_User');
    }

}
