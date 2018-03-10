<?php  namespace NigelHeap\TeamworkDesk;

use NigelHeap\TeamworkDesk\Traits\RestfulTrait;

class Customers extends AbstractObject {

    use RestfulTrait;

    protected $wrapper = 'customer';

    protected $endpoint = 'customers';

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