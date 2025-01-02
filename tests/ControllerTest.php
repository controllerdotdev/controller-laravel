<?php

use Controller\ControllerClient;
use Controller\Exceptions\ControllerException;

it('uses .env values for API key and endpoint', function () {
    $client = new ControllerClient();
    expect($client)->toBeInstanceOf(ControllerClient::class);
    expect($client->endpoint)->toBe(env('CONTROLLER_ENDPOINT'));
});

it('throws an exception when API key is missing', function () {
    new ControllerClient('', env('CONTROLLER_ENDPOINT'));
})->throws(ControllerException::class, 'API key is required');

it('captures an exception using the .env endpoint', function () {
    $mockHttpClient = Mockery::mock(\GuzzleHttp\Client::class);
    $mockHttpClient->shouldReceive('post')->once()->withArgs(function ($url, $options) {
        expect($url)->toBe(env('CONTROLLER_ENDPOINT'));
        expect($options['headers']['Authorization'])->toBe('Bearer ' . env('CONTROLLER_API_KEY'));
        expect($options['json']['title'])->toBe('Test exception');
        return true;
    });

    $client = new ControllerClient(env('CONTROLLER_API_KEY'));
    $client->captureException(new Exception('Test exception'));
});
