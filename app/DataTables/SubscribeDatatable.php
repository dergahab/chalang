<?php

namespace App\DataTables;

use App\Models\Subscribe;
use Illuminate\Database\Eloquent\Model as LaravelModel;
use yajra\Datatables\Services\DataTable;

class SubscribeDatatable extends DataTable
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
                    'type' => 'subscribe',
                    'showRoute' => route('admin.subscribe.show', $model->id),
                    'editRoute' => route('admin.subscribe.edit', $model->id),
                    'deleteRoute' => route('admin.subscribe.destroy', $model->id),
                ])->render();
            })
            ->editColumn('mail', function ($model) {
                return '<a href="mailto:' . $model->mail . '">' . $model->mail . '</a>';
            })
            ->editColumn('website', function ($model) {
                if ($model->website) {
                    return '<a href="' . $model->website . '" target="_blank" class="text-decoration-none">
                        <i class="fas fa-globe"></i> ' . \Str::limit($model->website, 30) . '
                    </a>';
                }
                return '<span class="text-muted">-</span>';
            })
            ->editColumn('created_at', function ($model) {
                return $model->created_at ? $model->created_at->format('d/m/Y H:i') : '-';
            })
            ->rawColumns(['checkbox', 'action', 'mail', 'website'])
            ->setRowId('id');
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $model = new Subscribe();
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
            ->setTableId('subscribe-datatable-table')
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
                            bulkDelete("App\\Models\\Subscribe");
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
            ['data' => 'mail', 'name' => 'mail', 'title' => __('email'), 'width' => '200px'],
            ['data' => 'website', 'name' => 'website', 'title' => __('website'), 'width' => '200px'],
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
        return 'subscribe_' . date('Y_m_d_H_i_s');
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