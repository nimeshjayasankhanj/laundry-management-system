<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\API;

use App\Category;
use App\Customer;
use App\Http\Controllers\Controller;
use App\ItemRegistry;
use App\Lead;
use App\MasterCompany;
use App\MetaMeasurement;
use App\Production;
use App\ServiceCategory;
use App\ServiceRegistry;
use App\Staff;
use App\Store;
use App\SubContract;
use App\Supplier;
use App\User;
use App\Vehicle;
use Illuminate\Http\Request;

class CommonController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function activateDeactivate(Request $request)
    {

        $id = $request['id'];
        $table = $request['table'];

        if ($table == "customer") {

            $table = Customer::find($id);
            if ($table->status == 1) {
                $table->status = 0;
            } else {
                $table->status = 1;
            }
            $table->update();

        }
        if ($table == "master_user") {

            $table = User::find($id);
            if ($table->status == 1) {
                $table->status = 0;
            } else {
                $table->status = 1;
            }
            $table->update();

        }
        if ($table == "Master_Company") {

            $table = MasterCompany::find($id);
            if ($table->status == 1) {
                $table->status = 0;
            } else {
                $table->status = 1;
            }
            $table->update();

        }
        if ($table == "Lead") {

            $table = Lead::find($id);
            if ($table->status == 1) {
                $table->status = 0;
            } else {
                $table->status = 1;
            }
            $table->update();

        }
        if ($table == "Supplier") {

            $table = Supplier::find($id);
            if ($table->status == 1) {
                $table->status = 0;
            } else {
                $table->status = 1;
            }
            $table->update();

        }
        if ($table == "Category") {

            $table = Category::find($id);
            if ($table->status == 1) {
                $table->status = 0;
            } else {
                $table->status = 1;
            }
            $table->update();

        }
        if ($table == "Item_Registry") {

        $table = ItemRegistry::find($id);
        if ($table->status == 1) {
            $table->status = 0;
        } else {
            $table->status = 1;
        }
        $table->update();

    }
        if ($table == "Store") {

            $table = Store::find($id);
            if ($table->status == 1) {
                $table->status = 0;
            } else {
                $table->status = 1;
            }
            $table->update();

        }
    if ($table == "production") {

        $table = Production::find($id);
        if ($table->status == 1) {
            $table->status = 0;
        } else {
            $table->status = 1;
        }
        $table->update();

    }if ($table == "Staff") {

            $table = Staff::find($id);
            if ($table->status == 1) {
                $table->status = 0;
            } else {
                $table->status = 1;
            }
            $table->update();

        }if ($table == "Sub_Contact") {

        $table = SubContract::find($id);
        if ($table->status == 1) {
            $table->status = 0;
        } else {
            $table->status = 1;
        }
        $table->update();

    }if ($table == "service_category") {

        $table = ServiceCategory::find($id);
        if ($table->status == 1) {
            $table->status = 0;
        } else {
            $table->status = 1;
        }
        $table->update();

    }if ($table == "service_registry") {

        $table = ServiceRegistry::find($id);
        if ($table->status == 1) {
            $table->status = 0;
        } else {
            $table->status = 1;
        }
        $table->update();

    }if ($table == "Meta_Measurement") {

        $table = MetaMeasurement::find($id);
        if ($table->status == 1) {
            $table->status = 0;
        } else {
            $table->status = 1;
        }
        $table->update();

    }if ($table == "vehicle") {

        $table = Vehicle::find($id);
        if ($table->status == 1) {
            $table->status = 0;
        } else {
            $table->status = 1;
        }
        $table->update();

    }
    }

}
