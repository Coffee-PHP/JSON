<?php

/**
 * JsonComponentRegistrar.php
 *
 * Copyright 2020 Danny Damsky
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @package coffeephp\json
 * @author Danny Damsky <dannydamsky99@gmail.com>
 * @since 2020-08-29
 */

declare(strict_types=1);

namespace CoffeePhp\Json\Integration;


use CoffeePhp\Di\Contract\ContainerInterface;
use CoffeePhp\Json\Contract\JsonTranslatorInterface;
use CoffeePhp\Json\JsonTranslator;
use CoffeePhp\ComponentRegistry\Contract\ComponentRegistrarInterface;

/**
 * Class JsonComponentRegistrar
 * @package coffeephp\json
 * @author Danny Damsky <dannydamsky99@gmail.com>
 * @since 2020-08-29
 */
final class JsonComponentRegistrar implements ComponentRegistrarInterface
{

    /**
     * @inheritDoc
     */
    public function register(ContainerInterface $di): void
    {
        $di->bind(JsonTranslatorInterface::class, JsonTranslator::class);
        $di->bind(JsonTranslator::class, JsonTranslator::class);
    }
}
