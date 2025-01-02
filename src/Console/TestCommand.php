<?php

namespace Controller\Console;

use Illuminate\Console\Command;
use Controller\ControllerClient;

class TestController extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'controller:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test exception to controller.dev';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $apiKey = config('controller.api_key');
        $endpoint = config('controller.endpoint');

        if (!$apiKey || !$endpoint) {
            $this->error('API key or endpoint is not configured in your .env file.');
            return Command::FAILURE;
        }

        $this->info('Sending a test exception to controller.dev...');

        try {
            $client = new ControllerClient($apiKey, $endpoint);
            $client->captureException(new \Exception('Test exception from controller.dev command'), [
                'context' => 'Testing integration',
            ]);

            $this->info('Test exception sent successfully.');
            return Command::SUCCESS;
        } catch (\Throwable $e) {
            $this->error('Failed to send the test exception: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
