<?php  namespace NigelHeap\TeamworkDesk;

use NigelHeap\TeamworkDesk\Traits\RestfulTrait;

class Inboxes extends AbstractObject {

    use RestfulTrait;

    protected $wrapper = 'inbox';

    protected $endpoint = 'inboxes';


    /**
     * GET /inboxes/{inbox_id}.json
     *
     * @param null $args
     *
     * @return mixed
     */
    public function find($args = null)
    {
        $this->areArgumentsValid($args, ['ticketCounts']);

        return $this->client->get("$this->endpoint/$this->id", $args)->response();
    }


}