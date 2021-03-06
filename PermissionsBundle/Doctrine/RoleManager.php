<?php

/*
 * This file is part of the EloyekunlePermissionsBundle package.
 *
 * (c) Elijah Oyekunle <https://elijahoyekunle.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * Update this file 19/09/2021
 */

namespace Eloyekunle\PermissionsBundle\Doctrine;

use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;
use Eloyekunle\PermissionsBundle\Model\RoleInterface;
use Eloyekunle\PermissionsBundle\Model\RoleManager as BaseRoleManager;

class RoleManager extends BaseRoleManager
{
    /** @var ObjectManager */
    protected $objectManager;

    /** @var string */
    protected $class;

    public function __construct(ObjectManager $om, $class)
    {
        $this->objectManager = $om;
        $this->class = $class;
    }

    /**
     * {@inheritdoc}
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * {@inheritdoc}
     */
    public function findRoles()
    {
        return $this->getRepository()->findAll();
    }

    /**
     * {@inheritdoc}
     */
    public function findRoleBy(array $criteria)
    {
        return $this->getRepository()->findOneBy($criteria);
    }

    /**
     * {@inheritdoc}
     */
    public function findRole($id)
    {
        return $this->getRepository()->find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function updateRole(RoleInterface $role, $andFlush = true)
    {
        $this->objectManager->persist($role);

        if ($andFlush) {
            $this->objectManager->flush();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function deleteRole(RoleInterface $role)
    {
        $this->objectManager->remove($role);
        $this->objectManager->flush();
    }

    /**
     * @return ObjectRepository
     */
    protected function getRepository()
    {
        return $this->objectManager->getRepository($this->getClass());
    }
}
