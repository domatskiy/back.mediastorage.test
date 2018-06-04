<?php

namespace App\Http\Middleware;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

use Illuminate\Support\Facades\Log;

class MSUser
{
    const HEADER_KEY = 'MSUser';
    /*private $user;

    function __construct(CookieUser $user)
    {
        $this->user = $user;
    }*/

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, \Closure $next, $guard = null)
    {
        $uuid = $request->headers->get(self::HEADER_KEY);
        Log::debug('request with headers='.implode(',', $request->headers->keys()));
        Log::debug('request MSUser='.$uuid);

        if(!$uuid && strlen($uuid) <> 36)
        {

            try {

                // Generate a version 4 (random) UUID object
                $uuid = Uuid::uuid4()->toString();

            } catch (UnsatisfiedDependencyException $e) {

                // Some dependency was not met. Either the method cannot be called on a
                // 32-bit system, or it can, but it relies on Moontoast\Math to be present.

                Log::critical('generate uuid '.$e->getMessage());

                $uuid = '';

            }

        }

        $request->offsetSet('uuid', $uuid);

        $response = $next($request);

        Log::debug('add header ms_user '.$uuid);

        $response->header(self::HEADER_KEY, $uuid);

        return $response;
        #->withCookie(cookie()->forever(CookieUser::COOKIE_KEY, $CookeUser->uid));
    }
}
