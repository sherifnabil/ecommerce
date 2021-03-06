<?php
if(!function_exists('aurl'))
{
    function aurl($arg = null)
    {
        return url('admin/' . $arg);

    }
}


if(!function_exists('up'))
{
    function up()
    {
        return new \App\Http\Controllers\Upload;

    }
}


if(!function_exists('load_dep'))
{
    function load_dep($select = null, $dep_hide = null)
    {
        $departments = \App\model\Department::selectRaw('dep_name_' . session('lang') . ' as text')
                        ->selectRaw('id as id')
                        ->selectRaw('parent as parent')
                        ->get(['text', 'parent', 'id']);

                        $dep_arr = [];
                        foreach($departments as $department){
                            $list_arr             = [];
                            $list_arr['icon']     = '';
                            $list_arr['li_attr']  = '';
                            $list_arr['a_attr']   = '';
                            $list_arr['children'] = [];

                            if($select !== null and $select == $department->id){
                                $list_arr['icon'] = '';
                                $list_arr['li_attr'] = '';
                                $list_arr['a_attr'] = '';
                                $list_arr['children'] = '';
                                $list_arr['state'] = [
                                    'opened'   => true,
                                    'selected' => true,
                                    'disabled' => false,
                                    'hidden'   => false,
                                ];
                            }

                            if($dep_hide !== null and $dep_hide == $department->id){
                                $list_arr['icon'] = '';
                                $list_arr['li_attr'] = '';
                                $list_arr['a_attr'] = '';
                                $list_arr['children'] = '';
                                $list_arr['state'] = [
                                    'opened'   => false,
                                    'selected' => false,
                                    'disabled' => true,
                                ];
                            }
                            $list_arr['id'] = $department->id;
                            $list_arr['parent'] = $department->parent > 0 ? $department->parent : '#';
                            $list_arr['text'] = $department->text;
                            array_push($dep_arr, $list_arr);

                        }
                    return json_encode($dep_arr, JSON_UNESCAPED_UNICODE);

    }
}

if(!function_exists('get_parent'))
{
    function get_parent($dep_id)
    {
        // $dep_arr = [];

        $department = \App\model\Department::find($dep_id);
        if($department->parent !== null && $department->parent > 0)
        {
            return get_parent($department->parent) . "." . $dep_id;
        }else{
            return $dep_id;
        }


    }
}


if(!function_exists('admin'))
{
    function admin()
    {
        return  auth()->guard('admin');

    }
}



if(!function_exists('setting'))
{
    function setting()
    {
        return  \App\model\Setting::orderBy('id', 'desc')->first();

    }
}


if(!function_exists('lang'))
{
    function lang()
    {
        if(session()->has('lang'))
        {
            return session('lang');
        }else{
            session()->put('lang', setting()->main_lang);
            return setting()->main_lang;
        }
    }
}


if(!function_exists('active_menu'))
{
    function active_menu($link)
    {
        if(preg_match('/' . $link . '/', Request::segment(2)))
        {
            return ['menu-open', 'display:block'];
        }else{
            return ['', ''];

        }
    }
}



if(!function_exists('direction'))
{
    function direction()
    {
        if(session()->has('lang'))
        {
            if(session('lang') == 'ar')
            {
                return 'rtl';
            }else{
                return 'ltr';
            }
        }else{
           return 'ltr';
        }
    }
}


if(!function_exists('datatableLang'))
{
    function datatableLang()
    {
        return
        [
            'sProcessing'       =>   trans('admin.sProcessing'),
            'sLengthMenu'       =>   trans('admin.sLengthMenu'),
            'sZeroRecords'      =>   trans('admin.sZeroRecords'),
            'sEmptyTable'       =>   trans('admin.sEmptyTable'),
            'sInfo'             =>   trans('admin.sInfo'),
            'sInfoEmpty'        =>   trans('admin.sInfoEmpty'),
            'sInfoFiltered'     =>   trans('admin.sInfoFiltered'),
            'sInfoPostFix'      =>   trans('admin.sInfoPostFix'),
            'sSearch'           =>   trans('admin.sSearch'),
            'sUrl'              =>   trans('admin.sUrl'),
            'sInfoThousands'    =>   trans('admin.'),
            'sLoadingRecords'   =>   trans('admin.sLoadingRecords'),
            'oPaginate' =>   [
                'sFirst'            =>   trans('admin.sFirst'),
                'sLast'             =>   trans('admin.sLast'),
                'sNext'             =>   trans('admin.sNext'),
                'sPrevious'         =>   trans('admin.sPrevious')
            ],
            'oAria'             =>   [
                'sSortAscending'    =>   trans('admin.sSortAscending'),
                'sSortDescending'   =>   trans('admin.sSortDescending')
            ],
        ];
    }
}


///////////// image validation ///////////////////
if(!function_exists('v_image'))
{
    function v_image($ext = null)
    {
        if($ext === null):
            return 'image|mimes:jpg,jpeg,gif,png,pmb';
        else:
            return 'image|mimes:' . $ext;

        endif;

    }
}


///////////// image validation ///////////////////
