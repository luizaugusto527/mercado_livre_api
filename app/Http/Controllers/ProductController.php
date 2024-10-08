<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    public function create()
    {

        return view('products.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:8',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'O campo Nome é obrigatório.',
            'description.required' => 'O campo Descrição é obrigatório.',
            'price.required' => 'O campo Preço é obrigatório.',
            'price.numeric' => 'O campo Preço deve ser um número válido.',
            'price.min' => 'O campo Preço deve ser um número maior que 8.',
            'quantity.required' => 'O campo Quantidade é obrigatório.',
            'quantity.integer' => 'O campo Quantidade deve ser um número inteiro.',
            'quantity.min' => 'O campo Quantidade deve ser um número positivo.',
            'category_id.required' => 'Selecione uma categoria.',
            'image.image' => 'O arquivo deve ser uma imagem.',
            'image.mimes' => 'A imagem deve estar em um dos formatos: jpeg, png, jpg ou gif.',
            'image.max' => 'A imagem não pode ser maior que 2MB.',
        ]);

        $imagePath = null;


        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        $token = $this->getAccessToken();


        $productData = [
            'title' => $validatedData['name'],
            'category_id' => $validatedData['category_id'],
            'price' => (float)$validatedData['price'],
            'currency_id' => 'BRL',
            'available_quantity' => (int)$validatedData['quantity'],
            'buying_mode' => 'buy_it_now',
            'condition' => 'new',
            'listing_type_id' => 'free',
            'pictures' => $imagePath ? [['source' => asset("storage/$imagePath")]] : [],
            'description' => [
                'plain_text' => $validatedData['description'],
            ],
        ];





        $response = Http::withToken($token)->post('https://api.mercadolibre.com/items', $productData);



        if ($response->successful()) {
            Product::create([
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
                'price' => $validatedData['price'],
                'quantity' => $validatedData['quantity'],
                'category_id' => $validatedData['category_id'],
                'image_url' => $imagePath ? asset("storage/$imagePath") : null,
            ]);

            return redirect()->back()->with('success', 'Produto cadastrado com sucesso!');
        }
        else {

            dd($response->body());

            return redirect()->back()->with('error', 'Erro ao cadastrar produto: ' . ($response->json()['message'] ?? $response->body()));
        }


    }


    private function getAccessToken()
    {

        $apiToken = DB::table('access_tokens')->first();


        if ($apiToken && now()->isBefore($apiToken->expires_at)) {
            return $apiToken->token;
        }


        $clientId = env('MERCADO_LIVRE_CLIENT_ID');
        $clientSecret = env('MERCADO_LIVRE_CLIENT_SECRET');

        $refreshToken = $apiToken->refresh_token;

        $response = Http::asForm()->post('https://api.mercadolibre.com/oauth/token', [
            'grant_type' => 'refresh_token',
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'refresh_token'=>$refreshToken
        ]);

        if ($response->successful()) {
            $token = $response->json()['access_token'];
            $refreshToken = $response->json()['refresh_token'];
            $expiresIn = $response->json()['expires_in'];


            DB::table('access_tokens')->updateOrInsert(
                ['id' => 1],
                [
                    'token' => $token,
                    'refresh_token' => $refreshToken,
                    'expires_at' => now()->addSeconds($expiresIn),
                ]
            );

            return $token;
        }else{
            throw new \Exception('Erro ao obter o token de acesso: ' . $response->body());

        }


    }


}

