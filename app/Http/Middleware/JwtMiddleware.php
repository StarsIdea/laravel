<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Spatie\ArrayToXml\ArrayToXml;

class JwtMiddleware extends BaseMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $request->merge([
                'status' => 'normal',
            ]);
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                // return response()->json(['status' => 'Token is Invalid']);
                $content = ['status' => 'Token is Invalid'];
                $result = ArrayToXml::convert($content);
                return response($result, 200)->header('Content-Type', 'text/xml');
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                // return response()->json(['status' => 'Token is Expired']);
                // $content = ['status' => 'Token is Expired'];
                // $result = ArrayToXml::convert($content);
                // return response($result, 200)->header('Content-Type', 'text/xml');
                $request->merge([
                    'status' => 'expired',
                ]);
            }else{
                // return response()->json(['status' => 'Authorization Token not found']);
                $content = ['status' => 'Authorization Token not found'];
                $result = ArrayToXml::convert($content);
                return response($result, 200)->header('Content-Type', 'text/xml');
            }
        }
        return $next($request);
    }
}
?>
