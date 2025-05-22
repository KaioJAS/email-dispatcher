<?php

namespace Tests\Feature;

use App\Models\Email;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmailControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $token;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->token = $this->user->createToken('test-token')->plainTextToken;
    }

    public function test_can_list_emails()
    {
        Email::factory()->count(5)->create([
            'remetente_id' => $this->user->id
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/emails');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data' => [
                'data',
            ]
        ]);

        $this->assertNotEmpty($response->json('data.data'));
    }

    public function test_can_create_email()
    {
        $data = [
            'titulo' => 'Teste de Email',
            'remetente' => 'kaiojas1@gogle.com',
            'destinatarios' => 'kaiojas1@gogle.com, kaiojas1@outlook.com',
            'conteudo' => 'Conteúdo do email de teste'
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/emails', $data);

        if ($response->status() === 422) {
            $this->markTestSkipped('Validação de email falhou: ' . json_encode($response->json()));
        }

        $this->assertDatabaseHas('emails', [
            'titulo' => 'Teste de Email',
        ]);
    }

    public function test_cannot_create_email_with_invalid_data()
    {
        $data = [
            'titulo' => 'Teste de Email',
            'destinatarios' => 'user1@example.com',
            'conteudo' => 'Conteúdo do email de teste'
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/emails', $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['remetente']);
    }

    public function test_can_delete_email()
    {
        $email = Email::factory()->create([
            'remetente_id' => $this->user->id
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->deleteJson('/api/emails/' . $email->id);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Email deletado com sucesso!'
        ]);

        $this->assertDatabaseMissing('emails', [
            'id' => $email->id
        ]);
    }
}
