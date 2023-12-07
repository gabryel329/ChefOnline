<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //USER

        DB::table('users')->insert([
            'name' => 'Client',
            'tipo' => 'Client',
            'email' => 'clientes@lista.com',
            'password' => bcrypt('12345678'),
        ]);

        //STATUS

        DB::table('status')->insert([
            'nome' => 'EM ANDAMENTO',
        ]);

        DB::table('status')->insert([
            'nome' => 'FEITO',
        ]);

        DB::table('status')->insert([
            'nome' => 'DELETADO',
        ]);

        //FORMA PAGAMENTO
        DB::table('forma_pagamento')->insert([
            'nome' => 'PIX',
        ]);

        DB::table('forma_pagamento')->insert([
            'nome' => 'DEBITO',
        ]);

        DB::table('forma_pagamento')->insert([
            'nome' => 'CREDITO',
        ]);

        DB::table('forma_pagamento')->insert([
            'nome' => 'DINHEIRO',
        ]);

        //PRODUTOS
        DB::table('produto')->insert([
            'nome' => 'Camarão c/ Queijo',
            'preco' => '16',
            'descricao' => '8 UND',
            'imagem' => 'CamaraoQueijo.jpg',
        ]);

        DB::table('produto')->insert([
            'nome' => 'Kibe',
            'preco' => '15',
            'descricao' => '12 UND',
            'imagem' => 'Kibe.jpg',
        ]);

        DB::table('produto')->insert([
            'nome' => 'Camarão na Tapioca',
            'preco' => '18',
            'descricao' => '8 UND',
            'imagem' => 'CamaraoTapioca.jpg',
        ]);

        DB::table('produto')->insert([
            'nome' => 'Camarão Empanado',
            'preco' => '15',
            'descricao' => '8 UND',
            'imagem' => 'CamaraoEmpanado.jpg',
        ]);

        DB::table('produto')->insert([
            'nome' => 'Coxinha',
            'preco' => '15',
            'descricao' => '12 UND',
            'imagem' => 'Coxinha.jpg',
        ]);
    }
}
