<?php  namespace NigelHeap\TeamworkDesk;

use NigelHeap\TeamworkDesk\Traits\RestfulTrait;

class Tickets extends AbstractObject {

    use RestfulTrait;

    protected $wrapper  = 'ticket';

    protected $endpoint = 'tickets';

    /**
     * Search Tickets
     * GET /tickets/search.json
     *
     * @param null $args
     *
     * @return mixed
     */
    public function search($args = null)
    {
        $this->areArgumentsValid($args, [
            'search',
            'page',
            'searchType',
            'pageSize',
            'lastUpdated',
            'inboxIds',
            'assignedTo',
            'tagIds',
            'statuses',
            'sortBy',
            'sortDir',
        ]);

        return $this->client->get("$this->endpoint/search", $args)->response();
    }

    /**
     * Links to above to fit ease of use
     *
     * @param null $args
     * @return mixed
     */
    public function all($args = null){
        return $this->search($args);
    }


}