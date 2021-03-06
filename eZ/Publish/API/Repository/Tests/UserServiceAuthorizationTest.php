<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace eZ\Publish\API\Repository\Tests;

use eZ\Publish\API\Repository\Exceptions\UnauthorizedException;

/**
 * Test case for operations in the UserService using in memory storage.
 *
 * @see eZ\Publish\API\Repository\UserService
 * @group integration
 * @group authorization
 */
class UserServiceAuthorizationTest extends BaseTest
{
    /**
     * Test for the loadUserGroup() method.
     *
     * @see \eZ\Publish\API\Repository\UserService::loadUserGroup()
     * @depends eZ\Publish\API\Repository\Tests\UserServiceTest::testLoadUserGroup
     */
    public function testLoadUserGroupThrowsUnauthorizedException()
    {
        $this->expectException(\eZ\Publish\API\Repository\Exceptions\UnauthorizedException::class);

        $repository = $this->getRepository();
        $userService = $repository->getUserService();
        $permissionResolver = $repository->getPermissionResolver();

        /* BEGIN: Use Case */
        $user = $this->createUserVersion1();

        $userGroup = $this->createUserGroupVersion1();

        // Now set the currently created "Editor" as current user
        $permissionResolver->setCurrentUserReference($user);

        // This call will fail with an "UnauthorizedException"
        $userService->loadUserGroup($userGroup->id);
        /* END: Use Case */
    }

    /**
     * Test for the loadSubUserGroups() method.
     *
     * @see \eZ\Publish\API\Repository\UserService::loadSubUserGroups()
     * @depends eZ\Publish\API\Repository\Tests\UserServiceTest::testLoadSubUserGroups
     */
    public function testLoadSubUserGroupsThrowsUnauthorizedException()
    {
        $this->expectException(\eZ\Publish\API\Repository\Exceptions\UnauthorizedException::class);

        $repository = $this->getRepository();
        $userService = $repository->getUserService();
        $permissionResolver = $repository->getPermissionResolver();

        /* BEGIN: Use Case */
        $user = $this->createUserVersion1();

        $userGroup = $this->createUserGroupVersion1();

        // Now set the currently created "Editor" as current user
        $permissionResolver->setCurrentUserReference($user);

        // This call will fail with an "UnauthorizedException"
        $userService->loadSubUserGroups($userGroup);
        /* END: Use Case */
    }

    /**
     * Test for the createUserGroup() method.
     *
     * @see \eZ\Publish\API\Repository\UserService::createUserGroup()
     * @depends eZ\Publish\API\Repository\Tests\UserServiceTest::testCreateUserGroup
     */
    public function testCreateUserGroupThrowsUnauthorizedException()
    {
        $this->expectException(\eZ\Publish\API\Repository\Exceptions\UnauthorizedException::class);

        $repository = $this->getRepository();
        $userService = $repository->getUserService();
        $permissionResolver = $repository->getPermissionResolver();

        $editorsGroupId = $this->generateId('group', 13);

        /* BEGIN: Use Case */
        $user = $this->createUserVersion1();

        // Load the parent group
        $parentUserGroup = $userService->loadUserGroup($editorsGroupId);

        // Now set the currently created "Editor" as current user
        $permissionResolver->setCurrentUserReference($user);

        // Instantiate a new group create struct
        $userGroupCreate = $userService->newUserGroupCreateStruct('eng-GB');
        $userGroupCreate->setField('name', 'Example Group');

        // This call will fail with an "UnauthorizedException"
        $userService->createUserGroup($userGroupCreate, $parentUserGroup);
        /* END: Use Case */
    }

