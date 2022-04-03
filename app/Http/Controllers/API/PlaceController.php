<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Place;
use App\Models\PlaceImage;
use App\Models\UserRatedPlace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlaceController extends Controller
{
    public function post(Request $request)
    {
        $validated_data = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string',
            'description' => 'required|string',
            'img_urls' => 'required|array',
        ]);

        $place = Place::create([
            'author_id' => Auth::user()->id,
            'name' => $validated_data['name'],
            'location' => $validated_data['location'],
            'description' => $validated_data['description'],
        ]);

        $response = json_decode($request->getContent());
        foreach ($validated_data['img_urls'] as $img_url) {
            $place_image = PlaceImage::create([
                'place_id' => $place->id,
                'img_url' => $img_url,
            ]);
            array_push($response->img_urls, $place_image->img_url);
        }

        return response()->json($response);
    }

    public function get(Request $request)
    {
        $page = $request->input('page') || 1;
        $limit = $page == 1 ? 9 : $page * 9;
        $offset = $page == 1 ? 0 : $page * $limit;

        $sort_param = $request->input('sort_by');
        $order_by = $sort_param == 'rating' ? 'rating' : 'created_at';

        $response = new Place;
        if ($s = $request->input('keyword')) {
            $response = Place::with('place_images')
                ->where('location', 'like', '%' . $s . '%')
                ->orWhere('name', 'like', '%' . $s . '%')
                ->orderBy($order_by, 'desc')
                ->offset($offset)
                ->limit($limit)
                ->get();
        } else {
            $response = Place::with('place_images')
                ->orderBy($order_by, 'desc')
                ->offset($offset)
                ->limit($limit)
                ->get();
        }

        foreach ($response as $place) {
            $place->img_urls = $place->place_images->pluck('img_url');
            unset($place->place_images);
        }

        return response()->json($response);
    }

    public function get_by_id(int $id)
    {
        $place = Place::with('place_images')->find($id);
        $place->img_urls = $place->place_images->map(function ($place_image) {
            return $place_image->img_url;
        });
        unset($place->place_images);

        return response()->json($place);
    }

    public function get_by_user()
    {
        $user = Auth::user();
        $places = Place::with('place_images')->where('author_id', $user->id)->get();
        foreach ($places as $place) {
            $place->img_urls = $place->place_images->pluck('img_url');
            unset($place->place_images);
        }

        return response()->json($places);
    }

    public function update(int $id, Request $request)
    {
        $validated_data = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string',
            'description' => 'required|string',
            'img_urls' => 'required|array',
        ]);

        $place = Place::find($id);
        $place->name = $validated_data['name'];
        $place->location = $validated_data['location'];
        $place->description = $validated_data['description'];
        $place->save();

        $response = json_decode($request->getContent());
        foreach ($validated_data['img_urls'] as $img_url) {
            $place_image = PlaceImage::firstOrCreate([
                'place_id' => $place->id,
                'img_url' => $img_url,
            ]);
            array_push($response->img_urls, $place_image->img_url);
        }

        return response()->json($response);
    }

    public function delete(int $id)
    {
        $place = Place::find($id);
        $place->delete();

        return response()->json(['message' => 'Place deleted']);
    }

    public function rate(int $id, Request $request)
    {
        $validated_data = $request->validate([
            'rating' => 'required|int|min:0|max:5',
        ]);

        UserRatedPlace::updateOrCreate([
            'user_id' => Auth::user()->id,
            'place_id' => $id,
        ], ['rating' => $validated_data['rating']]);

        $place = Place::find($id);
        $new_rating = $place->user_rated_places()->avg('rating');
        $place->rating = $new_rating;
        $place->save();

        return response()->json(['message' => 'Rating updated']);
    }
}