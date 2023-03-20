<?php

namespace App\Console\Commands;

use App\Services\SwoogoStatsService;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

class SwoogoStatsCommand extends Command {

    protected $statsService;

    public function __construct(SwoogoStatsService $statsService)
    {
        parent::__construct();
        $this->statsService = $statsService;
    }

    /**
     * Set the configuration for the SwoogoStats command
     *  Configuration includes:
     *  - name
     *  - description
     *  - options {eventID, api key, api secret}
     */
    protected function configure()
    {
        $this->setName('swoogo:stats')
             ->setDescription('Reads from a Swoogo API to accept content about Swoogo Event’s Sessions and analyzes their content to generate some basic statistics.')
             ->addOption('event_id', 'e', InputOption::VALUE_REQUIRED, 'The event ID being scanned')
             ->addOption('key', 'k', InputOption::VALUE_REQUIRED, 'The API key')
             ->addOption('secret', 's', InputOption::VALUE_REQUIRED, 'The API secret')
             ->addOption('aggregate', 'a', InputOption::VALUE_NONE, 'Retrieve summary');
    }    

    /**
     * Retrieve value of the option from the command arguments or the environment variable if not sent as an argument
     * 
     * @param string $optionName The name of the option
     * 
     * @return string option The value of the option
     */
    protected function getOption($optionName)
    {
        return $this->option($optionName) ?? env('SWOOGO_' . strtoupper($optionName));
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(SwoogoStatsService $dataHandler)
    {
        // Check if switch exists, else get from env variables
        $eventId = $this->getOption('event_id');
        $apiKey = $this->getOption('key');
        $apiSecret = $this->getOption('secret');

        if (!$eventId || !$apiKey || !$apiSecret) {
            $this->error('Missing required arguments or environment variables.');
            return;
        }

        // Handle all logic in the Service layer.
        if($this->option('aggregate')) {
            $stats = $dataHandler->getAggregateStats($eventId);
        } else {
            $stats = $dataHandler->processSwoogoStats($eventId, $apiKey, $apiSecret);
        }

        // Print the results to standard output in JSON format
        $this->line(json_encode($stats, JSON_PRETTY_PRINT));        
    }

}