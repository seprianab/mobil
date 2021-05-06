<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

use App\Models\Sale as Model;
use App\Models\Customer;
use App\Models\Car;

class SaleController extends Controller
{

    public function index(Request $request){

        $limit = 10;
        $number = (($request->has('page') ? $request->page : 1) - 1)  * $limit;

        $is_filtered = false;
        $data = new Model;

        // Search
        $search = "";
        if($request->has('search') && $request->search != ''){
            $search = $request->search;
            $data = $data->where(function($query) use ($search) {
                $query->where('customer_name', 'like', '%' . $search . '%')
                    ->orWhere('customer_email', $search)
                    ->orWhere('car_name', 'like', '%' . $search . '%');
            });
            $is_filtered = true;
        }

        // Order
        $data = $data->orderBy('date', 'desc')->orderBy('created_at', 'desc');

        // Paginate
        $data = $data->paginate($limit)->appends($request->query());

        // Redirect to first page if empty
        if($request->page > 1 && count($data) == 0)
            return redirect()->route('sale.index', array_merge($request->query(), ['page' => $request->page - 1]));

        // Save current url for redirection after update data
        $request->session()->flash('sale.index', url()->full());

        return view('sale.index', [
            'data' => $data,
            'number' => $number,
            'is_filtered' => $is_filtered,
            'search' => $search,
        ]);
    }

    public function create(Request $request){
        $customer = null;
        $email = null;

        if($request->has('email') && $request->get('email') != ''){
            $customer = Customer::where('email', $request->get('email'))->first();
            $email = $request->get('email');
        }

        $cars = Car::orderBy('name', 'asc')->where('stock', '>', 0)->get();
        return view('sale.create', [
            'customer' => $customer,
            'email' => $email,
            'cars' => $cars,
        ]);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'date' => 'required',

            'customer_name' => 'required',
            'customer_phone' => 'required',
            'customer_email' => 'required',

            'car_id' => 'required',
            'car_price' => 'required',
        ]);
        if ($validator->fails()) return errorInputResponse($validator);

        // Customer
        $customer = Customer::where('email', $request->customer_email)->first();
        if(!$customer){
            $data_customer = [
                'name' => $request->customer_name,
                'phone' => $request->customer_phone,
                'email' => $request->customer_email,
                'user_id' => auth()->user()->id,
            ];

            $customer = Customer::create($data_customer);
        }

        // Car
        $car = Car::find($request->car_id);
        if(!$car) return errorResponse("car-not-found", "Car not found!");
        if($car->stock <= 0) return errorResponse("car-stock", "Car's stock is empty");

        $data = [
            'user_id' => auth()->user()->id,

            'date' => toSystemDate($request->date),

            'customer_id' => $customer->id,
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_email' => $request->customer_email,

            'car_id' => $request->car_id,
            'car_name' => $car->name,
            'car_price' => (double) toSystemNumber($request->car_price),
        ];
        Model::create($data);

        // Kurangi stok "Car"
        $car->decrement('stock');

        $request->session()->flash('success', 'New Sale has been created.');
        return successDataResponse([
            'redirect' => route('sale.index'),
        ]);
    }

    public function cancel(Request $request, $id){
        Model::find($id)->update([
            'status' => 2
        ]);
        $request->session()->flash('success', 'A Sale has been cancelled.');
        return successResponse();
    }

}
