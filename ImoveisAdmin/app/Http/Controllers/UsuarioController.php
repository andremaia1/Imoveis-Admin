<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuario;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('usuario.imoveis_list');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reg = Usuario::find($id);
        
        return view('administrador.usuario_view', compact('reg'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    public function lista()
    {
        $usuarios = Usuario::all();
        
        return view('administrador.usuarios_list', compact('usuarios'));
    }
    
    public function alterarStatus($id)
    {
        $usuario = Usuario::find($id);
        
        $usuario->ativo = ($usuario->ativo === 0) ? 1 : 0;
        
        if ($usuario->update()) {
            return redirect('usuarios/lista');
        }
    }
    
    public function login()
    {
        return view('auth.loginUsuario');
    }
    
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
    
    public function logout()
    {
        auth()->guard('usuario')->logout();
        return redirect('/');
    }
}
