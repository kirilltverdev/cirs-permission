<?php

namespace Cirs\PermissionPackage\Traits;
use Cirs\PermissionPackage\Models\Role;

trait CheckRoles
{
    public function checkDistrictAdmin($user, $districtId): bool
    {
        return $user->role->name === Role::ROLE_DISTRICT_ADMIN &&
            $user->district()?->first()?->getKey() === $districtId;
    }

    public function checkSchoolAdmin($user, $schoolId): bool
    {
        return $user->role->name === Role::ROLE_SCHOOL_ADMIN &&
            $user->school()?->first()?->getKey() === $schoolId;
    }

    public function checkGCSMHSchool($user, $schoolId): bool
    {
        return (in_array($user->role->name, [
                Role::ROLE_GENERAL_CLASSROOM,
                Role::ROLE_SCHOOL_MENTAL_HEALTH
            ])) &&
            $user->school()?->first()?->getKey() === $schoolId;
    }

    public function isSystemAdmin($user): bool
    {
        return in_array($user->role->name, [
            Role::ROLE_SUPER_ADMIN,
            Role::ROLE_CIRS_ADMIN
        ]);
    }

    public function isAdminRole($user): bool
    {
        return in_array($user->role->name, [
            Role::ROLE_SUPER_ADMIN,
            Role::ROLE_CIRS_ADMIN,
            Role::ROLE_DISTRICT_ADMIN,
            Role::ROLE_SCHOOL_ADMIN
        ]);
    }

    protected function studentHasUser($user, $student): bool
    {
        $usersIds = $student->users()->pluck('users.id')->toArray();

        return in_array($user->getKey(), $usersIds) && $user->school()->first()->getKey() === $student->school()->getKey();
    }

    public function checkLinkedUsers($authUser, $viewUser): bool
    {
        $userStudentsIds = $authUser->studentsRelation()->pluck('students.id')->toArray();
        $viewedUserStudents = $viewUser->studentsRelation()->pluck('students.id')->toArray();

        $hasSameLinkedStudent = false;
        foreach ($userStudentsIds as $studentId) {
            if (in_array($studentId, $viewedUserStudents)) {
                $hasSameLinkedStudent = true;
            }
        }

        return $authUser->role->name === Role::ROLE_GUARDIAN && $hasSameLinkedStudent;
    }

    public function checkStudentsSchool($user, int $schoolId): bool
    {
        $student = $user->studentsRelation()?->first();

        return $user->role->name === Role::ROLE_GUARDIAN &&
            $student->school_id === $schoolId;
    }
}
