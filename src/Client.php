<?php  namespace NigelHeap\TeamworkDesk;

use GuzzleHttp\Client as Guzzle;
use NigelHeap\TeamworkDesk\Contracts\RequestableInterface;

class Client implements RequestableInterface {

    /**
     * @var GuzzleHttp\Client
     */
    protected $client;

    /**
     * @var GuzzleHttp\Request
     */
    protected $request;

    /**
     * @var GuzzleHttp\Response
     */
    protected $response;

    /**
     * API Key
     *
     * The custom API key provided by Teamwork
     *
     * @var string
     */
    protected $key;

    /**
     * URL
     *
     * The URL that is set to query the Teamwork API.
     * This is the account URL used to access the project
     * management system. This is passed in on construct.
     *
     * @var string
     */
    protected $url;

    /**
     *
     * The API version from teamwork desk
     * As of build time it is using v1
     *
     * @var string
     */
    private $version;

    /**
     * Currently this package doesn't support XML
     * but overtime this would be part of that support
     *
     * @var string
     */
    protected $dataFormat = 'json';


    /**
     * @param Guzzle $client
     * @param        $key
     * @param        $url
     * @param string $version
     */
    public function __construct(Guzzle $client, $key, $url, $version = 'v1')
    {
        $this->client = $client;
        $this->key = $key;
        $this->url = $url;
        $this->version = $version;
    }

    /**
     * Get
     *
     * @param $endpoint
     *
     * @return Client
     */
    public function get($endpoint, $query = null)
    {
        $this->buildRequest($endpoint, 'GET', [], $query);

        return $this;
    }

    /**
     * Post
     *
     * @param $endpoint
     * @param $data
     *
     * @return Client
     */
    public function post($endpoint, $data)
    {
        return $this->buildRequest($endpoint, 'POST', $data);
    }

    /**
     * Put
     *
     * @param $endpoint
     * @param $data
     *
     * @return Client
     */
    public function put($endpoint, $data)
    {
        return $this->buildRequest($endpoint, 'PUT', $data);
    }

    /**
     * Delete
     *
     * @param $endpoint
     *
     * @return Client
     * @internal param $data
     *
     */
    public function delete($endpoint)
    {
        return $this->buildRequest($endpoint, 'DELETE');
    }

    /**
     * Build Request
     *
     * build up request including authentication, body,
     * and string queries if necessary. This is where the bulk
     * of the data is build up to connect to Teamwork with.
     *
     * @param        $endpoint
     * @param string $action
     * @param array $params
     *
     * @param null $query
     * @return $this
     */
    public function buildRequest($endpoint, $action, $params = [], $query = null)
    {

        $options = [];

        if(str_contains($this->version, 'v2')){
            $options['headers']['Authorization'] = 'Bearer ' . $this->key;
        } else {
            $options['auth'] = [$this->key, 'X'];
        }

        if (count($params) > 0)
        {
            $options['form_params'] = json_encode($params);
        }

        if ($query != null)
        {
            $options['query'] = $query;
        }

        $this->request = $this->client->request(
            $action,
            $this->buildUrl($endpoint),
            $options
        );


        return $this;
    }

    /**
     * Response
     *
     * this send the request from the built response and
     * returns the response as a JSON payload
     */
    public function response()
    {
        //$this->response = $this->client->send($this->request);

        $this->response = $this->request->getBody()->getContents();

        return json_decode($this->response, true);
    }


    /**
     * Build Url
     *
     * builds the url to make the request to Teamwork with
     * and passes it into Guzzle. Also checks if trailing slash
     * is present.
     *
     * @param $endpoint
     *
     * @return string
     */
    public function buildUrl($endpoint)
    {
        if (filter_var($endpoint, FILTER_VALIDATE_URL))
        {
            return $endpoint . '.' . $this->dataFormat;
        }

        if (substr($this->url, -1) != '/')
        {
            $this->url = $this->url . '/';
        }

        if($this->version === 'v2'){
            $version = 'api/' . $this->version;
        } else {
            $version = $this->version;
        }

        return $this->url . 'desk/' . $version . '/' . $endpoint . '.' . $this->dataFormat;
    }

    /**
     * Build Query String
     *
     * if a query string is needed it will be built up
     * and added to the request. This is only used in certain
     * GET requests
     *
     * @param $query
     */
    public function buildQuery($query)
    {

        $q = $this->request->getQuery();

        foreach ($query as $key => $value)
        {
            $q[$key] = $value;
        }
    }

    /**
     * Get Request
     *
     * @return mixed
     */
    public function getRequest()
    {
        return $this->request;
    }
}
