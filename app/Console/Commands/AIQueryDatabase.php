<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class AIQueryDatabase extends Command
{
    protected $signature = 'ai:query
                            {question? : The natural language question to translate into SQL}
                            {--show-sql : Display the generated SQL query}
                            {--format=table : Output format (table, json, or csv)}
                            {--limit=50 : Maximum number of results to return}
                            {--model=openai/gpt-3.5-turbo : AI model to use}';

    protected $description = 'Allow AI to interpret a question, generate an SQL query, and return results.';

    public function handle()
    {
        $question = $this->argument('question');
        $showSql = $this->option('show-sql');
        $format = $this->option('format');
        $limit = (int)$this->option('limit');
        $model = $this->option('model');

        if (!$question) {
            $question = $this->ask('What would you like to know about your database?');
        }

        // Display a spinner while waiting for AI
        $this->output->write('<info>Generating SQL query...</info>');

        try {
            $apiKey = env('OPENROUTER_API_KEY');
            if (empty($apiKey)) {
                $this->error("\nOpenRouter API key is not set in .env file");
                return 1;
            }

            // Call AI with correct authentication headers
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'HTTP-Referer' => 'https://your-app-domain.com', // Required for OpenRouter
                'Content-Type' => 'application/json',
            ])->post('https://openrouter.ai/api/v1/chat/completions', [
                'model' => $model,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a SQL expert. Convert the user question into a valid MySQL query. Return ONLY the raw SQL query with no explanation, no markdown formatting, and no code blocks. Always begin with SELECT.'
                    ],
                    ['role' => 'user', 'content' => $question]
                ],
            ]);

            // Check if the request was successful
            if (!$response->successful()) {
                $this->error("\nAPI request failed with status code: " . $response->status());
                $this->error("Response body: " . $response->body());
                return 1;
            }

            $aiResponse = $response->json();
            
            // Extract and clean the SQL query
            $responseContent = $aiResponse['choices'][0]['message']['content'] ?? '';

            // Remove any markdown code blocks, backticks, or "sql" language specifiers
            $sql = trim(preg_replace('/```sql|```| \n /s', '', $responseContent));

            // Ensure proper spacing between SQL elements
            $sql = preg_replace('/\*FROM/', '* FROM', $sql);
            $sql = preg_replace('/FROM(\w)/', 'FROM $1', $sql);
            $sql = preg_replace('/(\w)WHERE/', '$1 WHERE', $sql);

            // Clear the spinner line
            $this->output->write("\r" . str_repeat(" ", 100) . "\r");

            // Ensure it's a valid query
            if (empty($sql)) {
                $this->error("AI returned an empty SQL query.");
                return 1;
            }

            if (!str_starts_with(strtolower($sql), 'select')) {
                $this->error("AI generated an invalid query that doesn't start with SELECT: " . $sql);
                return 1;
            }

            // Add LIMIT if not already present and if it's a regular SELECT query
            // Don't add LIMIT to aggregate functions like COUNT, SUM, etc.
            $originalSql = $sql;
            if ($limit > 0 && stripos($sql, 'LIMIT') === false) {
                // Check if it's an aggregate query
                $isAggregateQuery = preg_match('/\b(COUNT|SUM|AVG|MIN|MAX)\s*\(/i', $sql);

                if (!$isAggregateQuery) {
                    // Remove any trailing semicolons before adding LIMIT
                    $sql = rtrim(rtrim($sql), ';');
                    $sql .= " LIMIT $limit";
                }
            }

            // Show the generated SQL if requested
            if ($showSql || $this->output->isVerbose()) {
                $this->line("\n<comment>Generated SQL:</comment>");
                $this->line($originalSql);

                if ($originalSql !== $sql) {
                    $this->line("\n<comment>Modified SQL (with LIMIT):</comment>");
                    $this->line($sql);
                }

                $this->newLine();
            }

            // Execute the SQL query
            $this->info("Executing query...");
            $result = DB::select($sql);

            // Output results in the requested format
            switch (strtolower($format)) {
                case 'json':
                    if (empty($result)) {
                        $this->info("No results found.");
                        break;
                    }
                    $this->line(json_encode($result, JSON_PRETTY_PRINT));
                    break;

                case 'csv':
                    if (empty($result)) {
                        $this->info("No results found.");
                        break;
                    }

                    // Get headers from first row
                    $headers = array_keys((array)$result[0]);
                    $this->line(implode(',', $headers));

                    // Output each row as CSV
                    foreach ($result as $row) {
                        $rowArray = (array)$row;
                        $this->line(implode(',', array_values($rowArray)));
                    }
                    break;

                case 'table':
                default:
                if (empty($result)) {
                    $this->info("No results found.");
                    break;
                }
                $this->table(
                    empty($result) ? [] : array_keys((array)$result[0]),
                    array_map(function($item) {
                        return (array)$item;
                    }, $result)
                );
                    break;
            }

            return 0;
        } catch (\Exception $e) {
            $this->output->write("\r" . str_repeat(" ", 100) . "\r"); // Clear spinner
            $this->error("Error: " . $e->getMessage());
            if ($this->output->isVerbose()) {
                $this->error("SQL that caused the error: " . ($sql ?? 'Unknown'));
            }
            return 1;
        }
    }
}
