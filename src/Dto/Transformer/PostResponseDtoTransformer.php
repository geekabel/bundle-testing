<?php

namespace App\Dto\Transformer;

use App\Dto\Response\PostResponseDto;

class PostResponseDtoTransformer extends AbstractResponseDtoTransformer
{

    /**
     *
     * @param Post $post
     *
     * @return PostResponseDto
     */
    public function transformFromObject($post): PostResponseDto
    {
        $dto = new PostResponseDto();

        $dto->userId = $post->getUserId();
        $dto->id = $post->id;
        $dto->title = $post->getTitle();
        $dto->body = $post->getBody();

        return $dto;
    }
}
