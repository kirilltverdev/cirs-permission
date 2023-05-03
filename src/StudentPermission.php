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
            $this->checkDistrictAdmin($user, $data['district_id']) ||
            $this->checkSchoolAdmin($user, $data['school_id']) ||
            $this->checkGCSMHSchool($user, $data['school_id']);
    }

    public function canUpdate($user, $student): bool
    {
        return $this->isSystemAdmin($user) ||
            $this->checkDistrictAdmin($user, $student->school->district_id) ||
            $this->checkSchoolAdmin($user, $student->school_id) ||
            $this->checkGCSMHSchool($user, $student->school_id) ||
            $this->studentHasUser($user, $student);
    }

    public function delete($user, $student): bool
    {
        return  $this->isSystemAdmin($user) ||
            $this->checkDistrictAdmin($user, $student->school->district_id) ||
            $this->checkSchoolAdmin($user, $student->school_id);
    }

    protected function studentHasUser($user, $student): bool
    {
        $usersIds = $student->users()->pluck('users.id')->toArray();

        return in_array($user->getKey(), $usersIds) && $user->school()->first()->getKey() === $student->school()->getKey();
    }
}
