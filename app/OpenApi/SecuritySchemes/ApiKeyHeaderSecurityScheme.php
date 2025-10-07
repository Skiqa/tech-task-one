<?php

namespace App\OpenApi\SecuritySchemes;

use GoldSpecDigital\ObjectOrientedOAS\Objects\SecurityScheme;
use Vyuldashev\LaravelOpenApi\Factories\SecuritySchemeFactory;

class ApiKeyHeaderSecurityScheme extends SecuritySchemeFactory
{
    public function build(): SecurityScheme
    {
        return SecurityScheme::create('ApiKeyHeader')
            ->type(SecurityScheme::TYPE_API_KEY)
            ->name('X-API-KEY')
            ->in(SecurityScheme::IN_HEADER);
    }
}
