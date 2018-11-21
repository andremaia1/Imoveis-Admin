<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuario;
use App\Imovel;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $idUsuario = auth()->guard('usuario')->getUser()->id;
        
        $imoveis = Imovel::where('usuario_id', $idUsuario)->get();
        
        return view('imoveis_list', compact('imoveis'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $usuario = Usuario::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'telefone' => $request->telefone,
            'ativo' => 1
        ]);
        
        if ($usuario) {
            
            $dados = ['email' => $request->email, 'password' => $request->password];
            
            if (Auth()->guard('usuario')->attempt($dados)) {
                return redirect('/usuario');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //Função acessada pelo(s) administrador(es) para visualização do usuário
    public function show($id)
    {
        $usuario = Usuario::find($id);
        
        $numImoveis = Imovel::where('usuario_id', $id)->count();
        
        return view('administrador.usuario_view', compact('usuario', 'numImoveis'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $usuario = Usuario::find($id);
        
        return view('usuario.usuario_form', compact('usuario'));
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
        $usuario = Usuario::find($id);
        
        $dados = $request->all();
        
        if ($usuario->update($dados)) {
            return redirect('/usuario');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $usuario = Usuario::find($id);
        
        auth()->guard('usuario')->logout();
        
        if ($usuario->delete()) {
            return redirect('/');
        }
    }
    
    /*
    //Início das funções que são acessadas pelos administradores
    */
    
    //Lista os usuários do sistema na área administrativa
    public function lista()
    {
        $usuarios = Usuario::all();
        
        return view('administrador.usuarios_list', compact('usuarios'));
    }
    
    //Lista os imóveis de um usuário na área administrativa
    public function listaImoveisToAdmin($id)
    {
        $usuario = Usuario::find($id);
        
        $imoveis = Imovel::where('usuario_id', $id)->get();
        
        return view('imoveis_list', compact('imoveis', 'usuario'));
    }
    
    //Permite a visualização de um imóvel na área administrativa
    public function verImovelAdmin($id)
    {
        $imovel = Imovel::find($id);
        
        return view('imovel_view', compact('imovel'));
    }
    
    //Altera o status do usuário (ativo ou inativo) na área administrativa
    public function alterarStatus($id)
    {
        $usuario = Usuario::find($id);
        
        $usuario->ativo = ($usuario->ativo === 0) ? 1 : 0;
        
        if ($usuario->update()) {
            return redirect('usuarios/lista');
        }
    }
    /*
    //Término das funções que são acessadas pelos administradores
    */
    
    //Retorna o formulário de login do usuário
    public function login()
    {
        return view('auth.loginUsuario');
    }
    
    //Faz a autenticação do usuário
    public function logar(Request $request)
    {
        $dados = ['email' => $request->get('email'), 'password' => $request->get('password')];
        
        if (Auth()->guard('usuario')->attempt($dados)) {
            
            if (auth()->guard('usuario')->getUser()->ativo === 1) {
                return redirect('/usuario');
            } else {
                auth()->guard('usuario')->logout();
                
                return redirect('/')
                ->withErrors(['erroLogin' => 'Erro. Esta conta foi desativada!'])
                ->withInput();
            }
        } else {
            return redirect('/')
                ->withErrors(['erroLogin' => 'Erro. Email ou senha inválidos!'])
                ->withInput();
        }
    }
    
    //Desloga um usuário do sistema
    public function logout()
    {
        auth()->guard('usuario')->logout();
        return redirect('/');
    }
}
