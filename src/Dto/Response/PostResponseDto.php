<?php
declare (strict_types = 1);

namespace App\Dto\Response;

use JMS\Serializer\Annotation as Serialization;

class PostResponseDto
{
    /**
     *  @Serialization\Type("integer")
     */
    public $userId;

    /**
     *  @Serialization\Type("integer")
     */
    public $id;

    /**
     *  @Serialization\Type("string")
     */
    public $title;

    /**
     *  @Serialization\Type("string")
     */
    public $body;

}
