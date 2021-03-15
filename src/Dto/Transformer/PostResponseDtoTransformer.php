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
        $dto->userId = $post['userId'];
        $dto->id = $post['id'];
        $dto->title = $post['title'];
        $dto->body = $post['body'];

        return $dto;
    }
    
    public function CollectionPostResponseDto(array $posts)
    {
        $collectionDto = [];
        foreach ($posts as $post) {
            $collectionDto[] = $this->transformFromObject($post);
        }
        return $collectionDto;

    }
}
