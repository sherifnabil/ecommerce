<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\model\Department;
use Illuminate\Http\Request;
use Storage;

class DepartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.departments.index', ['title' => trans('admin.departments')]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.departments.create', ['title' => trans('admin.add')]);
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
            'dep_name_ar'      =>    'required',
            'dep_name_en'      =>    'required',
            'parent'           =>    'sometimes|nullable|numeric',
            'description'      =>    'sometimes|nullable',
            'keyword'          =>    'sometimes|nullable',
            'icon'             =>    'sometimes|nullable |' . v_image(),
        ], [],
        [
            'dep_name_ar'   =>    trans('admin.dep_name_ar'),
            'dep_name_en'   =>    trans('admin.dep_name_en'),
            'parent'        =>    trans('admin.parent'),
            'icon'          =>    trans('admin.icon'),
            'description'   =>    trans('admin.description'),
            'keyword'       =>    trans('admin.keyword'),
        ]);

        if(request()->hasFile('icon')){
            $data['icon'] = up()->upload([
                    'file'          =>  'icon',
                    'path'          =>  'departments',
                    'upload_type'   =>  'single',
                    'delete_file'   =>  '',
            ]);
        }


        Department::create($data);
        session()->flash('success', trans('admin.record_added'));
        return redirect(aurl('departments'));
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
        $department = Department::find($id);
        $title = trans('admin.edit');
        return view('admin.departments.edit', compact('department', 'title'));

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
            'dep_name_ar'      =>    'required',
            'dep_name_en'      =>    'required',
            'parent'           =>    'sometimes|nullable',
            'icon'             =>    'sometimes|nullable',
            'description'      =>    'sometimes|nullable',
            'keyword'          =>    'sometimes|nullable',


        ], [],
        [
            'dep_name_ar'   =>    trans('admin.dep_name_ar'),
            'dep_name_en'   =>    trans('admin.dep_name_en'),
            'parent'        =>    trans('admin.parent'),
            'icon'          =>    trans('admin.icon'),
            'description'   =>    trans('admin.descriptionn'),
            'keyword'       =>    trans('admin.keyword'),
        ]);

        if(request()->hasFile('icon')){
            $data['icon'] = up()->upload([
                    'file'          =>  'icon',
                    'path'          =>  'departments',
                    'upload_type'   =>  'single',
                'delete_file'   =>  Department::find($id),
            ]);
        }

        Department::where('id', $id)->update($data);
        session()->flash('success', trans('admin.record_updated'));
        return redirect(aurl('departments'));
    }


    public static function delete_parent($id)
    {
        $department_parent = Department::where('parent', $id);
        foreach($department_parent as $sub):
            self::delete_parent();
            if(!empty($sub->icon)):
                Storage::has($sub->icon) ? Storage::delete($sub->icon) : '';

            endif;
            $subdepartment = Department::find($sub->id)->delete();
            if(!empty($subdepartment)):
                $subdepartment->delete();

            endif;
        endforeach;
        $dep = Department::find($id);
        if(!empty($dep->icon)):
            Storage::has($dep->icon) ? Storage::delete($dep->icon) : '';
        endif;
        $dep->delete();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        self::delete_parent($id);
        session()->flash('success', trans('admin.record_deleted'));
        return redirect(aurl('departments'));    }

}