    /**
     * Test for the deleteUserGroup() method.
     *
     * @see \eZ\Publish\API\Repository\UserService::deleteUserGroup()
     * @depends eZ\Publish\API\Repository\Tests\UserServiceTest::testDeleteUserGroup
     */
    public function testDeleteUserGroupThrowsUnauthorizedException()
    {
        $this->expectException(\eZ\Publish\API\Repository\Exceptions\UnauthorizedException::class);

        $repository = $this->getRepository();
        $userService = $repository->getUserService();
        $permissionResolver = $repository->getPermissionResolver();

        /* BEGIN: Use Case */
        $user = $this->createUserVersion1();

        $userGroup = $this->createUserGroupVersion1();

        // Now set the currently created "Editor" as current user
        $permissionResolver->setCurrentUserReference($user);

        // This call will fail with an "UnauthorizedException"
        $userService->deleteUserGroup($userGroup);
        /* END: Use Case */
    }

    /**
     * Test for the moveUserGroup() method.
     *
     * @see \eZ\Publish\API\Repository\UserService::moveUserGroup()
     * @depends eZ\Publish\API\Repository\Tests\UserServiceTest::testMoveUserGroup
     */
    public function testMoveUserGroupThrowsUnauthorizedException()
    {
        $this->expectException(\eZ\Publish\API\Repository\Exceptions\UnauthorizedException::class);

        $repository = $this->getRepository();
        $userService = $repository->getUserService();
        $permissionResolver = $repository->getPermissionResolver();

        $memberGroupId = $this->generateId('group', 11);
        /* BEGIN: Use Case */
        // $memberGroupId is the ID of the "Members" group in an eZ Publish
        // demo installation
        //
        $user = $this->createUserVersion1();

        $userGroup = $this->createUserGroupVersion1();

        // Load new parent user group
        $newParentUserGroup = $userService->loadUserGroup($memberGroupId);

        // Now set the currently created "Editor" as current user
        $permissionResolver->setCurrentUserReference($user);

        // This call will fail with an "UnauthorizedException"
        $userService->moveUserGroup($userGroup, $newParentUserGroup);
        /* END: Use Case */
    }

    /**
     * Test for the updateUserGroup() method.
     *
     * @see \eZ\Publish\API\Repository\UserService::updateUserGroup()
     * @depends eZ\Publish\API\Repository\Tests\UserServiceTest::testUpdateUserGroup
     */
    public function testUpdateUserGroupThrowsUnauthorizedException()
    {
        $this->expectException(\eZ\Publish\API\Repository\Exceptions\UnauthorizedException::class);

        $repository = $this->getRepository();
        $userService = $repository->getUserService();
        $permissionResolver = $repository->getPermissionResolver();

        /* BEGIN: Use Case */
        $user = $this->createUserVersion1();

        $userGroup = $this->createUserGroupVersion1();

        // Now set the currently created "Editor" as current user
        $permissionResolver->setCurrentUserReference($user);

        // Load content service
        $contentService = $repository->getContentService();

        // Instantiate a content update struct
        $contentUpdateStruct = $contentService->newContentUpdateStruct();
        $contentUpdateStruct->setField('name', 'New group name');

        $userGroupUpdateStruct = $userService->newUserGroupUpdateStruct();
        $userGroupUpdateStruct->contentUpdateStruct = $contentUpdateStruct;

        // This call will fail with an "UnauthorizedException"
        $userService->updateUserGroup($userGroup, $userGroupUpdateStruct);
        /* END: Use Case */
    }

    /**
     * Test for the createUser() method.
     *
     * @see \eZ\Publish\API\Repository\UserService::createUser()
     * @depends eZ\Publish\API\Repository\Tests\UserServiceTest::testCreateUser
     */
    public function testCreateUserThrowsUnauthorizedException()
    {
        $this->expectException(\eZ\Publish\API\Repository\Exceptions\UnauthorizedException::class);

        $repository = $this->getRepository();
        $userService = $repository->getUserService();
        $permissionResolver = $repository->getPermissionResolver();

        $editorsGroupId = $this->generateId('group', 13);

        /* BEGIN: Use Case */
        $user = $this->createUserVersion1();

        // Now set the currently created "Editor" as current user
        $permissionResolver->setCurrentUserReference($user);

        // Instantiate a user create struct
        $userCreateStruct = $userService->newUserCreateStruct(
            'test',
            'test@example.com',
            'password',
            'eng-GB'
        );

        $userCreateStruct->setField('first_name', 'Christian');
        $userCreateStruct->setField('last_name', 'Bacher');

        $parentUserGroup = $userService->loadUserGroup($editorsGroupId);

        // This call will fail with an "UnauthorizedException"
        $userService->createUser(
            $userCreateStruct,
            [$parentUserGroup]
        );
        /* END: Use Case */
    }

