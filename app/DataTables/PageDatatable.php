<?php

namespace App\DataTables;

use App\Models\Page;
use Illuminate\Database\Eloquent\Model as LaravelModel;
use yajra\Datatables\Services\DataTable;

class PageDatatable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \yajra\Datatables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $datatables = datatables($query);

        return $datatables
            ->addColumn('checkbox', function ($model) {
                return '<input type="checkbox" name="ids[]" value="' . $model->id . '" class="item-checkbox">';
            })
            ->addColumn('action', function ($model) {
                return view('admin.partials.actions', [
                    'model' => $model,
                    'type' => 'page',
                    'showRoute' => route('admin.pages.show', $model->id),
                    'editRoute' => route('admin.pages.edit', $model->id),
                    'deleteRoute' => route('admin.pages.destroy', $model->id),
                ])->render();
            })
            ->editColumn('title', function ($model) {
                return '<strong>' . $model->title . '</strong>';
            })
            ->editColumn('slug', function ($model) {
                return '<code>' . $model->slug . '</code>';
            })
            ->editColumn('status', function ($model) {
                $badgeClass = $model->status === 'active' ? 'success' : 'secondary';
                return '<span class="badge bg-' . $badgeClass . '">' . ($model->status === 'active' ? __('active') : __('inactive')) . '</span>';
            })
            ->editColumn('created_at', function ($model) {
                return $model->created_at ? $model->created_at->format('d/m/Y H:i') : '-';
            })
            ->rawColumns(['checkbox', 'action', 'title', 'slug', 'status'])
            ->setRowId('id');
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $model = new Page();
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \yajra\Datatables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('page-datatable-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->buttons(
                ['excel', 'csv', 'pdf', 'print', 'reset', 'reload',
                [
                    'text' => __('delete_selected'),
                    'className' => 'btn-danger delete-selected disabled',
                    'action' => 'function(e, dt, node, config) {
                        if(config.default) {
                            bulkDelete("App\\Models\\Page");
                        }
                    }',
                ]
            ])
            ->parameters([
                'language' => [
                    'url' => url("/backend/lang/json/{$this->getLanguage()}"),
                ],
                'fixedColumns' => true,
                'autoWidth' => false,
                'params' => ['_token' => csrf_token()],
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
            ['data' => 'checkbox', 'name' => 'checkbox', 'title' => '<input type="checkbox" class="select-all-checkbox" id="select-all">', 'orderable' => false, 'searchable' => false, 'width' => '50px'],
            ['data' => 'id', 'name' => 'id', 'title' => '#', 'searchable' => false, 'width' => '40px'],
            ['data' => 'title', 'name' => 'title', 'title' => __('title'), 'width' => '150px'],
            ['data' => 'slug', 'name' => 'slug', 'title' => __('slug'), 'width' => '120px'],
            ['data' => 'status', 'name' => 'status', 'title' => __('status'), 'width' => '80px'],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => __('created_at'), 'width' => '120px'],
            ['data' => 'action', 'name' => 'action', 'title' => __('action'), 'searchable' => false, 'orderable' => false, 'width' => '120px'],
        ];
    }

    /**
     * Get filename for export file.
     *
     * @return string
     */
    protected function filename()
    {
        return 'page_' . date('Y_m_d_H_i_s');
    }

    /**
     * Get language.
     *
     * @return string
     */
    protected function getLanguage()
    {
        return session('lang', config('app.locale'));
    }
}