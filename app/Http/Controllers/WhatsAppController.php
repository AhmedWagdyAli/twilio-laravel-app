<?php

namespace App\Http\Controllers;

use App\Services\TwilioService;
use Illuminate\Http\Request;

class WhatsAppController extends Controller
{
    protected $twilioService;

    public function __construct(TwilioService $twilioService)
    {
        $this->twilioService = $twilioService;
    }

    public function sendMessage(Request $request)
    {
        $validated = $request->validate([
            'to' => 'required|string',
            'message' => 'required|string',
        ]);

        try {
            $sid = $this->twilioService->sendWhatsAppMessage($validated['to'], $validated['message']);
            return response()->json(['success' => true, 'message_sid' => $sid]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function sendMessagePage(Request $request)
    {
        return view('send-whatsapp-message');
    }
}