    /**
     * Test for the deleteUser() method.
     *
     * @see \eZ\Publish\API\Repository\UserService::deleteUser()
     * @depends eZ\Publish\API\Repository\Tests\UserServiceTest::testDeleteUser
     */
    public function testDeleteUserThrowsUnauthorizedException()
    {
        $this->expectException(\eZ\Publish\API\Repository\Exceptions\UnauthorizedException::class);

        $repository = $this->getRepository();
        $userService = $repository->getUserService();
        $permissionResolver = $repository->getPermissionResolver();

        /* BEGIN: Use Case */
        $user = $this->createUserVersion1();

        // Now set the currently created "Editor" as current user
        $permissionResolver->setCurrentUserReference($user);

        // This call will fail with an "UnauthorizedException"
        $userService->deleteUser($user);
        /* END: Use Case */
    }

    /**
     * Test for the updateUser() method.
     *
     * @see \eZ\Publish\API\Repository\UserService::updateUser()
     */
    public function testUpdateUserThrowsUnauthorizedException()
    {
        $this->expectException(\eZ\Publish\API\Repository\Exceptions\UnauthorizedException::class);

        $repository = $this->getRepository();
        $userService = $repository->getUserService();
        $permissionResolver = $repository->getPermissionResolver();

        /* BEGIN: Use Case */
        $user = $this->createUserVersion1();

        // Now set the currently created "Editor" as current user
        $permissionResolver->setCurrentUserReference($user);

        // Instantiate a user update struct
        $userUpdateStruct = $userService->newUserUpdateStruct();
        $userUpdateStruct->maxLogin = 42;

        // This call will fail with an "UnauthorizedException"
        $userService->updateUser($user, $userUpdateStruct);
        /* END: Use Case */
    }

    /**
     * @covers \eZ\Publish\API\Repository\UserService::updateUserPassword
     */
    public function testUpdateUserPasswordThrowsUnauthorizedException(): void
    {
        $repository = $this->getRepository();
        $userService = $repository->getUserService();
        $permissionResolver = $repository->getPermissionResolver();

        $this->createRoleWithPolicies('CannotChangePassword', []);

        $user = $this->createCustomUserWithLogin(
            'without_role_password',
            'without_role_password@example.com',
            'Anons',
            'CannotChangePassword'
        );

        // Now set the currently created "Editor" as current user
        $permissionResolver->setCurrentUserReference($user);

        $this->expectException(UnauthorizedException::class);
        $userService->updateUserPassword($user, 'new password');
    }

    /**
     * Test for the assignUserToUserGroup() method.
     *
     * @see \eZ\Publish\API\Repository\UserService::assignUserToUserGroup()
     * @depends eZ\Publish\API\Repository\Tests\UserServiceTest::testAssignUserToUserGroup
     */
    public function testAssignUserToUserGroupThrowsUnauthorizedException()
    {
        $this->expectException(\eZ\Publish\API\Repository\Exceptions\UnauthorizedException::class);

        $repository = $this->getRepository();
        $userService = $repository->getUserService();
        $permissionResolver = $repository->getPermissionResolver();

        $administratorGroupId = $this->generateId('group', 12);
        /* BEGIN: Use Case */
        // $administratorGroupId is the ID of the "Administrator" group in an
        // eZ Publish demo installation

        $user = $this->createUserVersion1();

        // Now set the currently created "Editor" as current user
        $permissionResolver->setCurrentUserReference($user);

        // This call will fail with an "UnauthorizedException"
        $userService->assignUserToUserGroup(
            $user,
            $userService->loadUserGroup($administratorGroupId)
        );
        /* END: Use Case */
    }

