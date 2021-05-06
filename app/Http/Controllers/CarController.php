<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

use App\Models\Car as Model;

class CarController extends Controller
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
            $data = $data->where('name', 'like', '%' . $search . '%');
            $is_filtered = true;
        }

        // Order
        $data = $data->orderBy('name', 'asc');

        // Paginate
        $data = $data->paginate($limit)->appends($request->query());

        // Redirect to first page if empty
        if($request->page > 1 && count($data) == 0)
            return redirect()->route('car.index', array_merge($request->query(), ['page' => $request->page - 1]));

        // Save current url for redirection after update data
        $request->session()->flash('car.index', url()->full());

        return view('car.index', [
            'data' => $data,
            'number' => $number,
            'is_filtered' => $is_filtered,
            'search' => $search,
        ]);
    }

    public function create(){
        return view('car.create');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required',
        ]);
        if ($validator->fails()) return errorInputResponse($validator);

        $data = [
            'user_id' => auth()->user()->id,
            'name' => $request->name,
            'price' => (double) toSystemNumber($request->price),
            'stock' => (integer) $request->stock,
        ];
        Model::create($data);

        $request->session()->flash('success', 'New Car has been created.');
        return successDataResponse([
            'redirect' => route('car.index'),
        ]);
    }

    public function edit($id){
        $data = Model::find($id);
        if(!$data) abort(404);

        return view('car.edit', [
            'data' => $data,
        ]);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required',
        ]);
        if ($validator->fails()) return errorInputResponse($validator);

        $data = [
            'user_id' => auth()->user()->id,
            'name' => $request->name,
            'price' => (double) toSystemNumber($request->price),
            'stock' => (integer) $request->stock,
        ];
        Model::find($id)->update($data);

        // Redirect to previous index
        if($request->has('redirect') && $request->redirect != ''){
            $redirect = $request->redirect;
        } else {
            $redirect = route('car.index');
        }
        
        $request->session()->flash('success', 'A Car has been updated.');
        return successDataResponse([
            'redirect' => $redirect,
        ]);
    }

    public function delete(Request $request, $id){
        Model::find($id)->delete();
        $request->session()->flash('success', 'A Car has been deleted.');
        return successResponse();
    }

}
