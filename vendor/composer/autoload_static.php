<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit17161ad5b1b8fe5beb6a99a159379010
{
    public static $files = array (
        '7b11c4dc42b3b3023073cb14e519683c' => __DIR__ . '/..' . '/ralouphie/getallheaders/src/getallheaders.php',
        'a0edc8309cc5e1d60e3047b5df6b7052' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/functions_include.php',
        '241d2b5b9c1e680c0770b006b0271156' => __DIR__ . '/..' . '/yahnis-elsts/plugin-update-checker/load-v4p9.php',
    );

    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Psr\\Log\\' => 8,
            'Psr\\Http\\Message\\' => 17,
            'Psr\\Http\\Client\\' => 16,
        ),
        'G' => 
        array (
            'GuzzleHttp\\Psr7\\' => 16,
        ),
        'C' => 
        array (
            'Composer\\CaBundle\\' => 18,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'Psr\\Http\\Message\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-message/src',
        ),
        'Psr\\Http\\Client\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-client/src',
        ),
        'GuzzleHttp\\Psr7\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/psr7/src',
        ),
        'Composer\\CaBundle\\' => 
        array (
            0 => __DIR__ . '/..' . '/composer/ca-bundle/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'F' => 
        array (
            'Fapi\\FapiClient\\' => 
            array (
                0 => __DIR__ . '/..' . '/fapi-cz/fapi-client/src',
            ),
        ),
    );

    public static $classMap = array (
        'Fapi\\FapiClient\\ArgumentOutOfRangeException' => __DIR__ . '/..' . '/fapi-cz/fapi-client/src/Fapi/FapiClient/exceptions.php',
        'Fapi\\FapiClient\\AuthorizationException' => __DIR__ . '/..' . '/fapi-cz/fapi-client/src/Fapi/FapiClient/exceptions.php',
        'Fapi\\FapiClient\\DeprecatedException' => __DIR__ . '/..' . '/fapi-cz/fapi-client/src/Fapi/FapiClient/exceptions.php',
        'Fapi\\FapiClient\\InvalidArgumentException' => __DIR__ . '/..' . '/fapi-cz/fapi-client/src/Fapi/FapiClient/exceptions.php',
        'Fapi\\FapiClient\\InvalidStateException' => __DIR__ . '/..' . '/fapi-cz/fapi-client/src/Fapi/FapiClient/exceptions.php',
        'Fapi\\FapiClient\\NotFoundException' => __DIR__ . '/..' . '/fapi-cz/fapi-client/src/Fapi/FapiClient/exceptions.php',
        'Fapi\\FapiClient\\NotImplementedException' => __DIR__ . '/..' . '/fapi-cz/fapi-client/src/Fapi/FapiClient/exceptions.php',
        'Fapi\\FapiClient\\NotSupportedException' => __DIR__ . '/..' . '/fapi-cz/fapi-client/src/Fapi/FapiClient/exceptions.php',
        'Fapi\\FapiClient\\OutOfRangeException' => __DIR__ . '/..' . '/fapi-cz/fapi-client/src/Fapi/FapiClient/exceptions.php',
        'Fapi\\FapiClient\\Rest\\InvalidResponseBodyException' => __DIR__ . '/..' . '/fapi-cz/fapi-client/src/Fapi/FapiClient/Rest/exceptions.php',
        'Fapi\\FapiClient\\Rest\\InvalidStatusCodeException' => __DIR__ . '/..' . '/fapi-cz/fapi-client/src/Fapi/FapiClient/Rest/exceptions.php',
        'Fapi\\FapiClient\\Rest\\RestClientException' => __DIR__ . '/..' . '/fapi-cz/fapi-client/src/Fapi/FapiClient/Rest/exceptions.php',
        'Fapi\\FapiClient\\RuntimeException' => __DIR__ . '/..' . '/fapi-cz/fapi-client/src/Fapi/FapiClient/exceptions.php',
        'Fapi\\FapiClient\\StaticClassException' => __DIR__ . '/..' . '/fapi-cz/fapi-client/src/Fapi/FapiClient/exceptions.php',
        'Fapi\\FapiClient\\UnexpectedValueException' => __DIR__ . '/..' . '/fapi-cz/fapi-client/src/Fapi/FapiClient/exceptions.php',
        'Fapi\\FapiClient\\ValidationException' => __DIR__ . '/..' . '/fapi-cz/fapi-client/src/Fapi/FapiClient/exceptions.php',
        'Fapi\\HttpClient\\ArgumentOutOfRangeException' => __DIR__ . '/..' . '/fapi-cz/http-client/src/Fapi/HttpClient/exceptions.php',
        'Fapi\\HttpClient\\BaseLoggingFormatter' => __DIR__ . '/..' . '/fapi-cz/http-client/src/Fapi/HttpClient/BaseLoggingFormatter.php',
        'Fapi\\HttpClient\\Bidges\\NetteDI\\HttpClientExtension' => __DIR__ . '/..' . '/fapi-cz/http-client/src/Fapi/HttpClient/Bridges/NetteDI/HttpClientExtension.php',
        'Fapi\\HttpClient\\Bridges\\Tracy\\BarHttpClient' => __DIR__ . '/..' . '/fapi-cz/http-client/src/Fapi/HttpClient/Bridges/Tracy/BarHttpClient.php',
        'Fapi\\HttpClient\\Bridges\\Tracy\\TracyToPsrLogger' => __DIR__ . '/..' . '/fapi-cz/http-client/src/Fapi/HttpClient/Bridges/Tracy/TracyToPsrLogger.php',
        'Fapi\\HttpClient\\CapturingHttpClient' => __DIR__ . '/..' . '/fapi-cz/http-client/src/Fapi/HttpClient/CapturingHttpClient.php',
        'Fapi\\HttpClient\\CurlHttpClient' => __DIR__ . '/..' . '/fapi-cz/http-client/src/Fapi/HttpClient/CurlHttpClient.php',
        'Fapi\\HttpClient\\DeprecatedException' => __DIR__ . '/..' . '/fapi-cz/http-client/src/Fapi/HttpClient/exceptions.php',
        'Fapi\\HttpClient\\GuzzleHttpClient' => __DIR__ . '/..' . '/fapi-cz/http-client/src/Fapi/HttpClient/GuzzleHttpClient.php',
        'Fapi\\HttpClient\\HttpClientException' => __DIR__ . '/..' . '/fapi-cz/http-client/src/Fapi/HttpClient/exceptions.php',
        'Fapi\\HttpClient\\HttpMethod' => __DIR__ . '/..' . '/fapi-cz/http-client/src/Fapi/HttpClient/HttpMethod.php',
        'Fapi\\HttpClient\\HttpRequest' => __DIR__ . '/..' . '/fapi-cz/http-client/src/Fapi/HttpClient/HttpRequest.php',
        'Fapi\\HttpClient\\HttpResponse' => __DIR__ . '/..' . '/fapi-cz/http-client/src/Fapi/HttpClient/HttpResponse.php',
        'Fapi\\HttpClient\\HttpStatusCode' => __DIR__ . '/..' . '/fapi-cz/http-client/src/Fapi/HttpClient/HttpStatusCode.php',
        'Fapi\\HttpClient\\IHttpClient' => __DIR__ . '/..' . '/fapi-cz/http-client/src/Fapi/HttpClient/IHttpClient.php',
        'Fapi\\HttpClient\\ILoggingFormatter' => __DIR__ . '/..' . '/fapi-cz/http-client/src/Fapi/HttpClient/ILoggingFormatter.php',
        'Fapi\\HttpClient\\InvalidArgumentException' => __DIR__ . '/..' . '/fapi-cz/http-client/src/Fapi/HttpClient/exceptions.php',
        'Fapi\\HttpClient\\InvalidStateException' => __DIR__ . '/..' . '/fapi-cz/http-client/src/Fapi/HttpClient/exceptions.php',
        'Fapi\\HttpClient\\LoggingHttpClient' => __DIR__ . '/..' . '/fapi-cz/http-client/src/Fapi/HttpClient/LoggingHttpClient.php',
        'Fapi\\HttpClient\\MockHttpClient' => __DIR__ . '/..' . '/fapi-cz/http-client/src/Fapi/HttpClient/MockHttpClient.php',
        'Fapi\\HttpClient\\NotImplementedException' => __DIR__ . '/..' . '/fapi-cz/http-client/src/Fapi/HttpClient/exceptions.php',
        'Fapi\\HttpClient\\NotSupportedException' => __DIR__ . '/..' . '/fapi-cz/http-client/src/Fapi/HttpClient/exceptions.php',
        'Fapi\\HttpClient\\OutOfRangeException' => __DIR__ . '/..' . '/fapi-cz/http-client/src/Fapi/HttpClient/exceptions.php',
        'Fapi\\HttpClient\\RedirectHelper' => __DIR__ . '/..' . '/fapi-cz/http-client/src/Fapi/HttpClient/RedirectHelper.php',
        'Fapi\\HttpClient\\Rest\\InvalidResponseBodyException' => __DIR__ . '/..' . '/fapi-cz/http-client/src/Fapi/HttpClient/Rest/exceptions.php',
        'Fapi\\HttpClient\\Rest\\InvalidStatusCodeException' => __DIR__ . '/..' . '/fapi-cz/http-client/src/Fapi/HttpClient/Rest/exceptions.php',
        'Fapi\\HttpClient\\Rest\\RestClient' => __DIR__ . '/..' . '/fapi-cz/http-client/src/Fapi/HttpClient/Rest/RestClient.php',
        'Fapi\\HttpClient\\Rest\\RestClientException' => __DIR__ . '/..' . '/fapi-cz/http-client/src/Fapi/HttpClient/Rest/exceptions.php',
        'Fapi\\HttpClient\\StaticClassException' => __DIR__ . '/..' . '/fapi-cz/http-client/src/Fapi/HttpClient/exceptions.php',
        'Fapi\\HttpClient\\TimeLimitExceededException' => __DIR__ . '/..' . '/fapi-cz/http-client/src/Fapi/HttpClient/exceptions.php',
        'Fapi\\HttpClient\\TooManyRedirectsException' => __DIR__ . '/..' . '/fapi-cz/http-client/src/Fapi/HttpClient/exceptions.php',
        'Fapi\\HttpClient\\UnexpectedValueException' => __DIR__ . '/..' . '/fapi-cz/http-client/src/Fapi/HttpClient/exceptions.php',
        'Fapi\\HttpClient\\Utils\\Callback' => __DIR__ . '/..' . '/fapi-cz/http-client/src/Fapi/HttpClient/Utils/Callback.php',
        'Fapi\\HttpClient\\Utils\\Json' => __DIR__ . '/..' . '/fapi-cz/http-client/src/Fapi/HttpClient/Utils/Json.php',
        'Fapi\\HttpClient\\Utils\\JsonException' => __DIR__ . '/..' . '/fapi-cz/http-client/src/Fapi/HttpClient/Utils/Json.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit17161ad5b1b8fe5beb6a99a159379010::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit17161ad5b1b8fe5beb6a99a159379010::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit17161ad5b1b8fe5beb6a99a159379010::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit17161ad5b1b8fe5beb6a99a159379010::$classMap;

        }, null, ClassLoader::class);
    }
}
