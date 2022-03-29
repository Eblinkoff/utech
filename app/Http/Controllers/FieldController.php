<?php

namespace App\Http\Controllers;

use App\Fields;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FieldController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome',['fields' => Fields::all(),]);
    }
	
	
	
	// ajax
	
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$this->validate($request, [
			'name' => 'required|min:10',
			'article' => 'required|alpha_num|unique:products,article',
		]);
		// надо ли говорить, что для боевого проекта такой валидации недостаточно, но это тестовое задание и я делаю только то, что в нём есть
		$product = new Products();
		$product->name = $request->name;
		$product->article = $request->article;
		$product->status = $request->status;
		// jsonb
		if($request->data != null)
		{
			$json = '';
			for($i = 0; $i < count($request->data['key']);$i++)
			{
				if(isset($request->data['key'][$i]) && $request->data['key'][$i] != '')
				{
					$json .= ($i > 0 ? ',' : '').'"'.$request->data['key'][$i].'": "'.$request->data['value'][$i].'"';
				}
			}
			// '{"a": 1}'
			$product->data = '{'.$json.'}';
		}
		else
		{
			$product->data = '{}';
		}
		$product->save();
		
		// теперь ещё отправим письмо
		$details['email'] = config('products.email');

		dispatch(new SendEmailJob($details));
		
		$returnHTML = view('products_list')->with('products', Products::all())->render();
		return response()->json(array('success' => true, 'table'=>$returnHTML));
	}

    /**
     * Получение карточки поля
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		$returnHTML = view('modal')->with('field', Fields::findOrFail($id))->render();
		return response()->json(array('success' => true, 'cart'=>$returnHTML));
	}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
		$returnHTML = view('products_cart_edit')->with('product', Products::findOrFail($id))->render();
		return response()->json(array('success' => true, 'cart'=>$returnHTML));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
		$this->validate($request, [
			'name' => 'required|min:10',
			'article' => 'required|alpha_num',
		]);
		// надо ли говорить, что для боевого проекта такой валидации недостаточно, но это тестовое задание и я делаю только то, что в нём есть
		$product = Products::find($id);
		// $product = Products::findOrFail($id);
		$product->name = $request->name;
		if(Auth::check() && Auth::user()->id == (int) config('products.role'))
		{
			$product->article = $request->article;
		}
		$product->status = $request->status;
		// jsonb
		if($request->data != null)
		{
			$json = '';
			for($i = 0; $i < count($request->data['key']);$i++)
			{
				if(isset($request->data['key'][$i]) && $request->data['key'][$i] != '')
				{
					$json .= ($i > 0 ? ',' : '').'"'.$request->data['key'][$i].'": "'.$request->data['value'][$i].'"';
				}
			}
			// '{"a": 1}'
			$product->data = '{'.$json.'}';
		}
		else
		{
			$product->data = '{}';
		}
		$product->save();
		$returnHTML = view('products_list')->with('products', Products::all())->render();
		return response()->json(array('success' => true, 'table'=>$returnHTML));
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Products::findOrFail($id);
        $product->delete();
		$returnHTML = view('products_list')->with('products', Products::all())->render();
		return response()->json(array('success' => true, 'table'=>$returnHTML));
	}
}
