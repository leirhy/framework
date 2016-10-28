<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-28 14:43
 */
namespace Notadd\Foundation\Passport\Controllers;
use Illuminate\Contracts\Routing\ResponseFactory;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Http\Controllers\HandlesOAuthErrors;
use Laravel\Passport\Http\Controllers\RetrievesAuthRequestFromSession;
use Laravel\Passport\Passport;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\RequestTypes\AuthorizationRequest;
use Notadd\Foundation\Routing\Abstracts\Controller;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response as Psr7Response;
/**
 * Class AuthorizationController
 * @package Notadd\Foundation\Passport\Controllers
 */
class AuthorizationController extends Controller {
    use HandlesOAuthErrors, RetrievesAuthRequestFromSession;
    /**
     * @var \Illuminate\Contracts\Routing\ResponseFactory
     */
    protected $response;
    /**
     * @var \League\OAuth2\Server\AuthorizationServer
     */
    protected $server;
    /**
     * AuthorizationController constructor.
     * @param \League\OAuth2\Server\AuthorizationServer $server
     * @param \Illuminate\Contracts\Routing\ResponseFactory $response
     */
    public function __construct(AuthorizationServer $server, ResponseFactory $response) {
        $this->server = $server;
        $this->response = $response;
    }
    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deny() {
        $redirect = $this->getAuthRequestFromSession($request)->getClient()->getRedirectUri();
        return $this->response->redirectTo($redirect . '?error=access_denied&state=' . $request->input('state'));
    }
    /**
     * @param \Psr\Http\Message\ServerRequestInterface $psrRequest
     * @param \Laravel\Passport\ClientRepository $clients
     * @return \Illuminate\Http\Response
     */
    public function index(ServerRequestInterface $psrRequest, ClientRepository $clients) {
        return $this->withErrorHandling(function () use ($psrRequest, $clients) {
            $this->request->session()->put('authRequest', $authRequest = $this->server->validateAuthorizationRequest($psrRequest));
            $scopes = $this->parseScopes($authRequest);
            return $this->response->view('passport::authorize', [
                'client' => $clients->find($authRequest->getClient()->getIdentifier()),
                'user' => $request->user(),
                'scopes' => $scopes,
                'request' => $request,
            ]);
        });
    }
    /**
     * @param \League\OAuth2\Server\RequestTypes\AuthorizationRequest $authRequest
     * @return array
     */
    protected function parseScopes(AuthorizationRequest $authRequest) {
        return Passport::scopesFor(collect($authRequest->getScopes())->map(function ($scope) {
            return $scope->getIdentifier();
        })->all());
    }
    /**
     * @return \Illuminate\Http\Response
     */
    public function store() {
        return $this->withErrorHandling(function () use ($request) {
            $authRequest = $this->getAuthRequestFromSession($request);
            return $this->server->completeAuthorizationRequest($authRequest, new Psr7Response);
        });
    }
}