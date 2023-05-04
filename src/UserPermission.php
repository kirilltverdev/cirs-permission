<?php

namespace Cirs\PermissionPackage;

use Cirs\PermissionPackage\Traits\CheckRoles;

class UserPermission
{
    use CheckRoles;

    public function canView($authUser, $viewUser): bool
    {
        return $authUser->getKey() === $viewUser->getKey() ||
            $this->isSystemAdmin($authUser) ||
            $this->checkDistrictAdmin($authUser, $viewUser->district()?->first()?->getKey()) ||
            $this->checkSchoolAdmin($authUser, $viewUser->school()?->first()?->getKey()) ||
            $this->checkGCSMHSchool($authUser, $viewUser->school()?->first()?->getKey()) ||
            $this->checkLinkedUsers($authUser, $viewUser);
    }

    public function canCreate($authUser): bool
    {
        return $this->isAdminRole($authUser);
    }

    public function canUpdate($authUser, $viewUser): bool
    {
        return $authUser->getKey() === $viewUser->getKey() ||
            $this->isSystemAdmin($authUser) ||
            $this->checkDistrictAdmin($authUser, $viewUser->district()?->first()?->getKey()) ||
            $this->checkSchoolAdmin($authUser, $viewUser->school()?->first()?->getKey());
    }

    public function canDelete($authUser, $viewUser): bool
    {
        return $authUser->getKey() === $viewUser->getKey() ||
            $this->isSystemAdmin($authUser) ||
            $this->checkDistrictAdmin($authUser, $viewUser->district()?->first()?->getKey()) ||
            $this->checkSchoolAdmin($authUser, $viewUser->school()?->first()?->getKey());
    }
}
