<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCouponRequest;
use App\Http\Requests\UpdateCouponRequest;
use App\Models\Coupon;
use App\Models\Group;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }

        $coupons = Coupon::latest('created_at')->get();
        return view("dashboard.coupons.index")->with("coupons", $coupons);    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        if(Auth::user()->role != "admin"){
            return view("dashboard.coupons.create")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }

        $groups = Group::where('paid', 1)->where('price', '!=', 0)
            ->where('type', '!=', 'individual')
            ->where('type', '!=', 'free')
            ->where('hidden', 0)
            ->whereHas('events', function ($query) {
                return $query->where("date_at", ">", Carbon::now());
            })->get();

        return view("dashboard.coupons.create")->with('groups', $groups);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCouponRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCouponRequest $request) {
        Coupon::create($request->all());
        return Redirect('dashboard/coupons');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $coupon)
    {
        if(Auth::user()->role != "admin"){
            return view("dashboard.coupons")->with("error", "Neturite teisių ištrinti šį puslapį");
        }

        $groups = Group::where('paid', 1)->where('price', '!=', 0)
            ->where('type', '!=', 'individual')
            ->where('type', '!=', 'free')
            ->where('hidden', 0)
            ->whereHas('events', function ($query) {
                return $query->where("date_at", ">", Carbon::now());
            })->get();

        return view("dashboard.coupons.edit")->with('coupon', $coupon)->with('groups', $groups);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCouponRequest $request
     * @param Coupon $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCouponRequest $request, Coupon $coupon) {
        $coupon->update($request->all());
        return Redirect('dashboard/coupons');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupon $coupon)
    {
        if(Auth::user()->role != "admin"){
            return view("dashboard.coupons")->with("error", "Neturite teisių ištrinti šį puslapį");
        }

        $coupon->delete();
        Session::flash('message', "Kuponas sėkmingai ištrinta");

        return Redirect('dashboard/coupons');
    }
}
