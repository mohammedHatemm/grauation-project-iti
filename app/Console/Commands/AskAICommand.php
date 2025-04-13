<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class AskAICommand extends Command
{
    protected $signature = 'ai:ask {question?}';
    protected $description = 'Ask OpenRouter AI a question. Use interactively or with a single question.';

    public function handle()
    {
        $question = $this->argument('question');

        if ($question) {
            // Single-prompt mode
            $this->sendToAI($question);
        } else {
            // Interactive mode
            $this->interactiveChat();
        }
    }

    private function sendToAI($message)
    {
        $this->info("Sending: \"$message\" to AI...");

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENROUTER_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post(env('OPENROUTER_API_URL'), [
            'model' => 'gpt-3.5-turbo', // Use the correct model
            'messages' => [['role' => 'user', 'content' => $message]],
        ]);

        $aiResponse = $response->json()['choices'][0]['message']['content'] ?? 'No response from AI.';
        $this->info("AI: $aiResponse");
    }

    private function interactiveChat()
    {
        $this->info("Interactive mode: Type 'exit' to quit.");

        while (true) {
            $message = $this->ask('You:');

            if ($message === 'exit') {
                $this->info('Goodbye!');
                break;
            }

            $this->sendToAI($message);
        }
    }
}


