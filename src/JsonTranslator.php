<?php

/**
 * JsonTranslator.php
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

declare(strict_types=1);

namespace CoffeePhp\Json;

use CoffeePhp\Json\Contract\JsonTranslatorInterface;
use CoffeePhp\Json\Exception\JsonSerializeException;
use CoffeePhp\Json\Exception\JsonUnserializeException;
use Throwable;

use function json_decode;
use function json_encode;

use const JSON_THROW_ON_ERROR;
use const JSON_UNESCAPED_SLASHES;
use const JSON_UNESCAPED_UNICODE;

/**
 * Class JsonTranslator
 * @package coffeephp\json
 * @since 2020-08-07
 * @author Danny Damsky <dannydamsky99@gmail.com>
 */
final class JsonTranslator implements JsonTranslatorInterface
{
    /**
     * The depth to specify for the {@see json_decode()} function.
     *
     * @var int
     */
    private int $depth;

    /**
     * JSON flags.
     *
     * @var int
     */
    private int $flags;

    /**
     * JsonTranslator constructor.
     * @param int $depth The depth to specify for the {@see json_decode()} function.
     * @param int $flags JSON flags.
     */
    public function __construct(int $depth = 512, int $flags = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
    {
        $this->depth = $depth;
        $this->flags = JSON_THROW_ON_ERROR | $flags;
    }

    /**
     * @inheritDoc
     */
    public function serializeArray(array $array): string
    {
        try {
            return (string)json_encode($array, $this->flags);
        } catch (Throwable $e) {
            throw new JsonSerializeException(
                "Failed to serialize array into JSON: {$e->getMessage()}",
                (int)$e->getCode(),
                $e
            );
        }
    }

    /**
     * @inheritDoc
     */
    public function unserializeArray(string $string): array
    {
        try {
            return (array)json_decode($string, true, $this->depth, $this->flags);
        } catch (Throwable $e) {
            throw new JsonUnserializeException(
                "Failed to unserialize JSON string into array: {$e->getMessage()} ; string: $string",
                (int)$e->getCode(),
                $e
            );
        }
    }

    /**
     * @inheritDoc
     */
    public function serializeObject(object $class): string
    {
        try {
            return (string)json_encode($class, $this->flags);
        } catch (Throwable $e) {
            throw new JsonSerializeException(
                "Failed to serialize class into JSON: {$e->getMessage()}",
                (int)$e->getCode(),
                $e
            );
        }
    }

    /**
     * @inheritDoc
     */
    public function unserializeObject(string $string): object
    {
        try {
            return (object)json_decode($string, false, $this->depth, $this->flags);
        } catch (Throwable $e) {
            throw new JsonUnserializeException(
                "Failed to unserialize JSON string into object: {$e->getMessage()} ; string: $string",
                (int)$e->getCode(),
                $e
            );
        }
    }
}
