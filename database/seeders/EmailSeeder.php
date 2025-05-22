<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Email;
use App\Models\User;

class EmailSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        Email::truncate();
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $users = User::all();
        
        if ($users->isEmpty()) {
            $this->command->warn('Nenhum usuário encontrado. Execute primeiro o UserSeeder.');
            return;
        }

        $emailsData = [
            [
                'titulo' => 'Bem-vindo ao Greenn',
                'remetente' => 'admin@test.com',
                'remetente_id' => $users->where('email', 'admin@test.com')->first()?->id,
                'destinatarios' => ['cliente1@empresa.com', 'cliente2@empresa.com'],
                'conteudo' => '<h1>Bem-vindo!</h1><p>Obrigado por se cadastrar em nossa plataforma.</p>',
                'status' => 'enviado',
                'enviado_em' => now()->subHours(2),
                'created_at' => now()->subHours(3),
                'updated_at' => now()->subHours(2),
            ],
            [
                'titulo' => 'Newsletter Semanal',
                'remetente' => 'joao@test.com',
                'remetente_id' => $users->where('email', 'joao@test.com')->first()?->id,
                'destinatarios' => ['subscriber1@email.com', 'subscriber2@email.com', 'subscriber3@email.com'],
                'conteudo' => '<h2>Newsletter</h2><p>Confira as novidades desta semana!</p>',
                'status' => 'enviado',
                'enviado_em' => now()->subHour(),
                'created_at' => now()->subHours(2),
                'updated_at' => now()->subHour(),
            ],
            [
                'titulo' => 'Promoção Especial',
                'remetente' => 'maria@test.com',
                'remetente_id' => $users->where('email', 'maria@test.com')->first()?->id,
                'destinatarios' => ['cliente3@empresa.com'],
                'conteudo' => '<h1>Oferta Especial!</h1><p>50% de desconto só hoje!</p>',
                'status' => 'pendente',
                'enviado_em' => null,
                'created_at' => now()->subMinutes(30),
                'updated_at' => now()->subMinutes(30),
            ],
            [
                'titulo' => 'Recuperação de Senha',
                'remetente' => 'admin@test.com',
                'remetente_id' => $users->where('email', 'admin@test.com')->first()?->id,
                'destinatarios' => ['usuario@email.com'],
                'conteudo' => '<h2>Reset de Senha</h2><p>Clique no link para redefinir sua senha.</p>',
                'status' => 'erro',
                'enviado_em' => null,
                'created_at' => now()->subMinutes(15),
                'updated_at' => now()->subMinutes(10),
            ],
            [
                'titulo' => 'Confirmação de Pedido',
                'remetente' => 'pedro@test.com',
                'remetente_id' => $users->where('email', 'pedro@test.com')->first()?->id,
                'destinatarios' => ['cliente4@empresa.com', 'cliente5@empresa.com'],
                'conteudo' => '<h1>Pedido Confirmado</h1><p>Seu pedido foi processado com sucesso!</p>',
                'status' => 'enviado',
                'enviado_em' => now()->subMinutes(45),
                'created_at' => now()->subHour(),
                'updated_at' => now()->subMinutes(45),
            ],
            [
                'titulo' => 'Aviso de Manutenção',
                'remetente' => 'admin@test.com',
                'remetente_id' => $users->where('email', 'admin@test.com')->first()?->id,
                'destinatarios' => ['all@empresa.com'],
                'conteudo' => '<h2>Manutenção Programada</h2><p>Sistema ficará indisponível das 2h às 4h.</p>',
                'status' => 'pendente',
                'enviado_em' => null,
                'created_at' => now()->subMinutes(5),
                'updated_at' => now()->subMinutes(5),
            ]
        ];

        foreach ($emailsData as $emailData) {
            Email::create($emailData);
        }

        $this->command->info('Emails criados com sucesso!');
    }
}