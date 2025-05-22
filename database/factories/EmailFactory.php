<?php

namespace Database\Factories;

use App\Models\Email;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmailFactory extends Factory
{
    protected $model = Email::class;

    public function definition()
    {
        $status = $this->faker->randomElement(['pendente', 'enviado', 'erro']);
        
        return [
            'titulo' => $this->faker->sentence(),
            'remetente' => $this->faker->email,
            'remetente_id' => User::factory(),
            'destinatarios' => [$this->faker->email, $this->faker->email],
            'conteudo' => $this->faker->paragraph(),
            'status' => $status,
            'enviado_em' => $status === 'enviado' ? now() : null,
        ];
    }

    public function pendente()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'pendente',
                'enviado_em' => null,
            ];
        });
    }

    public function enviado()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'enviado',
                'enviado_em' => now(),
            ];
        });
    }

    public function erro()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'erro',
                'enviado_em' => null,
            ];
        });
    }
}