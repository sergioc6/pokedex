<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class PokemonsController
{
    const API_POKEMONS = 'http://pokeapi.salestock.net/api/v2/pokemon/?limit=811';
    const API_POKEMONS_SPRITES = 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/';

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'page' => 'integer|gt:0',
            'page_size' => 'integer|gt:0',
            'search' => 'nullable|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Errors in request',
                'data' => $validator->errors()
            ], 404);
        }

        $page = $request->get('page', 1);
        $pageSize = $request->get('page_size', 15);
        $search = $request->get('search');

        $response = Http::get(self::API_POKEMONS);
        $responseJson = json_decode((string)$response->getBody(), true);
        $results = $responseJson['results'];

        $collection = collect($results);

        $collection->transform(function ($item, $key) {
            $url = $item['url'];
            $number = substr(filter_var($url, FILTER_SANITIZE_NUMBER_INT), 1);
            $item['number'] = (int)$number;
            $item['image'] = self::API_POKEMONS_SPRITES . $item['number'] . '.png';
            $item['name'] = ucfirst($item['name']);
            return $item;
        });

        if ($search) {
            $collection = $collection->filter(function ($value, $key) use ($search) {
                $result = true;
                if (is_numeric($search)) {
                    $result = ($search == $value['number']);
                } else {
                    $search = strtoupper($search);
                    $name = strtoupper($value['name']);
                    similar_text($search, $name, $percent);

                    $result = ($percent > 80);
                }
                return $result;
            });
        }

        $items = $collection->forPage($page, $pageSize);
        $items = array_values($items->toArray());
        $total = $collection->count();

        return response()->json([
            'status' => 'success',
            'message' => 'Pokemons returned',
            'data' => [
                'total' => $total,
                'page' => $page,
                'page_size' => $pageSize,
                'items' => $items
            ]
        ]);
    }

}
