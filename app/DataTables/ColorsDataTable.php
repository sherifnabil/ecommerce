<?php

namespace App\DataTables;

use App\model\Color;
use Yajra\DataTables\Services\DataTable;

class ColorsDataTable extends DataTable
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
            ->addColumn('checkbox', 'admin.colors.btn.checkbox')
            ->addColumn('edit', 'admin.colors.btn.edit')
            ->addColumn('delete', 'admin.colors.btn.delete')
            ->addColumn('color', 'admin.colors.btn.color')
            ->rawColumns([
                'edit',
                'delete',
                'color',
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
        return Color::query();
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
                                    'text'      =>    '<i class="fa fa-plus" ></i> ' . trans('admin.add') ,
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
                                    this.api().columns([ 2, 3,4]).every(function () {
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
                'name'          =>  'name_ar',
                'data'          =>  'name_ar',
                'title'         =>  trans('admin.name_ar'),

            ],
            [
                'name'          =>  'name_en',
                'data'          =>  'name_en',
                'title'         =>  trans('admin.name_en'),

            ],
            [
                'name'          =>  'color',
                'data'          =>  'color',
                'title'         =>  trans('admin.color'),

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
        return 'Color_' . date('YmdHis');
    }
}
