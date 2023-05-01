<?php


namespace App\Datatable;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;



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
        'updated_at'
    ];

    public function __construct($baseModel, $tableColumns, $actionBladeView)
    {
        $this->baseModel = $baseModel;
        $this->tableColumns = $tableColumns;
        if (!is_array($actionBladeView)) {
            $this->actionBladeView = [
                'action' => [
                    'title' => 'Action',
                    'view' => $actionBladeView
                ]
            ];
        } else $this->actionBladeView = $actionBladeView;
    }

    protected function setTableColumns($table)
    {
        $this->tableColumns = $table;
    }

    /**
     * @return Builder
     */
    protected abstract function query(): Builder;

    protected function baseQueryScope(): Builder
    {
        return $this->baseModel::query();
    }

    public function datatable(): JsonResponse
    {

        if ($this->isRequestColumns()) return $this->columns();
        $requestQuery = $this->getRequestQuery();

        $allRecordsCount = $this->baseQueryScope()->count();
        $filteredRecordsCount = $this->query()->count();
        $mainQuery          = $this->query();
        $mainQueryCustom    =  $mainQuery;

        $response = [];

        if (request()->has('sumTotal')) {
            $total                      = getCacshTotal();
            $response['sumTotal']       = (float)$total['try_amount'];
            $response['sumTotalAzn']    = (float)$total['azn_amount'];
        }

        if ($requestQuery['perPage'] != '-1') {
            $mainQuery->skip($requestQuery['startFrom']);
            $mainQuery->take($requestQuery['perPage']);
        }

        $mainQuery->orderBy($mainQuery->getModel()->getTable() . "." . $requestQuery['columnName'], $requestQuery['columnSort']);

        if ($requestQuery['request']->has('sumFiltered')) {
            $response['sumfiltered'] = $mainQuery->take($requestQuery['perPage'])->get()->sum("amount");
            $response['sumfilteredAzn'] = $mainQuery->take($requestQuery['perPage'])->get()->sum("azn");
        }

        if (request()->has('dumpsql')) {
            \DB::enableQueryLog();
            $mainQuery->get();
            dd(\DB::getQueryLog());
        }
        $response["draw"] = $requestQuery['draw'];
        $response["recordsTotal"] = $allRecordsCount;
        $response["recordsFiltered"] = $filteredRecordsCount;
        $response["data"] = $this->processRecords($mainQuery->get());

        // dd($response);

        return response()->json($response);
    }

    protected function processRecords(Collection $records): array
    {

        $iterator = ($_GET['start'] ?? 0) + 1;
        return $records->map(function ($item) use (&$iterator) {
            $item['order_number'] = $iterator++;
            $data = [];
            foreach (array_keys($this->tableColumns) as $key) {
                $data[$this->sanitizeColumn($key)] = $this->formatPredefinedColumns($key, data_get($item, $key));
            }

            if (count($this->actionBladeView)) {
                foreach ($this->actionBladeView as $key => $view) {
                    if (array_key_exists("view", $view)) {
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
            'global_where' => json_decode(request('global_where', '{}'), true)
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
                'orderable' => $isOrderable
            ];
        }

        if ($this->actionBladeView) {
            foreach ($this->actionBladeView as $key => $item) {
                $columns[] = [
                    'data' => $key,
                    'title' => $item['title'],
                    'orderable' => false
                ];
            }
        }

        return response()->json($columns);
    }
}
