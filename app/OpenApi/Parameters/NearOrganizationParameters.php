<?php

namespace App\OpenApi\Parameters;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ParametersFactory;

class NearOrganizationParameters extends ParametersFactory
{
    /**
     * @return Parameter[]
     */
    public function build(): array
    {
        return [
            Parameter::query()
                ->name('lat')
                ->description('lat')
                ->required(true)
                ->schema(Schema::number()),
            Parameter::query()
                ->name('lng')
                ->description('Lng')
                ->required(true)
                ->schema(Schema::number()),
            Parameter::query()
                ->name('radius')
                ->description('Radius')
                ->required(false)
                ->schema(Schema::number()->minimum(0)),
        ];
    }
}
