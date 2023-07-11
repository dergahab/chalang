<?php

namespace App\Helpers;

use Illuminate\Support\Collection;

class CmsSidebar extends Singleton
{
    /**
     * @var Collection
     */
    private $list;

    protected function __construct()
    {
        parent::__construct();
        $this->list = collect([]);
    }

    /**
     * @return Collection
     */
    public function getItems()
    {
        return $this->list;
    }

    /**
     * @throws \Exception
     */
    public function addItem(array $item): void
    {
        $menuItem = $this->validateInputItems($item);

        $this->list->add($menuItem);
    }

    /**
     * @throws \Exception
     */
    public function addItems(array $items): void
    {
        foreach ($items as $item) {
            $this->addItem($item);
        }
    }

    /**
     * @param  bool  $isRoot
     *
     * @throws \Exception
     */
    private function validateInputItems(array $item, $isRoot = true): Collection
    {
        try {
            $menuItem = collect([
                'icon' => array_key_exists('icon', $item) ? $item['icon'] : '<i class="fas fa-dot-circle"></i>',
                'title' => $item['title'],
                'route' => array_key_exists('route', $item) ? $item['route'] : null,
                'params' => array_key_exists('params', $item) ? $item['params'] : null,
                'can' => array_key_exists('can', $item) ? $item['can'] : '*',
                'inner' => array_key_exists('inner', $item) ? $item['inner'] : null,
                'is_active_route' => array_key_exists('route', $item) && request()->routeIs($item['route']),
            ]);

            $menuItem->put('showFlag', $menuItem['can'] == '*' ? true : '*');

            if ($isRoot and array_key_exists('inner', $item)) {
                $innerMenu = collect();
                $innerRoutes = [];
                foreach ($item['inner'] as $innerItem) {
                    $menuItem['showFlag'] = false;
                    $innerMenu->add($this->validateInputItems($innerItem, false));
                    array_push($innerRoutes, $innerItem['route']);
                }

                if ($innerMenu->where('showFlag', true)->first()) {
                    $menuItem['showFlag'] = true;
                }

                $menuItem->put('inner', $innerMenu);
                $menuItem->put('isActiveGroup', request()->routeIs($innerRoutes));
            }

            return $menuItem;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function clearItems(): void
    {
        $this->list = collect([]);
    }
}
