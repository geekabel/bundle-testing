<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use Doctrine\ORM\Mapping as ORM;
use Eloyekunle\PermissionsBundle\Model\Role as BaseRole;
/**
 * @ORM\Entity(repositoryClass=RoleRepository::class)
 */
class Role extends BaseRole
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    public function getId()
    {
        return $this->id;
    }

    public function __construct()
    {
        parent::__construct();
    }
}
