<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * Armazena um novo usuário no banco de dados.
     *
     * @param  array  $data  Dados do usuário a serem armazenados.
     * @return array Dados do usuário criado.
     */
    public function store(array $data): array
    {
        $data['password'] = Hash::make((string)$data['password']);

        return User::create($data)->toArray();
    }

    /**
     * Exclui um usuário e retorna seus dados excluídos.
     *
     * @param  array  $data  Dados contendo o ID do usuário a ser excluído.
     * @return array Dados do usuário excluído ou um array vazio se não encontrado.
     */
    public function destroy(array $data): array
    {
        $user = User::findOrFail($data['id']);
        $user->delete();

        return User::onlyTrashed()->where('id', $data['id'])->first()?->toArray() ?? [];
    }

    /**
     * Restaura um usuário que foi excluído logicamente.
     *
     * @param  array  $data  Dados contendo o ID do usuário a ser restaurado.
     * @return array Retorna os dados do usuário restaurado ou um array vazio se o usuário não for encontrado.
     */
    public function restore(array $data): array
    {
        $user = User::onlyTrashed()->where('id', $data['id'])->first();

        if ($user) {
            $user->restore();
        }

        return $user ? $user->toArray() : [];
    }

    /**
     * Atualiza os dados do usuário com base no array fornecido.
     *
     * @param  array  $data  Dados do usuário a serem atualizados. A senha é opcional e será criptografada se fornecida.
     * @return array Dados atualizados do usuário como array ou um array vazio se o usuário não for encontrado.
     */
    public function update(array $data): array
    {
        // Guardar o ID e remover do array de atualização
        $id = $data['id'];
        unset($data['id']);

        // Se o password foi fornecido e não está vazio, fazer hash
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            // Remover password do array se não foi fornecido ou está vazio
            unset($data['password']);
        }

        // Usar findOrFail como os outros serviços e atualizar
        $user = User::query()->findOrFail($id);
        $user->update($data);

        // Retornar os dados atualizados
        return $user->fresh()->toArray();
    }

    /**
     * Retorna os dados do usuário com base no ID fornecido.
     *
     * @param  array  $data  Array contendo o ID do usuário.
     * @return array Dados do usuário em formato de array ou um array vazio se o usuário não for encontrado.
     */
    public function show(array $data): array
    {
        return User::find($data['id'])?->toArray() ?? [];
    }

    /**
     * Retorna uma lista paginada de usuários com base nos dados fornecidos.
     *
     * @param  array  $data  Dados de paginação, incluindo 'per_page' e 'page'.
     * @return array Lista paginada de usuários convertida para array.
     */
    public function index(array $data): array
    {
        return User::paginate($data['per_page'], ['*'], 'page', $data['page'])
            ->toArray();
    }
}