    /**
     * Test for the unAssignUssrFromUserGroup() method.
     *
     * @see \eZ\Publish\API\Repository\UserService::unAssignUssrFromUserGroup()
     * @depends eZ\Publish\API\Repository\Tests\UserServiceTest::testUnAssignUserFromUserGroup
     */
    public function testUnAssignUserFromUserGroupThrowsUnauthorizedException()
    {
        $this->expectException(\eZ\Publish\API\Repository\Exceptions\UnauthorizedException::class);

        $repository = $this->getRepository();
        $userService = $repository->getUserService();
        $permissionResolver = $repository->getPermissionResolver();

        $editorsGroupId = $this->generateId('group', 13);
        $memberGroupId = $this->generateId('group', 11);

        /* BEGIN: Use Case */
        // $memberGroupId is the ID of the "Members" group in an eZ Publish
        // demo installation

        $user = $this->createUserVersion1();

        // Assign group to newly created user
        $userService->assignUserToUserGroup(
            $user,
            $userService->loadUserGroup($memberGroupId)
        );

        // Now set the currently created "Editor" as current user
        $permissionResolver->setCurrentUserReference($user);

        // This call will fail with an "UnauthorizedException"
        $userService->unAssignUserFromUserGroup(
            $user,
            $userService->loadUserGroup($editorsGroupId)
        );
        /* END: Use Case */
    }

    /**
     * Test for the loadUserGroupsOfUser() method.
     *
     * @see \eZ\Publish\API\Repository\UserService::loadUserGroupsOfUser()
     * @depends eZ\Publish\API\Repository\Tests\UserServiceTest::testLoadUserGroupsOfUser
     */
    public function testLoadUserGroupsOfUserThrowsUnauthorizedException()
    {
        $this->expectException(\eZ\Publish\API\Repository\Exceptions\UnauthorizedException::class);

        $repository = $this->getRepository();
        $permissionResolver = $repository->getPermissionResolver();

        $userService = $repository->getUserService();

        /* BEGIN: Use Case */
        $user = $this->createUserVersion1();

        // Now set the currently created "Editor" as current user
        $permissionResolver->setCurrentUserReference($user);

        // This call will fail with an "UnauthorizedException"
        $userService->loadUserGroupsOfUser($user);
        /* END: Use Case */
    }

    /**
     * Test for the loadUsersOfUserGroup() method.
     *
     * @see \eZ\Publish\API\Repository\UserService::loadUsersOfUserGroup()
     * @depends eZ\Publish\API\Repository\Tests\UserServiceTest::testLoadUsersOfUserGroup
     */
    public function testLoadUsersOfUserGroupThrowsUnauthorizedException()
    {
        $this->expectException(\eZ\Publish\API\Repository\Exceptions\UnauthorizedException::class);

        $repository = $this->getRepository();
        $userService = $repository->getUserService();
        $permissionResolver = $repository->getPermissionResolver();

        /* BEGIN: Use Case */
        $user = $this->createUserVersion1();

        $userGroup = $this->createUserGroupVersion1();

        // Now set the currently created "Editor" as current user
        $permissionResolver->setCurrentUserReference($user);

        // This call will fail with an "UnauthorizedException"
        $userService->loadUsersOfUserGroup($userGroup);
        /* END: Use Case */
    }

    /**
     * Create a user group fixture in a variable named <b>$userGroup</b>,.
     *
     * @return \eZ\Publish\API\Repository\Values\User\UserGroup
     */
    private function createUserGroupVersion1()
    {
        $repository = $this->getRepository();

        $mainGroupId = $this->generateId('group', 4);
        /* BEGIN: Inline */
        // $mainGroupId is the ID of the main "Users" group in an eZ Publish
        // demo installation

        $userService = $repository->getUserService();

        // Load main group
        $parentUserGroup = $userService->loadUserGroup($mainGroupId);

        // Instantiate a new create struct
        $userGroupCreate = $userService->newUserGroupCreateStruct('eng-US');
        $userGroupCreate->setField('name', 'Example Group');

        // Create the new user group
        $userGroup = $userService->createUserGroup(
            $userGroupCreate,
            $parentUserGroup
        );
        /* END: Inline */

        return $userGroup;
    }
}
