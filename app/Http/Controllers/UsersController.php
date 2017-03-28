<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\User;

class UsersController extends Controller
{

    protected $mensagens = [
        'required' => 'O campo :attribute é obrigatório',
        'max' => 'O campo :attribute pode ter no máximo 255 caracteres',
        'email' => 'Insira um endereço de e-mail válido',
        'unique' => 'Já existe um usuário com este nome no banco de dados',
        'min' => 'O campo :attribute deve ter no mínimo 6 dígitos',
        'confirmed' => 'As senhas informadas não são iguais'
    ];

    public function __construct()
    {

        // Middleware criado especificamente para verificar se o usuário é admin.
        // A classe se encontra em App/Http/Middleware/IsAdmin.php

        // O registro do alias 'isadmin' é feito no arquivo App/Http/Kernel.php
        // Na variável "$routeMiddleware"

        $this->middleware('isadmin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validar os dados recebidos

        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ], $this->mensagens);

        // Caso a validação seja feita com sucesso, cadastrar o usuário

        $usuario = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'is_admin' => $request->input('is_admin')
        ]);

        return redirect('usuarios/create')->with('mensagem', 'Usuário cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Obter o usuário especificado pelo ID

        $usuario = User::find($id);

        return view('users.edit', compact('usuario'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Obter o usuário especificado

        $usuario = User::find($id);

        // Validar os dados

        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($id),
            ],
            'password' => 'confirmed',
        ], $this->mensagens);

        // Alterar os dados

        $usuario->update($request->except('password'));

        // Tratar a senha apenas caso o usuário tenha tentado mudá-la
        // pois ela foi excluida dos campos enviados na linha acima
        // para evitar error de senha vazia

        if($request->has('password'))
        {
            $usuario->password = Hash::make($request->input('password'));
            $usuario->save();
        }

        // Redirecionar de volta para a tela de edição com a mensagem de sucesso

        return redirect("/usuarios/$id/edit")->with('mensagem', 'Usuário alterado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Encontrar...

        $usuario = User::find($id);

        // Deletar!

        $usuario->delete();
    }
}
