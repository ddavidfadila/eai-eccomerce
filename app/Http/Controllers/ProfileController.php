<?php
namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . request()->cookie('auth-token'),
        ])->get('http://127.0.0.1:8080/api/cart');

        $cartRes = $response->json();
        $carts = [];

        // Periksa apakah $cartRes bukan null dan memiliki kunci 'status'
        if ($cartRes !== null && isset($cartRes['status'])) {
            if ($cartRes['status'] == 200) {
                $carts = $cartRes['data'];
            } else {
                // Log pesan kesalahan atau tambahkan penanganan error
                // contoh: Log::error('API error: ' . $cartRes['message']);
            }
        } else {
            // Handle jika $cartRes null atau tidak memiliki kunci 'status'
            // contoh: Log::error('API response is null or missing status key');
        }

        return view('profile.edit', [
            'jwt' => request()->cookie('auth-token'),
            'user' => $request->user(),
            'carts' => $carts,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
