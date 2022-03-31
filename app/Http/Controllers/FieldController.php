<?php

namespace App\Http\Controllers;

use App\Fields;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\{FieldCollection, FieldResource};
use App\Http\Requests\ShowFieldsGet;

class FieldController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome',['fields' => new FieldCollection(Fields::all()),]);
		// в учебных целях поиграться с ресурсами коллекции было довольно интересно, но вообще в данной ситуации такая прокладка совершенно лишняя 
    }
	
	// ajax
	

    /**
     * Получение карточки поля
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    public function show($id)
    {
		$returnHTML = view('modal')->with('field', Fields::findOrFail($id))->render();
		return response()->json(array('success' => true, 'cart'=>$returnHTML));
	}


    /**
     * Отдаёт форму создания нового поля
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function new($id)
    {
        //
		$returnHTML = view('cart_new')->with('field', Fields::findOrFail($id))->render();
		return response()->json(array('success' => true, 'cart'=>$returnHTML));
    }


    /**
     * Отдаёт форму редактирования поля
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
		$returnHTML = view('cart_edit')->with('field', Fields::findOrFail($id))->render();
		return response()->json(array('success' => true, 'cart'=>$returnHTML));
    }
	
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ShowFieldsGet $request, $id)
    {
		// $this->validate($request, [
			// 'date' => 'required|date',
			// 'value' => 'required|integer',
		// ]);
		$validatedData = $request->validated();
		$field = Fields::find($id);
		$field->date = $request->date;
		$field->value = $request->value;
		$field->save();
		
		$returnHTML = view('list')->with('fields', Fields::all())->render();
		return response()->json(array('success' => true, 'table'=>$returnHTML));
	}
	
    // public function show(ShowFieldsGet $request)
    // {
		// $validated = $request->validated();

		// $returnHTML = view('modal')->with('field', Fields::findOrFail($request->id))->render();
		// return response()->json(array('success' => true, 'cart'=>$returnHTML));
	// }

    /**
     * Удаляем поле
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $field = Fields::findOrFail($id);
        $field->delete();
		$returnHTML = view('list')->with('fields', Fields::all())->render();
		return response()->json(array('success' => true, 'table'=>$returnHTML));
	}

	
	
	
	
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShowFieldsGet $request)
    {
		$validatedData = $request->validated();
		$field = new Fields();
		$field->date = $request->date;
		$field->value = $request->value;
		$field->save();
		
		$returnHTML = view('list')->with('fields', Fields::all())->render();
		return response()->json(array('success' => true, 'table'=>$returnHTML));
	}

}
