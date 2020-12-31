<?php


namespace App\Http\Controllers;


class CustomerBookingController extends Controller
{
        public function makeABooking(){

            return view('booking.make-a-booking',['title'=>'Make a Booking']);


        }




}