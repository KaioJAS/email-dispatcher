<?php

namespace Tests\Unit;

use App\Jobs\ProcessEmailJob;
use App\Mail\EmailDispatch;
use App\Models\Email;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ProcessEmailJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_process_email_job_sends_email()
    {
        Mail::fake();

        $user = User::factory()->create();

        $email = Email::factory()->create([
            'remetente_id' => $user->id,
            'titulo' => 'Teste de Job',
            'remetente' => 'sender@example.com',
            'destinatarios' => ['recipient@example.com'],
            'conteudo' => 'Teste de conteúdo',
            'status' => 'pendente'
        ]);

        $job = new ProcessEmailJob($email);
        $job->handle();

        Mail::assertSent(EmailDispatch::class, function (EmailDispatch $mail) {
            return $mail->hasTo('recipient@example.com');
        });

        $this->assertEquals('enviado', $email->fresh()->status);
        $this->assertNotNull($email->fresh()->enviado_em);
    }

    public function test_process_email_job_marks_as_error_on_exception()
    {
        Mail::shouldReceive('to')->andThrow(new \Exception('Erro ao enviar'));

        $user = User::factory()->create();

        $email = Email::factory()->create([
            'remetente_id' => $user->id,
            'titulo' => 'Teste de Job com Erro',
            'remetente' => 'sender@example.com',
            'destinatarios' => ['recipient@example.com'],
            'conteudo' => 'Teste de conteúdo',
            'status' => 'pendente'
        ]);

        try {
            $job = new ProcessEmailJob($email);
            $job->handle();
        } catch (\Exception $e) {
        }

        $this->assertEquals('erro', $email->fresh()->status);
    }
}
