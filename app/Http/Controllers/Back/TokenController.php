<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use DateTimeImmutable;

class TokenController extends Controller
{
    public function index(): \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {

        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);

        $payload = json_encode([
            'iss' => env('ISSUER'),
            'aud' => env('AUDIENCE'),
            'iat' => time(),
            'exp' => time() + 2400,
        ]);

        $base64UrlHeader    = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload   = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

        $signature          = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, env('SECRET_KEY_SHA'), true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        $jwt                = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

        return response([
            'status'    => true,
            'token'     => $jwt
        ]);
    }

    static public function checkToken($token): bool
    {
        if(is_null($token)){
            return true;
        }

        list($headerEncoded, $payloadEncoded, $signatureEncoded) = explode('.', $token);

        $payload           = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], $payloadEncoded)), true);
        $expectedSignature = base64_encode(hash_hmac('sha256', "$headerEncoded.$payloadEncoded", env('SECRET_KEY_SHA'), true));
        $expectedSignature = str_replace(['+', '/', '='], ['-', '_', ''], $expectedSignature);

        if ($signatureEncoded !== $expectedSignature) {
            return true;
        }

        $now = new DateTimeImmutable();

        if ($now->getTimestamp() > $payload['exp']) {
            return true;
        }

        return false;
    }
}
