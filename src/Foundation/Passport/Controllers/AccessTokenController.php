<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-28 14:33
 */
namespace Notadd\Foundation\Passport\Controllers;

use Illuminate\Http\Response;
use Laravel\Passport\Http\Controllers\HandlesOAuthErrors;
use Laravel\Passport\Passport;
use Laravel\Passport\TokenRepository;
use Lcobucci\JWT\Parser as JwtParser;
use League\OAuth2\Server\AuthorizationServer;
use Notadd\Foundation\Routing\Abstracts\Controller;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response as Psr7Response;

/**
 * Class AccessTokenController.
 */
class AccessTokenController extends Controller
{
    use HandlesOAuthErrors;
    /**
     * @var \Lcobucci\JWT\Parser
     */
    protected $jwt;
    /**
     * @var \League\OAuth2\Server\AuthorizationServer
     */
    protected $server;
    /**
     * @var \Laravel\Passport\TokenRepository
     */
    protected $tokens;

    /**
     * AccessTokenController constructor.
     *
     * @param \League\OAuth2\Server\AuthorizationServer $server
     * @param \Laravel\Passport\TokenRepository         $tokens
     * @param \Lcobucci\JWT\Parser                      $jwt
     */
    public function __construct(AuthorizationServer $server, TokenRepository $tokens, JwtParser $jwt)
    {
        parent::__construct();
        $this->jwt = $jwt;
        $this->server = $server;
        $this->tokens = $tokens;
    }

    /**
     * @param $tokenId
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($tokenId)
    {
        if (is_null($token = $this->request->user()->tokens->find($tokenId))) {
            return new Response('', 404);
        }
        $token->revoke();
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return $this->request->user()->tokens->load('client')->filter(function ($token) {
            return !$token->client->firstParty() && !$token->revoked;
        })->values();
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return \Illuminate\Http\Response
     */
    public function issueToken(ServerRequestInterface $request)
    {
        $response = $this->withErrorHandling(function () use ($request) {
            return $this->server->respondToAccessTokenRequest($request, new Psr7Response());
        });
        if ($response->getStatusCode() < 200 || $response->getStatusCode() > 299) {
            return $response;
        }
        $payload = json_decode($response->getBody()->__toString(), true);
        if (isset($payload['access_token'])) {
            $this->revokeOtherAccessTokens($payload);
        }

        return $response;
    }

    /**
     * @param array $payload
     */
    protected function revokeOtherAccessTokens(array $payload)
    {
        $token = $this->tokens->find($tokenId = $this->jwt->parse($payload['access_token'])->getClaim('jti'));
        $this->tokens->revokeOtherAccessTokens($token->client_id, $token->user_id, $tokenId,
            Passport::$pruneRevokedTokens);
    }
}
