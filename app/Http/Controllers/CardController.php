<?php

namespace App\Http\Controllers;

use App\Http\Requests\Card\StoreRequest;
use App\Http\Requests\Card\UpdateRequest;
use App\Http\Resources\CardResource;
use App\Models\Card;
use App\Services\CardService;
use Illuminate\Http\Request;

class CardController extends Controller
{
    protected CardService $cardService;

    public function __construct(CardService $cardService)
    {
        $this->cardService = $cardService;
    }

    public function index()
    {
        $cards = Card::with('likes')->paginate(9);
        return (CardResource::collection($cards))->toResponse(request());
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        $card = $this->cardService->createCard($validated, $request);
        return new CardResource($card);
    }

    public function show(Card $card)
    {
        return new CardResource($card);
    }

    public function update(UpdateRequest $request, Card $card)
    {
        $this->authorize('update', $card); // Проверка через Policy
        $validated = $request->validated();
        $card = $this->cardService->updateCard($card, $validated, $request);
        return new CardResource($card);
    }

    public function destroy(Card $card)
    {
        $this->authorize('delete', $card); // Проверка через Policy
        $this->cardService->deleteCard($card);
        return response()->json(['message' => 'Card deleted']);
    }
}
