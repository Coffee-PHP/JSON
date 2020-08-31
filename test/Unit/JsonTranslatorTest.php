<?php

/**
 * JsonTranslatorTest.php
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
 * @since 2020-08-07
 */

declare (strict_types=1);

namespace CoffeePhp\Json\Test\Unit;


use CoffeePhp\Json\Contract\JsonTranslatorInterface;
use CoffeePhp\Json\JsonTranslator;
use JsonException;
use PHPUnit\Framework\TestCase;
use stdClass;

use function json_encode;
use function PHPUnit\Framework\assertSame;

/**
 * Class JsonTranslatorTest
 * @package coffeephp\json
 * @since 2020-08-07
 * @author Danny Damsky <dannydamsky99@gmail.com>
 * @see JsonTranslatorInterface
 * @see JsonTranslator
 */
class JsonTranslatorTest extends TestCase
{
    /**
     * @throws JsonException
     * @see JsonTranslatorInterface::unserializeArray()
     * @see JsonTranslatorInterface::serializeArray()
     */
    public function testSerializeAndUnserializeArray(): void
    {
        $array = [
            'a' => 'b',
            'c' => 2,
            'd' => true,
            'e' => null,
            null => 2,
            2 => null
        ];

        $instance = $this->getJsonInstance();

        $serialized = $instance->serializeArray($array);

        assertSame(
            json_encode($array, JSON_THROW_ON_ERROR),
            $serialized
        );

        $unserialized = $instance->unserializeArray($serialized);

        assertSame(
            $array,
            $unserialized
        );
    }

    /**
     * @throws JsonException
     * @see JsonTranslatorInterface::serializeObject()
     */
    public function testSerializeObject(): void
    {
        $class = new stdClass();
        $class->a = 'b';
        $class->c = 2;
        $class->d = true;
        $class->e = null;

        $array = (array)$class;

        $instance = $this->getJsonInstance();

        $serialized = $instance->serializeObject($class);

        assertSame(
            json_encode($class, JSON_THROW_ON_ERROR),
            $serialized
        );

        assertSame(
            json_encode($class, JSON_THROW_ON_ERROR),
            json_encode($array, JSON_THROW_ON_ERROR)
        );

        assertSame(
            $serialized,
            $instance->serializeArray($array)
        );

        assertSame(
            $instance->unserializeArray($serialized),
            $array
        );
    }

    /**
     * @return JsonTranslatorInterface
     */
    protected function getJsonInstance(): JsonTranslatorInterface
    {
        return new JsonTranslator();
    }
}
