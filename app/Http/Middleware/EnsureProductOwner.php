<?php

namespace App\Http\Middleware;

use App\Models\Product;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureProductOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $product = $request->route('product'); // Get product ID from route
        // $product = Product::find($productId);
        if (!$product || $product->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized access.'], 403);
        }

        return $next($request);
    }
}
