<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseBuilder;
use App\Http\Controllers\Controller;
use App\Models\Place;
use App\Models\PlaceImage;
use App\Models\UserRatedPlace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PlaceController extends Controller
{
    public function post(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'location' => 'required|string',
            'description' => 'required|string',
            'img_urls' => 'required|array',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return ResponseBuilder::error($validator->errors()->all(), 422);
        }

        $place = Place::create([
            'author_id' => Auth::user()->id,
            'name' => $request->name,
            'location' => $request->location,
            'description' => $request->description,
        ]);

        $response = json_decode($request->getContent());
        $response->id = $place->id;
        $response->rated_by_count = $place->user_rated_places()->count();
        foreach ($request->img_urls as $img_url) {
            $place_image = PlaceImage::create([
                'place_id' => $place->id,
                'img_url' => $img_url,
            ]);
            array_push($response->img_urls, $place_image->img_url);
        }

        return ResponseBuilder::success($response, "Place created");
    }

    public function get(Request $request)
    {
        $sort_param = $request->input('sort_by');
        $order_by = $sort_param == 'rating' ? 'rating' : 'created_at';

        $response = new Place;
        if ($s = $request->input('keyword')) {
            $response = Place::with('place_images')
                ->where('location', 'like', '%' . $s . '%')
                ->orWhere('name', 'like', '%' . $s . '%')
                ->orderBy($order_by, 'desc')
                ->paginate(9);
        } else {
            $response = Place::with('place_images')
                ->orderBy($order_by, 'desc')
                ->paginate(9);
        }

        foreach ($response as $place) {
            $place->rated_by_count = $place->user_rated_places()->count();
            $place->img_urls = $place->place_images->pluck('img_url');
            unset($place->place_images);
        }

        return ResponseBuilder::success($response, "Success");
    }

    public function get_by_id(int $id)
    {
        $response = Place::with('place_images')->find($id);
        $response->img_urls = $response->place_images->map(function ($place_image) {
            return $place_image->img_url;
        });
        $response->rated_by_count = $response->user_rated_places()->count();
        unset($response->place_images);

        return ResponseBuilder::success($response, "Success");
    }

    public function get_by_user()
    {
        $user = Auth::user();
        $places = Place::with('place_images')->where('author_id', $user->id)->get();
        foreach ($places as $place) {
            $place->rated_by_count = $place->user_rated_places()->count();
            $place->img_urls = $place->place_images->pluck('img_url');
            unset($place->place_images);
        }

        return response()->json($places);
    }

    public function update(int $id, Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'location' => 'required|string',
            'description' => 'required|string',
            'img_urls' => 'array',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return ResponseBuilder::error($validator->errors()->all(), 422);
        }

        $place = Place::find($id);
        $place->name = $request->name;
        $place->location = $request->location;
        $place->description = $request->description;
        $place->save();

        $response = json_decode($request->getContent());
        $response->id = $place->id;
        $response->rated_by_count = $place->user_rated_places()->count();
        foreach ($request->img_urls as $img_url) {
            $place_image = PlaceImage::firstOrCreate([
                'place_id' => $place->id,
                'img_url' => $img_url,
            ]);
            array_push($response->img_urls, $place_image->img_url);
        }

        return ResponseBuilder::success($response, "Place updated");
    }

    public function delete(int $id)
    {
        $place = Place::find($id);
        $place->delete();

        return ResponseBuilder::success(null, "Place deleted");
    }

    public function rate(int $id, Request $request)
    {

        $validator = Validator::make($request->all(), [
            'rating' => 'required|int|min:0|max:5',
        ]);
        if ($validator->fails()) {
            return ResponseBuilder::error($validator->errors()->all(), 422);
        }

        UserRatedPlace::updateOrCreate([
            'user_id' => Auth::user()->id,
            'place_id' => $id,
        ], ['rating' => $request->rating]);

        $place = Place::find($id);
        $new_rating = $place->user_rated_places()->avg('rating');
        $place->rating = $new_rating;
        $place->save();

        $place->rated_by_count = $place->user_rated_places()->count();

        return ResponseBuilder::success($place, "Place rated");
    }
}