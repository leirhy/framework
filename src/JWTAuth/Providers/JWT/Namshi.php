<?php
/**
 * This file is part of Notadd.
 *
 * @author        TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime      2017-10-16 16:11
 */
namespace Notadd\Foundation\JWTAuth\Providers\JWT;

use Illuminate\Support\Arr;
use Namshi\JOSE\Signer\OpenSSL\PublicKey;
use Notadd\Foundation\JWTAuth\JWS;
use ReflectionClass;
use ReflectionException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Providers\JWT\Namshi as TymonNamshi;

/**
 * Class Namshi.
 */
class Namshi extends TymonNamshi
{
    /**
     * Namshi constructor.
     *
     * @param string $secret
     * @param string $algo
     * @param array  $keys
     * @param null   $driver
     */
    public function __construct($secret, $algo, array $keys = [], $driver = null)
    {
        $driver = new JWS(['typ' => 'JWT', 'alg' => $algo]);
        parent::__construct($secret, $algo, $keys, $driver);
    }

    /**
     * @return bool
     * @throws \Tymon\JWTAuth\Exceptions\JWTException
     */
    protected function isAsymmetric()
    {
        try {
            if (in_array($this->getAlgo(), [
                'ES256',
                'ES384',
                'ES512',
            ])) {
                $class = 'Notadd\\Foundation\\JWTAuth\Signers\\OpenSSL\\%s';
            } else {
                $class = 'Namshi\\JOSE\\Signer\\OpenSSL\\%s';
            }

            return (new ReflectionClass(sprintf($class, $this->getAlgo())))->isSubclassOf(PublicKey::class);
        } catch (ReflectionException $e) {
            throw new JWTException('The given algorithm could not be found', $e->getCode(), $e);
        }
    }

    /**
     * Get the private key used to sign tokens
     * with an asymmetric algorithm.
     *
     * @return resource|string
     */
    public function getPrivateKey()
    {
        return file_get_contents(Arr::get($this->keys, 'private'));
    }

    /**
     * Get the public key used to sign tokens
     * with an asymmetric algorithm.
     *
     * @return resource|string
     */
    public function getPublicKey()
    {
        return file_get_contents(Arr::get($this->keys, 'public'));
    }
}
