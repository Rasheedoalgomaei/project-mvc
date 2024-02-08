<?php

namespace SallaProducts\Validation;

use SallaProducts\Validation\Rules\MaxRule;
use SallaProducts\Validation\Rules\EmailRule;
use SallaProducts\Validation\Rules\UniqueRule;
use SallaProducts\Validation\Rules\BetweenRule;
use SallaProducts\Validation\Rules\AlphaNumRule;
use SallaProducts\Validation\Rules\RequiredRule;
use SallaProducts\Validation\Rules\ConfirmedRule;

trait RulesMapper
{
    protected static array $map = [
        'required' => RequiredRule::class,
        'alnum' => AlphaNumRule::class,
        'max' => MaxRule::class,
        'between' => BetweenRule::class,
        'email' => EmailRule::class,
        'confirmed' => ConfirmedRule::class,
        'unique' => UniqueRule::class,
    ];

    public static function resolve(string $rule, $options)
    {
        return new static::$map[$rule](...$options);
    }
}