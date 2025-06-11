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
        $user = User::find($data['id']);
        if ($user instanceof User) {
            $user->delete();
        }

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
     * @param  array  $data  Dados do usuário a serem atualizados, incluindo a senha que será criptografada.
     * @return array Dados atualizados do usuário como array ou um array vazio se o usuário não for encontrado.
     */
    public function update(array $data): array
    {
        $data['password'] = Hash::make($data['password']);

        User::where('id', $data['id'])->update($data);

        return User::find($data['id'])?->toArray() ?? [];
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
