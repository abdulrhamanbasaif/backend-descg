<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\AiDescriptionLog;
use App\Models\Product;
use App\Services\GeminiService;

class AiDescriptionLogController extends Controller
{
    public function index()
    {
        $logs = AiDescriptionLog::with('product')->get();
        return response()->json($logs);
    }

    public function show($id)
    {
        $log = AiDescriptionLog::with('product')->find($id);
        if (!$log) {
            return response()->json(['message' => 'Log not found'], 404);
        }
        return response()->json($log);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'generated_text' => 'required|string',
            'request_data' => 'nullable|array',
            'response_data' => 'nullable|array',
        ]);

        $log = AiDescriptionLog::create($validated);
        return response()->json([
            'message' => 'Log created successfully',
            'log' => $log
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $log = AiDescriptionLog::find($id);
        if (!$log) {
            return response()->json(['message' => 'Log not found'], 404);
        }
        $validated = $request->validate([
            'generated_text' => 'sometimes|string',
            'request_data' => 'sometimes|array',
            'response_data' => 'sometimes|array',
        ]);
        $log->update($validated);
        return response()->json([
            'message' => 'Log updated successfully',
            'log' => $log
        ]);
    }

    public function destroy($id)
    {
        $log = AiDescriptionLog::find($id);
        if (!$log) {
            return response()->json(['message' => 'Log not found'], 404);
        }
        $log->delete();
        return response()->json(['message' => 'Log deleted successfully']);
    }

    public function fetchByProduct(Request $request)
    {
        $productId = $request->input('product_id');
        if (!$productId) {
            return response()->json(['message' => 'Product ID is required'], 400);
        }

        $logs = AiDescriptionLog::where('product_id', $productId)->get();
        if ($logs->isEmpty()) {
            return response()->json(['message' => 'No logs found for the given product'], 404);
        }

        return response()->json(['logs' => $logs], 200);
    }

    public function generateDescription($id, GeminiService $geminiService)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        // Build a prompt string for Gemini
        $prompt = "Write a product description";
        if ($product->name) $prompt .= " for '{$product->name}'";
        if ($product->keywords) $prompt .= " using keywords: {$product->keywords}";
        if ($product->tone) $prompt .= " in a {$product->tone} tone";
        if ($product->length) $prompt .= " with a {$product->length} length.";
        $prompt .= ".";

        $apiData = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ]
        ];

        try {
            $response = $geminiService->describeProduct($apiData);
            // Adjust this if Gemini's response structure is different
            return response()->json(['description' => $response], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function testEnvironment()
    {
        return response()->json([
            'GEMINI_API_KEY' => env('GEMINI_API_KEY'),
            'GEMINI_API_URL' => env('GEMINI_API_URL')
        ]);
    }
}
