<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthApiController extends Controller
{
    //
    public function loginView()
    {
        return view('welcome');
    }

    public function registerView()
    {
        return view('register');
    }

    public function login(Request $request) 
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string|min:8|max:16',
        ]);
 
        $response = Http::post('http://127.0.0.1:8000/api/auth/login',[
            'email'    => $request->email,
            'password' => $request->password,
        ]);
        
        $data = $response->json();

        if ($response->successful()) 
        {
            $data = $response->json();

            \Log::info('funcionoo entroooo');

            session([
                'token' => $data['token'],
                'email'  => $request->email,
            ]);

            return redirect()->route('news.index');
        }

    }

    public function register(Request $request) 
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email',
            'password' => 'required|string|min:8|max:16',
            'phone'    => 'required|string|max:12'
        ]);
 
        $response = Http::post('http://127.0.0.1:8000/api/auth/register',[
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $request->password,
            'phone'    => $request->phone,
        ]);
        
        $data = $response->json();
        \Log::info($data);
        
        if ($response->successful()) 
        {
            $data = $response->json();

            session([
                'token' => $data['token'],
            ]);

            return redirect()->route('login');
        }

    }

    public function news() 
    {
        $token = session('token');

        $response = Http::withToken($token)->get('http://127.0.0.1:8000/api/news');
        
        $data = $response->json();
        //\Log::info($data);
        
        if ($response->successful()) 
        {
            $data = $response->json();
            return view('news', compact('data'));
        }

    }

    public function newsDetail($id) 
    {
        $token = session('token');

        $response = Http::withToken($token)->get('http://127.0.0.1:8000/api/news/' . $id . '/settings');
        
        $data = $response->json();
        
        if ($response->successful()) 
        {
            $data = $response->json();
            $category_id = $data['category_id'] ?? 1;
            
            $related  = Http::withToken($token)->get('http://127.0.0.1:8000/api/news/related/' . $id);
            $recomended = $related->json();
           // \Log::info($recomended);
    
            return view('detail', compact('data', 'recomended'));
        }

    }
}
