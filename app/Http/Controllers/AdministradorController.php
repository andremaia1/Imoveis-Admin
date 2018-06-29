<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Administrador;

class AdministradorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = Administrador::all();
        
        return view('administrador.admin_list', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $opcao = 1;
        
        return view('administrador.admin_form', compact('opcao'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $novo = Administrador::create([
            'nome' => $request['nome'],
            'email' => $request['email'],
            'password' => bcrypt($request['senha']),
            'telefone' => $request['telefone'],
        ]);
        
//        if ($novo) {
//            return redirect('/admin');
//        }
        
        return redirect('/admin');
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
        $registro = Administrador::find($id);
        
        $opcao = 2;
        
        return view('administrador.admin_form', compact('registro', 'opcao'));
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
        $registro = Administrador::find($id);
        
        $dados = $request->all();
        
        if ($registro->update($dados)) {
            return redirect('/admin');
        }
        return redirect('/admin');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $registro = Administrador::find($id);
        
        if ($registro->delete()) {
            return redirect('/admin');
        }
        return redirect('/admin');
    }
    
    public function login()
    {
        return view('auth.loginAdmin');
    }
    
    public function logar(Request $request)
    {
        $dados = ['email' => $request->get('email'), 'password' => $request->get('password')];
        
        if (Auth()->guard('administrador')->attempt($dados)) {
            return redirect('/admin');
        } else {
            return redirect('/admin/login')
                ->withErrors(['erroLogin' => 'Erro. Email ou senha inválidos!'])
                ->withInput();
        }
    }
    
    public function logout()
    {
        auth()->guard('administrador')->logout();
        return redirect('/admin/login');
    }
}
