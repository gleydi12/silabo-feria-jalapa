<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use BezhanSalleh\FilamentShield\Support\Utils;
use Spatie\Permission\PermissionRegistrar;

class ShieldSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $rolesWithPermissions = '[{"name":"super_admin","guard_name":"web","permissions":["view_aula","view_any_aula","create_aula","update_aula","restore_aula","restore_any_aula","replicate_aula","reorder_aula","delete_aula","delete_any_aula","force_delete_aula","force_delete_any_aula","view_carrera","view_any_carrera","create_carrera","update_carrera","restore_carrera","restore_any_carrera","replicate_carrera","reorder_carrera","delete_carrera","delete_any_carrera","force_delete_carrera","force_delete_any_carrera","view_guia","view_any_guia","create_guia","update_guia","restore_guia","restore_any_guia","replicate_guia","reorder_guia","delete_guia","delete_any_guia","force_delete_guia","force_delete_any_guia","view_horario","view_any_horario","create_horario","update_horario","restore_horario","restore_any_horario","replicate_horario","reorder_horario","delete_horario","delete_any_horario","force_delete_horario","force_delete_any_horario","view_plan","view_any_plan","create_plan","update_plan","restore_plan","restore_any_plan","replicate_plan","reorder_plan","delete_plan","delete_any_plan","force_delete_plan","force_delete_any_plan","view_role","view_any_role","create_role","update_role","delete_role","delete_any_role","view_sede","view_any_sede","create_sede","update_sede","restore_sede","restore_any_sede","replicate_sede","reorder_sede","delete_sede","delete_any_sede","force_delete_sede","force_delete_any_sede","view_silabo","view_any_silabo","create_silabo","update_silabo","restore_silabo","restore_any_silabo","replicate_silabo","reorder_silabo","delete_silabo","delete_any_silabo","force_delete_silabo","force_delete_any_silabo","view_user","view_any_user","create_user","update_user","restore_user","restore_any_user","replicate_user","reorder_user","delete_user","delete_any_user","force_delete_user","force_delete_any_user"]},{"name":"profesor","guard_name":"web","permissions":["view_guia","view_any_guia","create_guia","update_guia","restore_guia","restore_any_guia","replicate_guia","reorder_guia","delete_guia","delete_any_guia","force_delete_guia","force_delete_any_guia","view_horario","view_any_horario","view_plan","view_any_plan","create_plan","update_plan","restore_plan","restore_any_plan","replicate_plan","reorder_plan","delete_plan","delete_any_plan","force_delete_plan","force_delete_any_plan","view_silabo","view_any_silabo","create_silabo","update_silabo","restore_silabo","restore_any_silabo","replicate_silabo","reorder_silabo","delete_silabo","delete_any_silabo","force_delete_silabo","force_delete_any_silabo"]},{"name":"oficina","guard_name":"web","permissions":["view_aula","view_any_aula","create_aula","update_aula","restore_aula","restore_any_aula","replicate_aula","reorder_aula","delete_aula","delete_any_aula","force_delete_aula","force_delete_any_aula","view_guia","view_any_guia","view_horario","view_any_horario","create_horario","update_horario","restore_horario","restore_any_horario","replicate_horario","reorder_horario","delete_horario","delete_any_horario","force_delete_horario","force_delete_any_horario","view_plan","view_any_plan","view_silabo","view_any_silabo","view_user","view_any_user","create_user","update_user","restore_user","restore_any_user","replicate_user","reorder_user","delete_user","delete_any_user","force_delete_user","force_delete_any_user"]}]';
        $directPermissions = '[]';

        static::makeRolesWithPermissions($rolesWithPermissions);
        static::makeDirectPermissions($directPermissions);

        $this->command->info('Shield Seeding Completed.');
    }

    protected static function makeRolesWithPermissions(string $rolesWithPermissions): void
    {
        if (! blank($rolePlusPermissions = json_decode($rolesWithPermissions, true))) {
            /** @var Model $roleModel */
            $roleModel = Utils::getRoleModel();
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($rolePlusPermissions as $rolePlusPermission) {
                $role = $roleModel::firstOrCreate([
                    'name' => $rolePlusPermission['name'],
                    'guard_name' => $rolePlusPermission['guard_name'],
                ]);

                if (! blank($rolePlusPermission['permissions'])) {
                    $permissionModels = collect($rolePlusPermission['permissions'])
                        ->map(fn ($permission) => $permissionModel::firstOrCreate([
                            'name' => $permission,
                            'guard_name' => $rolePlusPermission['guard_name'],
                        ]))
                        ->all();

                    $role->syncPermissions($permissionModels);
                }
            }
        }
    }

    public static function makeDirectPermissions(string $directPermissions): void
    {
        if (! blank($permissions = json_decode($directPermissions, true))) {
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($permissions as $permission) {
                if ($permissionModel::whereName($permission)->doesntExist()) {
                    $permissionModel::create([
                        'name' => $permission['name'],
                        'guard_name' => $permission['guard_name'],
                    ]);
                }
            }
        }
    }
}
