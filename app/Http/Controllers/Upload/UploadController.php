<?php

namespace App\Http\Controllers\Upload;

use App\Builder\ReturnApi;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UploadController extends Controller
{
    /**
     * Upload de imagem
     */
    public function upload(Request $request): JsonResponse
    {
        try {
            // Validação
            $request->validate([
                'image' => [
                    'required',
                    'image',
                    'mimes:jpeg,jpg,png,gif,webp',
                    'max:5120', // 5MB em KB
                ],
            ]);

            // Obter o arquivo
            $file = $request->file('image');

            // Gerar nome único para o arquivo
            $fileName = 'avatar_' . time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

            // Salvar o arquivo em storage/app/public/images usando o disco 'public'
            $path = $file->storeAs('images', $fileName, 'public');

            // Obter a URL base da requisição atual
            $scheme = $request->getScheme(); // http ou https
            $host = $request->getHost(); // localhost ou domínio
            $port = $request->getPort(); // porta (8000, 80, 443, etc)
            
            // Construir a URL base com porta
            // Se a porta não for detectada e for localhost, usar porta 8000 (padrão Laravel)
            $baseUrl = $scheme . '://' . $host;
            if ($port && $port !== 80 && $port !== 443) {
                $baseUrl .= ':' . $port;
            } elseif (!$port && ($host === 'localhost' || $host === '127.0.0.1')) {
                // Se não houver porta detectada e for localhost, assumir porta 8000
                $baseUrl .= ':8000';
            }
            
            // Construir a URL completa da imagem
            // O caminho relativo é 'images/nome_arquivo.ext'
            // A URL pública será /storage/images/nome_arquivo.ext
            $fullUrl = $baseUrl . '/storage/' . $path;

            // Retornar no formato esperado pelo front-end
            return response()->json([
                'url' => $fullUrl,
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            $firstError = $e->errors();
            $errorMessage = !empty($firstError) ? reset($firstError)[0] : 'Erro de validação';

            // Mapear mensagens de validação para mensagens mais amigáveis
            if (str_contains($errorMessage, 'image')) {
                $errorMessage = 'Arquivo não é uma imagem válida';
            } elseif (str_contains($errorMessage, 'mimes')) {
                $errorMessage = 'Tipo de arquivo não permitido. Use: jpg, jpeg, png, gif ou webp';
            } elseif (str_contains($errorMessage, 'max')) {
                $errorMessage = 'Arquivo muito grande. Tamanho máximo: 5MB';
            } elseif (str_contains($errorMessage, 'required')) {
                $errorMessage = 'Nenhum arquivo foi enviado';
            }

            return ReturnApi::error(
                message: $errorMessage,
                status: 422
            );

        } catch (\Exception $e) {
            return ReturnApi::error(
                message: 'Erro ao salvar arquivo no servidor: ' . $e->getMessage(),
                status: 500
            );
        }
    }
}

