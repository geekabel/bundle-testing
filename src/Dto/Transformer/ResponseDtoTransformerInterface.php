<?php

namespace App\Dto\Transformer;

interface ResponseDtoTransformerInterface
{

    public function transformFromObject($object);
    public function transformFromObjects(iterable $objects): iterable;
}
