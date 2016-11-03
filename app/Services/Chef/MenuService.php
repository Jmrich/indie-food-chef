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
        $dishes = collect($data['dishes']);

        $sync_list = [];

        $dishes->each(function ($dish) use (&$sync_list) {
            $sync_list[$dish['id']] = [
                'start_date' => $dish['start_date'],
                'end_date' => $dish['end_date'],
                'starting_quantity' => $dish['starting_quantity'],
                'quantity_remaining' => $dish['quantity_remaining']
            ];
        });

        $menu->dishes()->sync($sync_list);

        // Lets check if they want this menu to be the active menu
        /*if ($data['menu']['is_active'] == 1) {
            $menus = Menu::where('kitchen_id', getKitchen()->id)
                ->where('is_active', 1)
                ->where('id', '<>', $menu->id)
                ->get();

            $menus->each(function ($menu) {
                // update all menus to be inactive
                $menu->forceFill(['is_active' => 0])->save();
            });
        }*/

        // Finally lets update the menu
        $menu->forceFill([
            'name' => $data['menu']['name'],
            'description' => $data['menu']['description'],
            'is_active' => $data['menu']['is_active'],
            'is_archived' => 0//$data['menu']['is_archived']
        ])->save();
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
}