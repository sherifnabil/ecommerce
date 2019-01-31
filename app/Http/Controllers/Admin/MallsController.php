<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\DataTables\MallsDataTable;
use App\model\Mall;
use Illuminate\Http\Request;
use Storage;

class MallsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MallsDataTable $mall)
    {
        return $mall->render('admin.malls.index', ['title' => trans('admin.malls')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.malls.create', ['title' => trans('admin.create_malls')]);
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
            'name_ar'      =>    'required',
            'name_en'      =>    'required',
            'address'      =>    'sometimes|nullable',
            'facebook'     =>    'sometimes|nullable|url',
            'twitter'      =>    'sometimes|nullable|url',
            'website'      =>    'sometimes|nullable|url',
            'contact_name' =>    'sometimes|nullable|string',
            'mobile'       =>    'sometimes|nullable|numeric',
            'country_id'   =>    'required|numeric',
            'email'        =>    'sometimes|nullable|email',
            'lng'          =>    'sometimes|nullable',
            'lat'          =>    'sometimes|nullable',
            'icon'         =>    'sometimes|nullable|' . v_image(),
        ], [],
        [
            'name_ar'       =>    trans('admin.name_ar'),
            'name_en'       =>    trans('admin.name_en'),
            'address'       =>    trans('admin.address'),
            'facebook'      =>    trans('admin.facebook'),
            'twitter'       =>    trans('admin.twitter'),
            'website'       =>    trans('admin.website'),
            'mobile'        =>    trans('admin.mobile'),
            'country_id'    =>    trans('admin.country_id'),
            'email'         =>    trans('admin.email'),
            'contact_name'  =>    trans('admin.contact_name'),
            'lat'           =>    trans('admin.lat'),
            'lng'           =>    trans('admin.lng'),
            'icon'          =>    trans('admin.icon'),
        ]);

        if(request()->hasFile('icon')){
            $data['icon'] = up()->upload([
                    'file'          =>  'icon',
                    'path'          =>  'malls',
                    'upload_type'   =>  'single',
                    'delete_file'   =>  '',
            ]);
        }

        Mall::create($data);
        session()->flash('success', trans('admin.record_added'));
        return redirect(aurl('malls'));
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
        $mall = Mall::find($id);
        $title = trans('admin.edit');
        return view('admin.malls.edit', compact('mall', 'title'));

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
            'name_ar'      =>    'required',
            'name_en'      =>    'required',
            'address'      =>    'sometimes|nullable',
            'facebook'     =>    'sometimes|nullable|url',
            'twitter'      =>    'sometimes|nullable|url',
            'website'      =>    'sometimes|nullable|url',
            'contact_name' =>    'sometimes|nullable|string',
            'country_id'   =>    'required|numeric',
            'mobile'       =>    'sometimes|nullable|numeric',
            'email'        =>    'sometimes|nullable|email',
            'lng'          =>    'sometimes|nullable',
            'lat'          =>    'sometimes|nullable',
            'icon'         =>    'sometimes|nullable|' . v_image(),
        ], [],
        [
            'name_ar'       =>    trans('admin.name_ar'),
            'name_en'       =>    trans('admin.name_en'),
            'address'       =>    trans('admin.address'),
            'facebook'      =>    trans('admin.facebook'),
            'twitter'       =>    trans('admin.twitter'),
            'website'       =>    trans('admin.website'),
            'mobile'        =>    trans('admin.mobile'),
            'email'         =>    trans('admin.email'),
            'contact_name'  =>    trans('admin.contact_name'),
            'lat'           =>    trans('admin.lat'),
            'lng'           =>    trans('admin.lng'),
            'icon'          =>    trans('admin.icon'),
        ]);

        if(request()->hasFile('icon')){
            $data['icon'] = up()->upload([
                    'file'          =>  'icon',
                    'path'          =>  'malls',
                    'upload_type'   =>  'single',
                    'delete_file'   =>  Mall::find($id)->icon,
            ]);
        }

        Mall::where('id', $id)->update($data);
        session()->flash('success', trans('admin.record_updated'));
        return redirect(aurl('malls'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $malls = Mall::find($id);
        Storage::delete($malls->icon);
        $malls->delete();
        session()->flash('success', trans('admin.record_deleted'));
        return redirect(aurl('malls'));    }

    public function multi_delete()
    {
        if(is_array(request('item')))
        {
            foreach(request('item') as $id){
                $malls = Mall::find($id);

                Storage::delete($malls->icon);

                $malls->delete();
            }

        }else{
            $malls = Mall::find(request('item'))->delete();

            Storage::delete($malls->icon);

            $malls->delete();

        }
        session()->flash('success', trans('admin.record_deleted'));
        return redirect(aurl('malls'));
    }
}
