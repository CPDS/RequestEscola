<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()['cache']->forget('spatie.permission.cache');

    	//Papeis
        DB::table('roles')->insert([
            'name' => 'Administrador',
            'guard_name' => 'usuario',
        ]);
         DB::table('roles')->insert([
            'name' => 'Funcionario',
            'guard_name' => 'usuario',
         ]);
         DB::table('roles')->insert([
            'name' => 'Professor',
            'guard_name' => 'usuario',
         ]);

         /*permissões por Módulos*/

        #Usuário
        Permission::create(['name' => 'Cadastrar Usuario']);
        Permission::create(['name' => 'Editar Usuario']);
        Permission::create(['name' => 'Deletar Usuario']);
        Permission::create(['name' => 'Ver Usuario']);
        
        #Equipamento
        Permission::create(['name' => 'Cadastrar Equipamento']);
        Permission::create(['name' => 'Editar Equipamento']);
        Permission::create(['name' => 'Deletar Equipamento']);
        Permission::create(['name' => 'Ver Equipamento']);
        
        #Ambiente
        Permission::create(['name' => 'Cadastrar Ambiente']);
        Permission::create(['name' => 'Editar Ambiente']);
        Permission::create(['name' => 'Deletar Ambiente']);
        Permission::create(['name' => 'Ver Ambiente']);
        
        #Manutencao
        Permission::create(['name' => 'Cadastrar Manutencao']);
        Permission::create(['name' => 'Editar Manutencao']);
        Permission::create(['name' => 'Deletar Manutencao']);
        Permission::create(['name' => 'Ver Manutencao']);

        #Reserva
        Permission::create(['name' => 'Cadastrar Reserva']);
        Permission::create(['name' => 'Editar Reserva']);
        Permission::create(['name' => 'Deletar Reserva']);
        Permission::create(['name' => 'Ver Reserva']);
        
        #Local
        Permission::create(['name' => 'Cadastrar Local']);
        Permission::create(['name' => 'Editar Local']);
        Permission::create(['name' => 'Deletar Local']);
        Permission::create(['name' => 'Ver Local']);
        

        /*Associando papel a permissão*/

           #Usuarios
        DB::table('role_has_permissions')->insert([
            'permission_id' => 1,
            'role_id' => 1,
        ]);
        
        DB::table('role_has_permissions')->insert([
            'permission_id' => 2,
            'role_id' => 1,
        ]);

        DB::table('role_has_permissions')->insert([
            'permission_id' => 3,
            'role_id' => 1,
        ]);

        DB::table('role_has_permissions')->insert([
            'permission_id' => 4,
            'role_id' => 1,
        ]);
            #Fim de Usuários

            #Equipamento
        
        //Administrador
        DB::table('role_has_permissions')->insert([
            'permission_id' => 5,
            'role_id' => 1,
        ]);
        
        DB::table('role_has_permissions')->insert([
            'permission_id' => 6,
            'role_id' => 1,
        ]);

        DB::table('role_has_permissions')->insert([
            'permission_id' => 7,
            'role_id' => 1,
        ]);

        DB::table('role_has_permissions')->insert([
            'permission_id' => 8,
            'role_id' => 1,
        ]);

        //Funcionário
        
        DB::table('role_has_permissions')->insert([
            'permission_id' => 8,
            'role_id' => 2,
        ]);
            #fim de Equipamentos
        

               #Ambiente        
        //Administrador
        DB::table('role_has_permissions')->insert([
            'permission_id' => 9,
            'role_id' => 1,
        ]);
        
        DB::table('role_has_permissions')->insert([
            'permission_id' => 10,
            'role_id' => 1,
        ]);

        DB::table('role_has_permissions')->insert([
            'permission_id' => 11,
            'role_id' => 1,
        ]);

        DB::table('role_has_permissions')->insert([
            'permission_id' => 12,
            'role_id' => 1,
        ]);

        //Funcionário
        
        DB::table('role_has_permissions')->insert([
            'permission_id' => 12,
            'role_id' => 2,
        ]);
            #fim de Ambiente

           #manutenção        
        //Administrador
        DB::table('role_has_permissions')->insert([
            'permission_id' => 13,
            'role_id' => 1,
        ]);
        
        DB::table('role_has_permissions')->insert([
            'permission_id' => 14,
            'role_id' => 1,
        ]);

        DB::table('role_has_permissions')->insert([
            'permission_id' => 15,
            'role_id' => 1,
        ]);

        DB::table('role_has_permissions')->insert([
            'permission_id' => 16,
            'role_id' => 1,
        ]);

        //Funcionário
        
        DB::table('role_has_permissions')->insert([
            'permission_id' => 13,
            'role_id' => 2,
        ]);
        
        DB::table('role_has_permissions')->insert([
            'permission_id' => 14,
            'role_id' => 2,
        ]);

        DB::table('role_has_permissions')->insert([
            'permission_id' => 15,
            'role_id' => 2,
        ]);

        DB::table('role_has_permissions')->insert([
            'permission_id' => 16,
            'role_id' => 2,
        ]);
            #fim de manutenção
        
               #Reserva        
        //Administrador
        DB::table('role_has_permissions')->insert([
            'permission_id' => 17,
            'role_id' => 1,
        ]);
        
        DB::table('role_has_permissions')->insert([
            'permission_id' => 18,
            'role_id' => 1,
        ]);

        DB::table('role_has_permissions')->insert([
            'permission_id' => 19,
            'role_id' => 1,
        ]);

        DB::table('role_has_permissions')->insert([
            'permission_id' => 20,
            'role_id' => 1,
        ]);

        //Funcionário
        
        DB::table('role_has_permissions')->insert([
            'permission_id' => 17,
            'role_id' => 2,
        ]);
        
        DB::table('role_has_permissions')->insert([
            'permission_id' => 18,
            'role_id' => 2,
        ]);

        DB::table('role_has_permissions')->insert([
            'permission_id' => 19,
            'role_id' => 2,
        ]);

        DB::table('role_has_permissions')->insert([
            'permission_id' => 20,
            'role_id' => 2,
        ]);

        //Professor
        DB::table('role_has_permissions')->insert([
            'permission_id' => 17,
            'role_id' => 3,
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 19,
            'role_id' => 3,
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 20,
            'role_id' => 3,
        ]);
            #fim de Reserva
        
        
               #Local        
        //Administrador
        DB::table('role_has_permissions')->insert([
            'permission_id' => 21,
            'role_id' => 1,
        ]);
        
        DB::table('role_has_permissions')->insert([
            'permission_id' => 22,
            'role_id' => 1,
        ]);

        DB::table('role_has_permissions')->insert([
            'permission_id' => 23,
            'role_id' => 1,
        ]);

        DB::table('role_has_permissions')->insert([
            'permission_id' => 24,
            'role_id' => 1,
        ]);

        //Funcionário
        
        DB::table('role_has_permissions')->insert([
            'permission_id' => 24,
            'role_id' => 2,
        ]);
            #fim de Local






    }
}
