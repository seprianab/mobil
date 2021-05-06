<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

use App\Models\Customer as Model;

class CustomerController extends Controller
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
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', $search);
            });
            $is_filtered = true;
        }

        // Order
        $data = $data->orderBy('name', 'asc');

        // Paginate
        $data = $data->paginate($limit)->appends($request->query());

        // Redirect to first page if empty
        if($request->page > 1 && count($data) == 0)
            return redirect()->route('customer.index', array_merge($request->query(), ['page' => $request->page - 1]));

        // Save current url for redirection after update data
        $request->session()->flash('customer.index', url()->full());

        return view('customer.index', [
            'data' => $data,
            'number' => $number,
            'is_filtered' => $is_filtered,
            'search' => $search,
        ]);
    }

    public function create(){
        return view('customer.create');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
        ]);
        if ($validator->fails()) return errorInputResponse($validator);

        $data = [
            'user_id' => auth()->user()->id,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
        ];
        Model::create($data);

        $request->session()->flash('success', 'New Customer has been created.');
        return successDataResponse([
            'redirect' => route('customer.index'),
        ]);
    }

    public function edit($id){
        $data = Model::find($id);
        if(!$data) abort(404);

        return view('customer.edit', [
            'data' => $data,
        ]);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
        ]);
        if ($validator->fails()) return errorInputResponse($validator);

        $data = [
            'user_id' => auth()->user()->id,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
        ];
        Model::find($id)->update($data);

        // Redirect to previous index
        if($request->has('redirect') && $request->redirect != ''){
            $redirect = $request->redirect;
        } else {
            $redirect = route('customer.index');
        }
        
        $request->session()->flash('success', 'A Customer has been updated.');
        return successDataResponse([
            'redirect' => $redirect,
        ]);
    }

    public function delete(Request $request, $id){
        Model::find($id)->delete();
        $request->session()->flash('success', 'A Customer has been deleted.');
        return successResponse();
    }

}
