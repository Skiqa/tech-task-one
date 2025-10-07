<?php

namespace App\OpenApi\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class InfoOrganizationResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::create('OrganizationResource')
            ->description('Organization resource')
            ->content(
                MediaType::json()->schema(
                    Schema::object()->properties(
                        Schema::string('name'),
                        Schema::integer('number')->nullable(),
                        Schema::array('activity')->nullable()->items(
                            Schema::object()->properties(
                                Schema::integer('id'),
                                Schema::string('name'),
                                Schema::integer('parent_id')->nullable(),
                                Schema::array('children')->nullable()->items(
                                    Schema::object()->properties(
                                        Schema::integer('id'),
                                        Schema::string('name'),
                                        Schema::integer('parent_id')->nullable(),
                                        Schema::array('children')->nullable()->items(
                                            Schema::object()->properties(
                                                Schema::integer('id'),
                                                Schema::string('name'),
                                                Schema::integer('parent_id')->nullable()
                                            )
                                        )
                                    )
                                )
                            )
                        ),
                        Schema::object('building')->nullable()->properties(
                            Schema::integer('id'),
                            Schema::string('name')->nullable(),
                            Schema::string('address')->nullable(),
                            Schema::string('lat')->nullable(),
                            Schema::string('lng')->nullable()
                        ),
                        Schema::string('created_at')->nullable(),
                        Schema::string('updated_at')->nullable()
                    )
                )
            );
    }
}
