<?php

namespace App\DataTables;

use App\model\City;
use Yajra\DataTables\Services\DataTable;

class CityDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
            ->addColumn('checkbox', 'admin.cities.btn.checkbox')
            ->addColumn('edit', 'admin.cities.btn.edit')
            ->addColumn('delete', 'admin.cities.btn.delete')
            ->rawColumns([
                'edit',
                'delete',
                'checkbox',

            ]);
    }



    /**
     * Get query source of dataTable.
     *
     * @param \App\Admin $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return City::query()->with('country_id')->select('cities.*');    /////// the .* is for choosing all the records
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    // ->addAction(['width' => '80px'])    // commenting the add actions to add custom actions in dataTable method as a rowColumns which is showing the actoin in the table
                    // ->parameters($this->getBuilderParameters());
                    ->parameters([

                        'dom'           =>  'Blfrtip',
                        'lengthMenu'    =>  [[10, 25, 50, 100 ], [10, 25, 50, trans('admin.all_records')]],
                        'buttons'       =>  [

                                [
                                    'className' =>    'btn btn-primary',
                                    'text'      =>    '<i class="fa fa-plus" ></i> ' . trans('admin.create_cities') ,
                                    'action'    =>    "function() {

                                                            window.location.href = '" .\URL::current() . "/create';
                                                        }",
                                ],
                                [
                                    'extend'    =>    'print',
                                    'className' =>    'btn btn-success',
                                    'text'      =>    '<i class="fa fa-print" ></i>',
                                ],
                                [
                                    'extend'    =>    'csv',
                                    'className' =>    'btn btn-warning',
                                    'text'      =>    '<i class="fa fa-file" ></i> ' . trans('admin.exportcsv'),
                                ],
                                [
                                    'extend'    =>    'excel',
                                    'className' =>    'btn btn-info',
                                    'text'      =>    '<i class="fa fa-download" ></i> '  . trans('admin.exportexcel'),
                                ],
                                [
                                    'className' =>    'btn btn-danger delBtn',
                                    'text'      =>    '<i class="fa fa-trash" ></i> ',
                                ],
                                [
                                    'extend'    =>    'reload',
                                    'className' =>    'btn btn-default',
                                    'text'      =>    '<i class="fa fa-refresh" ></i>',
                                ],
                            ],
                            'initComplete'      =>     'function () {
                                    this.api().columns([ 2, 3, 4]).every(function () {
                                        var column = this;
                                        var input = document.createElement("input");
                                        $(input).appendTo($(column.footer()).empty()).on(\'keyup\', function()
                                        {
                                            column.search($(this).val(), false, false, true).draw();
                                        });
                                    });
                            }',

                            'language'          =>  datatableLang(),
                        ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            [
                'name'          =>  'checkbox',
                'data'          =>  'checkbox',
                'title'         =>  '<input type="checkbox" class="check_all" onclick="check_all()" />',
                'orderable'     =>  false,
                'searchable'    =>  false,
                'exportable'    =>  false,
                'printable'     =>  false,

            ],
            [
                'name'          =>  'id',
                'data'          =>  'id',
                'title'         =>  '#',

            ],
            [
                'name'          =>  'city_name_ar',
                'data'          =>  'city_name_ar',
                'title'         =>  trans('admin.city_name_ar'),

            ],
            [
                'name'          =>  'city_name_en',
                'data'          =>  'city_name_en',
                'title'         =>  trans('admin.city_name_en'),

            ],
            [
                'name'          =>  'country_id.country_name_' . session('lang'),
                'data'          =>  'country_id.country_name_' . session('lang'),
                'title'         =>  trans('admin.country_id'),

            ],

            [
                'name'          =>  'created_at',
                'data'          =>  'created_at',
                'title'         =>  trans('admin.created_at'),

            ],
            [
                'name'          =>  'updated_at',
                'data'          =>  'updated_at',
                'title'         =>  trans('admin.updated_at'),

            ],
            [
                'name'          =>  'edit',
                'data'          =>  'edit',
                'title'         =>  trans('admin.edit'),
                'orderable'     =>  false,
                'searchable'    =>  false,
                'exportable'    =>  false,
                'printable'     =>  false,
            ],
            [
                'name'          =>  'delete',
                'data'          =>  'delete',
                'title'         =>  trans('admin.delete'),
                'orderable'     =>  false,
                'searchable'    =>  false,
                'exportable'    =>  false,
                'printable'     =>  false,
            ],

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'City_' . date('YmdHis');
    }
}
