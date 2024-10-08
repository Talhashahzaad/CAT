<?php

namespace App\DataTables;

use App\Models\Category;
use App\Models\Package;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PackageDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($query) {
                $edit = '<a href="' . route('admin.package.edit', $query->id) . '" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>';
                $delete = '<a href="' . route('admin.package.destroy', $query->id) . '" class="delete-item btn btn-sm btn-danger ml-2"><i class="fas fa-trash"></i></a>';

                return $edit . $delete;
            })
            ->editColumn('category', function ($package) {
                if (is_numeric($package->category)) {
                    $category = Category::find($package->category);
                    return $category ? $category->name : 'N/A';
                } elseif ($package->category instanceof Category) {
                    return $package->category->name;
                } else {
                    return 'N/A';
                }
            })
            ->addColumn('status', function ($query) {
                if ($query->status == 1) {
                    return "<span class='badge badge-primary'>Active</span>";
                } else {
                    return "<span class='badge badge-danger'>Inactive</span>";
                }
            })
            ->rawColumns(['action', 'status', 'category'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Package $model): QueryBuilder
    {
        return $model->orderBy('id', 'desc');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('package-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [

            Column::make('id'),
            Column::make('name'),
            Column::make('category'),
            Column::make('price_type'),
            Column::make('available_for'),
            Column::make('status'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(150)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Package_' . date('YmdHis');
    }
}