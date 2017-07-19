<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;
use App\User;

class sed_roles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	//Roles

    	/*$gestorApiRole = Role::create([
			'name' => 'Rol para servicios web',
			'slug' => 'rol.api',
			'level' => 1,
		]);

		$gestorAppRole = Role::create([
			'name' => 'Rol para aplicación',
			'slug' => 'rol.app',
			'level' => 1,
		]);*/

        $gestorMantenimRole = Role::create([
			'name' => 'Gestor de mantenimiento',
			'slug' => 'gestor.mantenimiento',
			'description' => 'Gestiona tareas de mantenimiento',
			'level' => 1,
		]);

		$gestorAplicacRole = Role::create([
			'name' => 'Gestor de aplicación',
			'slug' => 'gestor.aplicacion',
			'description' => 'Ejecuta tareas asociadas a aplicación',
			'level' => 1,
		]);

		$gestorSegurRole = Role::create([
			'name' => 'Gestor de seguridad',
			'slug' => 'gestor.seguridad',
			'description' => 'Ejecuta tareas asociadas a seguridad',
			'level' => 1,
		]);

		//Permisos
		$readEmprPermission = Permission::create([
			'name' => 'Leer empresas',
			'slug' => 'leer.empresa',
			'description' => 'Puede leer empresas',
			'model' => 'App\Empresa',
		]);

		$createEmprPermission = Permission::create([
			'name' => 'Crear empresas',
			'slug' => 'crear.empresa',
			'description' => 'Puede crear empresas',
			'model' => 'App\Empresa',
		]);

		$editEmprPermission = Permission::create([
			'name' => 'Editar empresas',
			'slug' => 'editar.empresa',
			'description' => 'Puede editar empresas',
			'model' => 'App\Empresa',
		]);

		$deleteEmprPermission = Permission::create([
			'name' => 'Eliminar empresas',
			'slug' => 'eliminar.empresa',
			'description' => 'Puede eliminar empresas',
			'model' => 'App\Empresa',
		]);

		$readCertPermission = Permission::create([
			'name' => 'Leer certificados',
			'slug' => 'leer.certificado',
			'description' => 'Puede leer certificados',
			'model' => 'App\Certificado',
		]);

		$createCertPermission = Permission::create([
			'name' => 'Crear certificados',
			'slug' => 'crear.certificado',
			'description' => 'Puede crear certificados',
			'model' => 'App\Certificado',
		]);

		$editCertPermission = Permission::create([
			'name' => 'Editar certificados',
			'slug' => 'editar.certificado',
			'description' => 'Puede editar certificados',
			'model' => 'App\Certificado',
		]);

		$deleteCertPermission = Permission::create([
			'name' => 'Eliminar certificados',
			'slug' => 'eliminar.certificado',
			'description' => 'Puede eliminar certificados',
			'model' => 'App\Certificado',
		]);

		$readUsrPermission = Permission::create([
			'name' => 'Leer usuarios',
			'slug' => 'leer.usuario',
			'description' => 'Puede leer usuarios de cuenta',
			'model' => 'App\User',
		]);

		$readAdvansUsrPermission = Permission::create([
			'name' => 'Leer usuarios de advans',
			'slug' => 'leer.usuario.advans',
			'description' => 'Puede leer todos los usuarios',
			'model' => 'App\User',
		]);

		$createUsrPermission = Permission::create([
			'name' => 'Crear usuarios',
			'slug' => 'crear.usuario',
			'description' => 'Puede crear usuarios',
			'model' => 'App\User',
		]);

		$editUsrPermission = Permission::create([
			'name' => 'Editar usuarios',
			'slug' => 'editar.usuario',
			'description' => 'Puede editar usuarios',
			'model' => 'App\User',
		]);

		$deleteUsrPermission = Permission::create([
			'name' => 'Eliminar usuarios',
			'slug' => 'eliminar.usuario',
			'description' => 'Puede eliminar usuarios',
			'model' => 'App\User',
		]);

		$readAppPermission = Permission::create([
			'name' => 'Leer aplicación',
			'slug' => 'leer.aplicacion',
			'description' => 'Puede leer aplicaciones',
			'model' => 'App\BasedatosApp',
		]);

		$createAppPermission = Permission::create([
			'name' => 'Crear aplicación',
			'slug' => 'crear.aplicacion',
			'description' => 'Puede crear aplicaciones',
			'model' => 'App\BasedatosApp',
		]);

		$deleteAppPermission = Permission::create([
			'name' => 'Eliminar aplicación',
			'slug' => 'eliminar.aplicacion',
			'description' => 'Puede eliminar aplicaciones',
			'model' => 'App\BasedatosApp',
		]);

		$asocUsrAppPermission = Permission::create([
			'name' => 'Asociar usuarios',
			'slug' => 'asociar.usuario',
			'description' => 'Puede asociar usuarios a aplicaciones',
			'model' => 'App\BasedatosApp',
		]);

		$readBackPermission = Permission::create([
			'name' => 'Leer respaldo',
			'slug' => 'leer.respaldo',
			'description' => 'Puede leer respaldos',
			'model' => 'App\Backup',
		]);

		$createBackPermission = Permission::create([
			'name' => 'Crear respaldo',
			'slug' => 'crear.respaldo',
			'description' => 'Puede crear respaldos',
			'model' => 'App\Backup',
		]);

		$deleteBackPermission = Permission::create([
			'name' => 'Eliminar respaldo',
			'slug' => 'eliminar.respaldo',
			'description' => 'Puede eliminar respaldos',
			'model' => 'App\Backup',
		]);

		$readRolPermission = Permission::create([
			'name' => 'Leer roles',
			'slug' => 'leer.rol',
			'description' => 'Puede leer roles',
			'model' => 'Bican\Roles\Models\Role',
		]);

		$createRolPermission = Permission::create([
			'name' => 'Crear roles',
			'slug' => 'crear.rol',
			'description' => 'Puede crear roles',
			'model' => 'Bican\Roles\Models\Role',
		]);

		$editRolPermission = Permission::create([
			'name' => 'Editar roles',
			'slug' => 'editar.rol',
			'description' => 'Puede editar roles',
			'model' => 'Bican\Roles\Models\Role',
		]);

		$deleteRolPermission = Permission::create([
			'name' => 'Eliminar roles',
			'slug' => 'eliminar.rol',
			'description' => 'Puede eliminar roles',
			'model' => 'Bican\Roles\Models\Role',
		]);

		$readPermPermission = Permission::create([
			'name' => 'Leer permisos',
			'slug' => 'leer.permiso',
			'description' => 'Puede leer permisos',
			'model' => 'Bican\Roles\Models\Permission',
		]);

		$readBitPermission = Permission::create([
			'name' => 'Leer bitácora',
			'slug' => 'leer.bitácora',
			'description' => 'Puede leer bitácora',
			'model' => 'App\Bitacora',
		]);


		$gestorMantenimRole->attachPermission($readEmprPermission);
		$gestorMantenimRole->attachPermission($createEmprPermission);
		$gestorMantenimRole->attachPermission($editEmprPermission);
		$gestorMantenimRole->attachPermission($deleteEmprPermission);
		$gestorMantenimRole->attachPermission($readCertPermission);
		$gestorMantenimRole->attachPermission($createCertPermission);
		$gestorMantenimRole->attachPermission($editCertPermission);
		$gestorMantenimRole->attachPermission($deleteCertPermission);
		$gestorMantenimRole->attachPermission($readUsrPermission);
		$gestorMantenimRole->attachPermission($createUsrPermission);
		$gestorMantenimRole->attachPermission($editUsrPermission);
		$gestorMantenimRole->attachPermission($deleteUsrPermission);


		$gestorAplicacRole->attachPermission($readAppPermission);
		$gestorAplicacRole->attachPermission($createAppPermission);
		$gestorAplicacRole->attachPermission($deleteAppPermission);
		$gestorAplicacRole->attachPermission($readBackPermission);
		$gestorAplicacRole->attachPermission($createBackPermission);
		$gestorAplicacRole->attachPermission($deleteBackPermission);
		$gestorAplicacRole->attachPermission($asocUsrAppPermission);

		

		$gestorSegurRole->attachPermission($readRolPermission);
		$gestorSegurRole->attachPermission($createRolPermission);
		$gestorSegurRole->attachPermission($editRolPermission);
		$gestorSegurRole->attachPermission($deleteRolPermission);
		$gestorSegurRole->attachPermission($readPermPermission);
		$gestorSegurRole->attachPermission($readBitPermission);

		

    }
}
