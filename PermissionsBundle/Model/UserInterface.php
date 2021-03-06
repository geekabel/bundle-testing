<?php

/*
 * This file is part of the EloyekunlePermissionsBundle package.
 *
 * (c) Elijah Oyekunle <https://elijahoyekunle.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloyekunle\PermissionsBundle\Model;

interface UserInterface
{
    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * This returns an array of the role names because Symfony expects a User::getRoles() method that returns a string
     * array of user roles. User::getUserRoles() currently returns RoleInterfaces[].
     *
     * @return string[] The user roles
     */
    public function getRoles();

    /**
     * Tells if the the given user has the super admin role.
     *
     * @return bool
     */
    public function isSuperAdmin();

     /**
     * Sets the super admin status.
     *
     * @param bool $boolean
     *
     * @return static
     */
    //public function setSuperAdmin($boolean);

    /**
     * Checks whether a user has a certain permission.
     *
     * @param string $permission
     *                           The permission string to check
     *
     * @return bool
     *              TRUE if the user has the permission, FALSE otherwise
     */
    public function hasPermission($permission);

    /**
     * Whether a user has a certain role.
     *
     * @param string $role
     *                     The role ID to check
     *
     * @return bool
     *              Returns TRUE if the user has the role, otherwise FALSE
     */
    public function hasRole(RoleInterface $role);

    /**
     * Sets the roles of the user.
     *
     * This overwrites any previous roles.
     *
     * @param \Eloyekunle\PermissionsBundle\Model\RoleInterface[] $roles
     *
     * @return static
     */
    public function setUserRoles(array $roles);

    /**
     * @return \Eloyekunle\PermissionsBundle\Model\RoleInterface[]|null
     */
    public function getUserRoles();

    /**
     * Add a role to a user.
     *
     * @param \Eloyekunle\PermissionsBundle\Model\RoleInterface $role
     *                                                                The role to add
     */
    public function addRole(RoleInterface $role);

    /**
     * Remove a role from a user.
     *
     * @param \Eloyekunle\PermissionsBundle\Model\RoleInterface $role
     *                                                                The role to remove
     */
    public function removeRole(RoleInterface $role);

    /**
     * Checks whether the user is enabled.
     *
     * @return bool true if the user is enabled, false otherwise
     */
    public function isEnabled();
}
