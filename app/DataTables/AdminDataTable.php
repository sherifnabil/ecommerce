<?php

namespace App\DataTables;

use App\Admin;
use Yajra\DataTables\Services\DataTable;

class AdminDataTable extends DataTable
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
            ->addColumn('edit', 'admin.admins.btn.edit')
            ->addColumn('delete', 'admin.admins.btn.delete')
            ->rawColumns([
                'edit',
                'delete'
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
        return Admin::query();
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
                        'lengthMenu'    =>  [[10, 25, 50, 100, -1], [10, 25, 50, 'All Records']],
                        'buttons'       =>  [

                                [
                                    'className' =>    'btn btn-primary',
                                    'text'      =>    '<i class="fa fa-plus" ></i> ' . trans('admin.newadmin') ,
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
                                    'extend'    =>    'reload',
                                    'className' =>    'btn btn-default',
                                    'text'      =>    '<i class="fa fa-refresh" ></i>',
                                ],
                            ],
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
                'name'          =>  'id',
                'data'          =>  'id',
                'title'         =>  'ID',
            ],
            [
                'name'          =>  'name',
                'data'          =>  'name',
                'title'         =>  'Name',
            ],
            [
                'name'          =>  'email',
                'data'          =>  'email',
                'title'         =>  'Email',
            ],
            [
                'name'          =>  'created_at',
                'data'          =>  'created_at',
                'title'         =>  'Created at',
            ],
            [
                'name'          =>  'updated_at',
                'data'          =>  'updated_at',
                'title'         =>  'Updated at',
            ],
            [
                'name'          =>  'edit',
                'data'          =>  'edit',
                'title'         =>  'Edit',
                'orderable'     =>  false,
                'searchable'    =>  false,
                'exportable'    =>  false,
                'printable'     =>  false,
            ],
            [
                'name'          =>  'delete',
                'data'          =>  'delete',
                'title'         =>  'Delete',
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
        return 'Admin_' . date('YmdHis');
    }
}
