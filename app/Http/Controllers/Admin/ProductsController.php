<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\DataTables\ProductsDataTable;
use App\model\Product;
use Illuminate\Http\Request;
use Storage;

class ProductsController extends Controller
{
    /**
     * Displa  a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductsDataTable $product)
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product = Product::create([
            'title'          => '',

        ]);

        if(!empty($product)){
            return redirect(aurl('products/' . $product->id . '/edit') );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {

        $data = $this->validate(request(),
        [
            'product_name_ar'      =>    'required',
            'product_name_en'      =>    'required',
            'mob'                  =>    'required',
            'code'                 =>    'required',
            'logo'                 =>    'sometimes|nullable' . v_image(),
        ], [],
        [
            'product_name_ar'   =>    trans('admin.product_name_ar'),
            'product_name_en'   =>    trans('admin.product_name_en'),
            'mob'               =>    trans('admin.mob'),
            'code'              =>    trans('admin.code'),
            'logo'              =>    trans('admin.logo'),
        ]);

        if(request()->hasFile('logo')){
            $data['logo'] = up()->upload([
                    'file'          =>  'logo',
                    'path'          =>  'products',
                    'upload_type'   =>  'single',
                    'delete_file'   =>  '',
            ]);
        }

        Product::create($data);
        session()->flash('success', trans('admin.record_added'));
        return redirect(aurl('products'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        return view('admin.products.product', ['title' => trans('admin.create_or_edit_product', ['title' => $product->title]), 'product' => $product]);

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
        $data = $this->validate(request(),
        [
            'product_name_ar'      =>    'required',
            'product_name_en'      =>    'required',
            'mob'                  =>    'required',
            'code'                 =>    'required',
            'logo'                 =>    'sometimes|nullable|' . v_image(),
        ], [],
        [
            'product_name_ar'   =>    trans('admin.product_name_ar'),
            'product_name_en'   =>    trans('admin.product_name_en'),
            'mob'               =>    trans('admin.mob'),
            'code'              =>    trans('admin.code'),
            'logo'              =>    trans('admin.logo'),
        ]);

        if(request()->hasFile('logo')){
            $data['logo'] = up()->upload([
                    'file'          =>  'logo',
                    'path'          =>  'products',
                    'upload_type'   =>  'single',
                    'delete_file'   =>  Product::find($id)->logo,
            ]);
        }

        Product::where('id', $id)->update($data);
        session()->flash('success', trans('admin.record_updated'));
        return redirect(aurl('products'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $products = Product::find($id);
        Storage::delete($products->logo);
        $products->delete();
        session()->flash('success', trans('admin.record_deleted'));
        return redirect(aurl('products'));    }

    public function multi_delete()
    {
        if(is_array(request('item')))
        {
            foreach(request('item') as $id){
                $products = Product::find($id);

                Storage::delete($products->logo);

                $products->delete();
            }

        }else{
            $products = Product::find(request('item'))->delete();

            Storage::delete($products->logo);

            $products->delete();

        }
        session()->flash('success', trans('admin.record_deleted'));
        return redirect(aurl('products'));
    }
}
