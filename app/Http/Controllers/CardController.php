<?php

namespace App\Http\Controllers;

use App\DTOs\CardDTO;
use App\Http\Requests\Card\StoreRequest;
use App\Http\Requests\Card\UpdateRequest;
use App\Http\Resources\CardResource;
use App\Models\Card;
use App\Services\AuthService;
use App\Services\CardService;
use Illuminate\Http\Request;

class CardController extends Controller
{

    public function index()
    {
        $cards = Card::with('likes')->paginate(9);

        return (CardResource::collection($cards))->toResponse(request());
    }

    public function store(StoreRequest $request, CardService $cardService)
    {
        $cardDTO = CardDTO::fromCreate($request->validated()) ;
        $card = $cardService->createCard($cardDTO);

        return new CardResource($card);
    }

    public function show(Card $card)
    {
        return new CardResource($card);
    }

    public function update(UpdateRequest $request, Card $card, CardService $cardService)
    {
        $this->authorize('update', $card); // Проверка через Policy


        $cardDTO = CardDTO::fromUpdate($request->validated(), $card);
        $card = $cardService->updateCard($card, $cardDTO);

        return new CardResource($card);
    }


    public function destroy(Card $card ,CardService $cardService)
    {
        $this->authorize('delete', $card); // Проверка через Policy
        $cardService->deleteCard($card);

        return response()->json(['message' => 'Card deleted']);
    }
}
