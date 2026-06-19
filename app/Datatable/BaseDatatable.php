<?php

namespace App\Datatable;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;

abstract class BaseDatatable
{
    /**
     * @var array
     */
    private $tableColumns;

    /**
     * @var string[]
     */
    private $actionBladeView;

    /**
     * @var Model
     */
    private $baseModel;

    /**
     * @var mixed
     */
    private $searchInput;

    /**
     * @var array
     */
    protected $preDefinedDateColumns = [
        'created_at',
        'updated_at',
    ];

    public function __construct($baseModel, $tableColumns, $actionBladeView)
    {
        $this->baseModel = $baseModel;
        $this->tableColumns = $tableColumns;
        if (! is_array($actionBladeView)) {
            $this->actionBladeView = [
                'action' => [
                    'title' => 'Action',
                    'view' => $actionBladeView,
                ],
            ];
        } else {
            $this->actionBladeView = $actionBladeView;
        }
    }

    protected function setTableColumns($table)
    {
        $this->tableColumns = $table;
    }

    abstract protected function query(): Builder;

    protected function baseQueryScope(): Builder
    {
        return $this->baseModel::query();
    }

    public function datatable(): JsonResponse
    {

        if ($this->isRequestColumns()) {
            return $this->columns();
        }
        $requestQuery = $this->getRequestQuery();

        $allRecordsCount = $this->baseQueryScope()->count();
        $filteredRecordsCount = $this->query()->count();
        $mainQuery = $this->query();
        $mainQueryCustom = $mainQuery;

        $response = [];

        if (request()->has('sumTotal')) {
            // Check if function exists or safe fallback
            $total = function_exists('getCacheTotal') ? getCacheTotal() : ['try_amount' => 0, 'azn_amount' => 0];
            $response['sumTotal'] = (float) $total['try_amount'];
            $response['sumTotalAzn'] = (float) $total['azn_amount'];
        }

        if ($requestQuery['perPage'] != '-1') {
            $mainQuery->skip($requestQuery['startFrom']);
            $mainQuery->take($requestQuery['perPage']);
        }

        $table = $mainQuery->getModel()->getTable();
        $column = $requestQuery['columnName'];
        
        // Only apply orderBy if the column exists in the main table and is not a virtual column
        if (\Illuminate\Support\Facades\Schema::hasColumn($table, $column)) {
            $mainQuery->orderBy($table.'.'.$column, $requestQuery['columnSort']);
        } else {
            // Default sort to ID if the requested column is not sortable in DB
            $mainQuery->orderBy($table.'.id', 'desc');
        }

        if ($requestQuery['request']->has('sumFiltered')) {
            $response['sumfiltered'] = $mainQuery->take($requestQuery['perPage'])->get()->sum('amount');
            $response['sumfilteredAzn'] = $mainQuery->take($requestQuery['perPage'])->get()->sum('azn');
        }

        if (request()->has('dumpsql')) {
            \DB::enableQueryLog();
            $mainQuery->get();
            dd(\DB::getQueryLog());
        }
        $response['draw'] = $requestQuery['draw'];
        $response['recordsTotal'] = $allRecordsCount;
        $response['recordsFiltered'] = $filteredRecordsCount;
        $response['data'] = $this->processRecords($mainQuery->get());

        // dd($response);

        return response()->json($response);
    }

    protected function processRecords(Collection $records): array
    {

        $iterator = ($_GET['start'] ?? 0) + 1;

        return $records->map(function ($item) use (&$iterator) {
            $item['order_number'] = $iterator++;
            $data = [];
            
            // Add Checkbox Data
            $data['checkbox'] = '<div class="form-check"><input type="checkbox" class="form-check-input bulk-item" value="'.$item->id.'"><label class="form-check-label"></label></div>';

            // Add Status Toggle if column exists
            if (isset($item->status)) {
                $checked = $item->status ? 'checked' : '';
                $data['status'] = '<div class="form-check form-switch">
                    <input class="form-check-input status-toggle" type="checkbox" role="switch" 
                        data-id="'.$item->id.'" 
                        data-model="'.get_class($item).'" 
                        '.$checked.'>
                </div>';
            }

            foreach (array_keys($this->tableColumns) as $key) {
                $data[$this->sanitizeColumn($key)] = $this->formatPredefinedColumns($key, data_get($item, $key));
            }

            if (count($this->actionBladeView)) {
                foreach ($this->actionBladeView as $key => $view) {
                    if (array_key_exists('view', $view)) {
                        $data[$key] = View::make($view['view'], compact('item'))->render();
                    } else {
                        $data[$key] = $view['text'];
                    }
                }
            }

            return $data;
        })->toArray();
    }

    protected function formatPredefinedColumns($column, $value)
    {
        //date
        if (in_array($column, $this->preDefinedDateColumns)) {
            return Carbon::parse($value)->format('Y-m-d H:i');
        }

        return $value;
    }

    protected function isRequestColumns(): bool
    {
        return request()->has('show_columns');
    }

    protected function getRequestQuery(): array
    {
        $columnIndex_arr = request('order');
        $columnName_arr = request('columns');
        $order_arr = request('order');
        $search_arr = request('search');

        $this->searchInput = $search_arr['value'];
        $columnIndex = $columnIndex_arr[0]['column']; // Column index

        return [
            'request' => request(),
            'draw' => request('draw', 0),
            'startFrom' => request('start', 0),
            'perPage' => request('length'),
            'columnName' => $columnName_arr[$columnIndex]['data'],
            'columnSort' => $order_arr[0]['dir'],
            'searchInput' => $this->searchInput,
            'whereForDate' => json_decode(request('where', '{}'), true),
            'global_where' => json_decode(request('global_where', '{}'), true),
        ];
    }

    protected function getSearchInput()
    {
        return $this->searchInput;
    }

    protected function sanitizeColumn(string $column)
    {
        return str_replace('.', '__', $column);
    }

    protected function columns(): JsonResponse
    {
        $columns = [];

        // Add Checkbox Column
        $columns[] = [
            'data' => 'checkbox',
            'title' => '<div class="form-check"><input type="checkbox" class="form-check-input" id="select-all"><label class="form-check-label" for="select-all"></label></div>',
            'orderable' => false,
            'searchable' => false,
            'width' => '40px',
            'className' => 'text-center'
        ];

        // Check if model has status column
        $modelInstance = new $this->baseModel;
        if (\Illuminate\Support\Facades\Schema::hasColumn($modelInstance->getTable(), 'status')) {
            $columns[] = [
                'data' => 'status',
                'title' => 'Status',
                'orderable' => true,
                'width' => '80px',
                'className' => 'text-center'
            ];
        }

        foreach ($this->tableColumns as $key => $value) {
            $column = $key;
            $isOrderable = true;

            if (is_array($value)) {
                $title = array_key_exists('orderable', $value) ? $value['title'] : $column;
                $isOrderable = array_key_exists('orderable', $value) ? $value['orderable'] : true;
            } else {
                $title = $value;
            }

            $columns[] = [
                'data' => $this->sanitizeColumn($column),
                'title' => $title,
                'orderable' => $isOrderable,
            ];
        }

        if ($this->actionBladeView) {
            foreach ($this->actionBladeView as $key => $item) {
                $columns[] = [
                    'data' => $key,
                    'title' => $item['title'],
                    'orderable' => false,
                ];
            }
        }

        return response()->json($columns);
    }
}
