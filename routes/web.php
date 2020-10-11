<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->group(['prefix' => 'draft'], function () use ($router) {
    $router->post('/Register', [
        'uses' => 'MemberController@register',
    ]);

    $router->post('/Login', [
        'uses' => 'MemberController@login',
    ]);

    $router->group(['middleware' => 'jwt'], function () use ($router) {
        // Member
        $router->get('/Profile', [
            'uses' => 'MemberController@getProfile',
        ]);

        $router->patch('/Profile', [
            'uses' => 'MemberController@updateProfile',
        ]);

        $router->post('/Channels', [
            'uses' => 'ChannelController@createChannel',
        ]);

        $router->get('/Channels', [
            'uses' => 'ChannelController@getChannels',
        ]);

        // Channel
        $router->group(['middleware' => 'channel-permission'], function() use ($router) {
            $router->post('/Channels/{channelId}/Items', [
                'uses' => 'ItemController@createItem',
            ]);

            $router->get('/Channels/{channelId}/Items', [
                'uses' => 'ItemController@getItems',
            ]);
        });

        // Channel's Item
        $router->group(['middleware' => 'item-permission'], function() use ($router) {
            $router->post('/Channels/{channelId}/Items/{itemId}/Audios', [
                'uses' => 'ItemController@uploadAudio',
            ]);
        });

        $router->get('/Channels/{channelId}/Items/{itemId}/Audios', [
            'uses' => 'ItemController@getAudio',
        ]);
    });
});
