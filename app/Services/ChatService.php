<?php

namespace App\Services;

use App\Models\ChatMessage;
use App\Models\Order;
use App\Models\ShippingRate;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class ChatService
{
  protected string $apiKey;
  protected string $apiUrl = 'https://openrouter.ai/api/v1/chat/completions';

  public function __construct()
  {
    $this->apiKey = config('services.openrouter.key');
    if (empty($this->apiKey)) {
      throw new \Exception('OpenRouter API key is not configured. Please set OPENROUTER_API_KEY in your .env file.');
    }
  }

  public function sendMessage(User $user, string $message): ChatMessage
  {
    // Store user message
    $userMessage = $this->storeMessage($user, 'user', $message);

    // Get relevant context data
    $contextData = $this->getContextData($user);

    // Prepare conversation history
    $history = $this->getRecentHistory($user);

    // Prepare system message with context
    $systemMessage = $this->prepareSystemMessage($contextData);

    try {
      // Send to OpenRouter API
      $response = Http::timeout(30)->withHeaders([
        'Authorization' => 'Bearer ' . $this->apiKey,
        'HTTP-Referer' => config('app.url'),
      ])->post($this->apiUrl, [
        'model' => 'mistralai/mistral-7b-instruct',
        'messages' => array_merge([
          ['role' => 'system', 'content' => $systemMessage]
        ], $history, [
          ['role' => 'user', 'content' => $message]
        ]),
        'temperature' => 0.7,
        'max_tokens' => 500
      ]);
    } catch (\Exception $e) {
      throw new \Exception('Failed to connect to OpenRouter API: ' . $e->getMessage());
    }

    if ($response->successful()) {
      $aiResponse = $response->json()['choices'][0]['message']['content'] ?? '';
      return $this->storeMessage($user, 'assistant', $aiResponse);
    }

    throw new \Exception('Failed to get response from AI: ' . $response->body());
  }

  protected function storeMessage(User $user, string $role, string $content): ChatMessage
  {
    return ChatMessage::create([
      'user_id' => $user->id,
      'role' => $role,
      'content' => $content,
      'context_data' => $role === 'user' ? $this->getContextData($user) : null
    ]);
  }

  protected function getContextData(User $user): array
  {
    // Get user's recent orders and shipping rates
    $recentOrders = Order::where('user_id', $user->id)
      ->latest()
      ->take(5)
      ->get();

    $shippingRates = ShippingRate::all();

    return [
      'recent_orders' => $recentOrders->map(function ($order) {
        return [
          'id' => $order->id,
          'status' => $order->status,
          'shipping_type' => $order->shipping_type,
          'shipping_cost' => $order->shipping_cost,
          'created_at' => $order->created_at->toDateTimeString()
        ];
      })->toArray(),
      'shipping_rates' => $shippingRates->map(function ($rate) {
        return [
          'type' => $rate->type,
          'base_cost' => $rate->base_cost,
          'additional_cost' => $rate->additional_cost
        ];
      })->toArray()
    ];
  }

  protected function getRecentHistory(User $user): array
  {
    return ChatMessage::where('user_id', $user->id)
      ->latest()
      ->take(5)
      ->get()
      ->reverse()
      ->map(function ($message) {
        return [
          'role' => $message->role,
          'content' => $message->content
        ];
      })
      ->toArray();
  }

  protected function prepareSystemMessage(array $contextData): string
  {
    return "You are a helpful shipping assistant. You have access to the following information:\n" .
      "Recent orders: " . json_encode($contextData['recent_orders']) . "\n" .
      "Shipping rates: " . json_encode($contextData['shipping_rates']) . "\n\n" .
      "Please help users with their shipping-related questions, explain shipping costs, " .
      "and provide information about their orders. Be concise and professional.";
  }
}
