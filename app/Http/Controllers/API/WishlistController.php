<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseBuilder;
use App\Http\Controllers\Controller;
use App\Models\UserSavedPlace;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function post(int $place_id)
    {
        $user = Auth::user();
        UserSavedPlace::create([
            'user_id' => $user->id,
            'place_id' => $place_id,
        ]);

        return ResponseBuilder::success(null, "Place added to wishlist");
    }

    public function delete(int $place_id)
    {
        $user = Auth::user();
        UserSavedPlace::where('user_id', $user->id)
            ->where('place_id', $place_id)
            ->first()
            ->delete();

        return ResponseBuilder::success(null, "Place removed from wishlist");
    }

    public function get()
    {
        $user = Auth::user();
        $user_wishlist = UserSavedPlace::where('user_id', $user->id)->get();

        $places = [];
        foreach ($user_wishlist as $wishlist_item) {
            $place = $wishlist_item->places()->with('place_images')->first();
            $place->img_urls = $place->place_images->pluck('img_url');
            unset($place->place_images);
            array_push($places, $place);
        }

        return ResponseBuilder::success($places, "Wishlist retrieved");
    }
}