<?php

namespace App\Dto\Transformer;

use App\Dto\Transformer\ResponseDtoTransformerInterface;

abstract class AbstractResponseDtoTransformer implements ResponseDtoTransformerInterface
{

    public function transformFromObjects(iterable $objects): iterable
    {
        $dto = [];

        foreach ($objects as $object) {
            # code...
            $dto[] = $this->transformFromObject($object);
        }
        return $object;
    }

}
