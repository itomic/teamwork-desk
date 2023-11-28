<?php  namespace NigelHeap\TeamworkDesk;

use NigelHeap\TeamworkDesk\Traits\RestfulTrait;

class Companies extends AbstractObject {

    use RestfulTrait;

    protected $wrapper  = 'companies';

    protected $endpoint = 'companies';

    /**
     * Search companies
     * GET /companies/search.json
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
            'filter',
            'searchType',
            'pageSize',
        ]);

        return $this->client->get("$this->endpoint", $args)->response();
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
