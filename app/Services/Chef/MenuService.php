<?php
/**
 * Created by PhpStorm.
 * User: jmrichardsonjr
 * Date: 9/10/16
 * Time: 3:40 PM
 */

namespace App\Services\Chef;


use App\Menu;
use App\Section;

class MenuService
{
    /**
     * Update the menu and the sections
     *
     * @param Menu $menu
     * @param array $data
     */
    public function update($menu, array $data)
    {
        $sync_list = [];

        collect($data['dishes'])->each(function ($dish) use (&$sync_list) {
            $sync_list[$dish['id']] = [
                'start_date' => $this->formatDate($dish['start_date']),
                'end_date' => $this->formatDate($dish['end_date']),
                'starting_quantity' => $dish['starting_quantity'],
                'quantity_remaining' => $dish['quantity_remaining']
            ];
        });

        $menu->dishes()->sync($sync_list);
    }

    /**
     * Store the menu
     *
     * @param array $data
     * @return Menu
     */
    public function store(array $data)
    {
        $menu = (new Menu)->forceFill([
            'name' => $data['name'],
            'description' => $data['description']
        ]);

        return getChef()->kitchen->menus()->save($menu);
    }

    /**
     * Convert date from MM-DD-YYYY to YYYY-MM-DD
     *
     * @param $date
     * @return string
     */
    protected function formatDate($date)
    {
        $date = explode('-', $date);

        $month = $date[0];

        $day = $date[1];

        $year = $date[2];

        return implode('-', [$year, $month, $day]);
    }
}