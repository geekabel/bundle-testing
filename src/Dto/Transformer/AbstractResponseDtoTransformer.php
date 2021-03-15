<?php

namespace App\Dto\Transformer;

use App\Dto\Transformer\ResponseDtoTransformerInterface;

abstract class AbstractResponseDtoTransformer implements ResponseDtoTransformerInterface
{

    public function transformFromObjects(iterable $objects): iterable
    {
        $dtos = [];

        foreach ($objects as $object) {

            $dtos[] = $this->transformFromObject($object);
        }
        return $dtos;
    }

}
