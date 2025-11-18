<?php

namespace App\Services;

use App\Models\Lang;
use App\Models\Tag;
use App\Models\TagTranslation;
use Illuminate\Support\Facades\DB;

class TagService
{
    protected $langs;

    public function __construct()
    {
        // Defer language loading to avoid blocking artisan commands
    }

    protected function getLangs()
    {
        if (!$this->langs) {
            $this->langs = Lang::all();
        }
        return $this->langs;
    }

    public function create($data)
    {
        $tag = Tag::create();

        return $this->createOrUpdate($tag, $data);
    }

    public function createOrUpdate($tag, $data)
    {
        DB::beginTransaction();
        try {
            foreach ($this->getLangs() as $lang) {
                if ($data['name'][$lang->lang]) {
                    TagTranslation::updateOrCreate(
                        [
                            'tag_id' => $tag->id,
                            'locale' => $lang->lang,
                        ],
                        [
                            'name' => $data['name'][$lang->lang],
                        ]
                    );
                }
            }
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();

            return $e->getMessage();
        }

    }
}
