<?php

namespace Cirs\PermissionPackage;

use Cirs\PermissionPackage\Traits\CheckRoles;

class StudentPermission
{
    use CheckRoles;

    public function canView($user, $student): bool
    {
        return $this->isSystemAdmin($user) ||
            $this->checkDistrictAdmin($user, $student->school->district_id) ||
            $this->checkSchoolAdmin($user, $student->school_id) ||
            $this->checkGCSMHSchool($user, $student->school_id) ||
            $this->studentHasUser($user, $student);
    }

    public function canCreate($user, $data): bool
    {
        return $this->isSystemAdmin($user) ||
            $this->checkDistrictAdmin($user, $data['district']) ||
            $this->checkSchoolAdmin($user, $data['school']) ||
            $this->checkGCSMHSchool($user, $data['school']);
    }

    public function canUpdate($user, $student): bool
    {
        return $this->isSystemAdmin($user) ||
            $this->checkDistrictAdmin($user, $student->school->district_id) ||
            $this->checkSchoolAdmin($user, $student->school_id) ||
            $this->checkGCSMHSchool($user, $student->school_id) ||
            $this->studentHasUser($user, $student);
    }

    public function canDelete($user, $student): bool
    {
        return  $this->isSystemAdmin($user) ||
            $this->checkDistrictAdmin($user, $student->school->district_id) ||
            $this->checkSchoolAdmin($user, $student->school_id);
    }
}
