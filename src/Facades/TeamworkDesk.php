<?php  namespace NigelHeap\TeamworkDesk\Facades;

use Illuminate\Support\Facades\Facade;

class TeamworkDesk extends Facade {
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return 'nigelheap.teamworkDesk';
    }
}