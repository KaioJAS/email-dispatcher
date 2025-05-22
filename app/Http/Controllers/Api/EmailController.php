<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEmailRequest;
use App\Http\Resources\EmailResource;
use App\Models\Email;
use App\Jobs\ProcessEmailJob;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function index(Request $request)
    {

        $perPage = $request->get('per_page', 15);

        $emails = Email::query()
            ->with('user')
            ->latest('created_at')
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => EmailResource::collection($emails)->response()->getData(true),
        ]);
    }

    public function store(CreateEmailRequest $request)
    {
        $email = Email::create([
            'titulo' => $request->titulo,
            'remetente' => $request->remetente,
            'remetente_id' => auth()->id(),
            'destinatarios' => $request->destinatarios_array,
            'conteudo' => $request->conteudo,
            'status' => 'pendente',
        ]);

        ProcessEmailJob::dispatch($email);

        return response()->json([
            'success' => true,
            'data' => new EmailResource($email),
            'message' => 'Email criado e agendado para envio com sucesso!'
        ], 201);
    }

    public function show(Email $email)
    {
        return response()->json([
            'success' => true,
            'data' => new EmailResource($email->load('user'))
        ]);
    }

    public function destroy(Email $email)
    {
        $email->delete();

        return response()->json([
            'success' => true,
            'message' => 'Email deletado com sucesso!'
        ]);
    }
}