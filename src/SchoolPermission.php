<?php

namespace Cirs\PermissionPackage;

use Cirs\PermissionPackage\Traits\CheckRoles;

class SchoolPermission
{
    use CheckRoles;

    public function canView($user, $school): bool
    {
        return $this->isSystemAdmin($user) ||
            $this->checkDistrictAdmin($user, $school->district_id) ||
            $this->checkSchoolAdmin($user, $school->id) ||
            $this->checkGCSMHSchool($user, $school->id) ||
            $this->checkStudentsSchool($user, $school->id);
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
