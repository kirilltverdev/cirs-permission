<?php

namespace Cirs\PermissionPackage;

use Cirs\PermissionPackage\Traits\CheckRoles;

class DistrictPermission
{
    use CheckRoles;

    public function canView($user): bool
    {
        return $this->isSystemAdmin($user);
    }

    public function canCreate($user): bool
    {
        return $this->isSystemAdmin($user);
    }

    public function canUpdate($user): bool
    {
        return $this->isSystemAdmin($user);
    }

    public function canDelete($user): bool
    {
        return $this->isSystemAdmin($user);
    }
}
