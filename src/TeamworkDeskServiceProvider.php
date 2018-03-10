<?php namespace NigelHeap\TeamworkDesk;

use GuzzleHttp\Client as Guzzle;
use Illuminate\Support\ServiceProvider;

class TeamworkDeskServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('nigelheap.teamworkDesk', function($app)
        {
            $client = new \NigelHeap\TeamworkDesk\Client(new Guzzle,
                $app['config']->get('services.teamwork-desk.key'),
                $app['config']->get('services.teamwork-desk.url'),
                $app['config']->get('services.teamwork-desk.version', 'v1')
            );

            return new \NigelHeap\TeamworkDesk\Factory($client);
        });

        $this->app->bind('NigelHeap\TeamworkDesk\Factory', 'nigelheap.teamworkDesk');
    }

}