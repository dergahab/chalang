<?php

namespace App\DataTables;

use App\Models\Socialmedia;
use Illuminate\Database\Eloquent\Model as LaravelModel;
use yajra\Datatables\Services\DataTable;

class SocialmediaDatatable extends DataTable
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
                    'type' => 'social_media',
                    'showRoute' => route('admin.social-media.show', $model->id),
                    'editRoute' => route('admin.social-media.edit', $model->id),
                    'deleteRoute' => route('admin.social-media.destroy', $model->id),
                ])->render();
            })
            ->editColumn('icon', function ($model) {
                if ($model->icon) {
                    return '<i class="' . $model->icon . ' fa-lg" style="font-size: 24px;"></i>';
                }
                return '<span class="text-muted">-</span>';
            })
            ->editColumn('name', function ($model) {
                return '<strong>' . $model->name . '</strong>';
            })
            ->editColumn('link', function ($model) {
                if ($model->link) {
                    return '<a href="' . $model->link . '" target="_blank" class="text-decoration-none">
                        <i class="fas fa-external-link-alt"></i> ' . \Str::limit($model->link, 30) . '
                    </a>';
                }
                return '<span class="text-muted">-</span>';
            })
            ->editColumn('is_published', function ($model) {
                return view('admin.partials.published_status', ['model' => $model, 'route' => 'admin.social-media.update'])->render();
            })
            ->editColumn('created_at', function ($model) {
                return $model->created_at ? $model->created_at->format('d/m/Y H:i') : '-';
            })
            ->rawColumns(['checkbox', 'action', 'icon', 'name', 'link', 'is_published'])
            ->setRowId('id');
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $model = new Socialmedia();
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
            ->setTableId('socialmedia-datatable-table')
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
                            bulkDelete("App\\Models\\Socialmedia");
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
            ['data' => 'icon', 'name' => 'icon', 'title' => __('icon'), 'searchable' => false, 'orderable' => false, 'width' => '80px'],
            ['data' => 'name', 'name' => 'name', 'title' => __('name'), 'width' => '120px'],
            ['data' => 'link', 'name' => 'link', 'title' => __('link'), 'width' => '200px'],
            ['data' => 'is_published', 'name' => 'is_published', 'title' => __('status'), 'width' => '80px'],
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
        return 'socialmedia_' . date('Y_m_d_H_i_s');
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