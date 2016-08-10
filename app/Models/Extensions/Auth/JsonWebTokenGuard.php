<?php

namespace App\Models\Extensions\Auth;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Auth\GuardHelpers;

use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;

class JsonWebTokenGuard implements Guard
{
    use GuardHelpers;

    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * The name of the field on the request containing the API token.
     *
     * @var string
     */
    protected $input_key;

    /**
     * The name of the token owner "column" in persistent storage.
     *
     * @var string
     */
    protected $token_owner;

    /**
     * Create a new authentication guard.
     *
     * @param  \Illuminate\Contracts\Auth\UserProvider  $provider
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(UserProvider $provider, Request $request)
    {
        $this->provider = $provider;
        $this->request = $request;
        $this->input_key = 'api_token';
        $this->token_owner = 'name';
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        if (! is_null($this->user)) {
            return $this->user;
        }

        $user = null;

        $token = $this->getTokenForRequest();
        $json_web_token = (new Parser())->parse($token);

        $token_owner = $json_web_token->getClaim('aud', '');
        $user = $this->provider->retrieveByCredentials([$this->token_owner => $token_owner]);
        
        $signer = new Sha256();
        if (!is_null($user) && !$json_web_token->verify($signer, $user->api_key)) {
            $user = null;
        }

        return $this->user = $user;
    }

    /**
     * Validate a user's credentials.
     *
     * @param  array  $credentials
     * @return bool
     */
    public function validate(array $credentials = [])
    {
        $token = $credentials[$this->input_key];
        $json_web_token = (new Parser())->parse($token);

        $token_owner = $json_web_token->getClaim('aud', '');
        $user = $this->provider->retrieveByCredentials([$this->token_owner => $token_owner]);

        $signer = new Sha256();
        if (!is_null($user) && $json_web_token->verify($signer, $user->api_key)) {
            return true;
        }
    
        return false;
    }

    /**
     * Set the current request instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return $this
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Get the token for the current request.
     *
     * @return string
     */
    protected function getTokenForRequest()
    {
        $token = $this->request->input($this->input_key);

        if (empty($token)) {
            $token = $this->request->bearerToken();
        }

        if (empty($token)) {
            $token = $this->request->getPassword();
        }

        return $token;
    }
}
