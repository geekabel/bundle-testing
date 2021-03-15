<?php

namespace App\Dto\Transformer;

interface ResponseDtoTransformerInterface
{

    public function transformFromObject($post);
    public function transformFromObjects(iterable $objects): iterable;
    public function CollectionPostResponseDto(array $posts);
}
