<?php

namespace App\DataTables;

use App\Models\Step;
use Illuminate\Database\Eloquent\Model as LaravelModel;
use yajra\Datatables\Services\DataTable;

class StepDatatable extends DataTable
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
                    'type' => 'step',
                    'showRoute' => route('admin.step.show', $model->id),
                    'editRoute' => route('admin.step.edit', $model->id),
                    'deleteRoute' => route('admin.step.destroy', $model->id),
                ])->render();
            })
            ->editColumn('image', function ($model) {
                if ($model->image) {
                    return '<img src="' . asset('storage/' . $model->image) . '" alt="' . $model->title . '" style="max-width: 80px; border-radius: 4px;">';
                }
                return '<span class="text-muted">-</span>';
            })
            ->editColumn('position', function ($model) {
                return '<span class="badge bg-primary">' . ($model->position ?? '-') . '</span>';
            })
            ->editColumn('title', function ($model) {
                return $model->title ? strip_tags($model->title) : '-';
            })
            ->editColumn('description', function ($model) {
                return $model->description ? \Str::limit(strip_tags($model->description), 50) : '-';
            })
            ->editColumn('created_at', function ($model) {
                return $model->created_at ? $model->created_at->format('d/m/Y H:i') : '-';
            })
            ->rawColumns(['checkbox', 'action', 'image', 'position'])
            ->setRowId('id');
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $model = new Step();
        return $model->newQuery()->with('translations');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \yajra\Datatables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('step-datatable-table')
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
                            bulkDelete("step");
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
            ['data' => 'image', 'name' => 'image', 'title' => __('image'), 'searchable' => false, 'orderable' => false, 'width' => '100px'],
            ['data' => 'title', 'name' => 'title', 'title' => __('title'), 'width' => '150px'],
            ['data' => 'step', 'name' => 'translations.step', 'title' => __('step_number'), 'width' => '80px'],
            ['data' => 'position', 'name' => 'position', 'title' => __('position'), 'width' => '80px'],
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
        return 'step_' . date('Y_m_d_H_i_s');
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