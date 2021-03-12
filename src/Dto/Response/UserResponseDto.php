<?php
declare (strict_types = 1);

namespace App\Dto\Response;

class UserResponseDto
{
    /**
     *  @Serialization\Type("integer")
     */
    public $id;
    /**
     *  @Serialization\Type("string")
     */
    public $name;
    /**
     *  @Serialization\Type("string")
     */
    public $username;
    /**
     *  @Serialization\Type("string")
     */
    public $email;
    /**
     *  @Serialization\Type("string")
     */
    public $address;

}
