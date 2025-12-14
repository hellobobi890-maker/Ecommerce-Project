<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    /**
     * Subscribe to newsletter
     */
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Check if already subscribed
        $existing = Subscriber::where('email', $request->email)->first();

        if ($existing) {
            if ($existing->is_active) {
                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Aap pehle se subscribe hain!'
                    ]);
                }
                return redirect()->back()->with('info', 'Aap pehle se subscribe hain!');
            } else {
                // Reactivate subscription
                $existing->update(['is_active' => true]);
                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Subscription dobara activate ho gayi!'
                    ]);
                }
                return redirect()->back()->with('success', 'Subscription dobara activate ho gayi!');
            }
        }

        Subscriber::create([
            'email' => $request->email,
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Subscribe ho gaye! Shukriya!'
            ]);
        }

        return redirect()->back()->with('success', 'Subscribe ho gaye! Shukriya!');
    }

    /**
     * Unsubscribe from newsletter
     */
    public function unsubscribe(Request $request)
    {
        $subscriber = Subscriber::where('email', $request->email)->first();

        if ($subscriber) {
            $subscriber->update(['is_active' => false]);
        }

        return redirect()->route('home')->with('success', 'Aap unsubscribe ho gaye.');
    }
}
