<?php 
namespace App\Datatable;

use App\Models\ContentText;
use Facade\Ignition\QueryRecorder\Query;
use Illuminate\Database\Eloquent\Builder;

Class ContentTextDatatable extends BaseDatatable{
    public function __construct() {
        parent::__construct(ContentText::class, [
            'id' => 'ID',
            'key' => 'Açar söz',
            'title_az' => 'Başlıq',
    
        ], [
        
            'actions' => [
                'title' => 'Əməliyyat',
                'view' => 'admin.pages.content_text.table_actions'
            ]
        ]);
    }

    protected function baseQueryScope(): Builder {
        return parent::baseQueryScope();
    }

    protected function query(): Builder {
        $query = $this->baseQueryScope();
    
        if ($this->getSearchInput()) {
            $query
                ->where('title_az', 'LIKE', '%'. $this->getSearchInput() .'%')
                ->orWhere('key', 'LIKE', '%'. $this->getSearchInput() .'%');
                
               
        }

        return $query;
    }
}