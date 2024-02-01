<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewResource;
use App\Models\Restaurant;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function restaurantReviews(Restaurant $restaurant)
    {
        $reviews = $restaurant->reviews()->latest()->paginate();

        $restaurants = ReviewResource::collection($reviews)->response()->getData(true);

        return response()->json($restaurants);
    }

    public function reviewStore(Request $request, Restaurant $restaurant)
    {
        $request->validate([
            'comment' => 'required|string|min:3',
            'star_rating' => 'required|integer|min:1|max:5'
        ]);

        $review = new Review();

        $review->comment = $request->comment;
        $review->restaurant_id = $restaurant->id;
        $review->star_rating = $request->star_rating;
        $review->user_id = auth('api')->user()->id;
        $review->save();

        $review = new ReviewResource($review);
        return $this->sendResponse($review, 'Success!');
    }

    public function reviewUpdate(Request $request, Restaurant $restaurant, Review $review)
    {
        $request->validate([
            'comment' => 'required|string|min:3',
            'star_rating' => 'required|integer|min:1|max:5'
        ]);

        if ($review->user_id === auth('api')->user()->id) {
            $review->comment = $request->comment;
            $review->restaurant_id = $restaurant->id;
            $review->star_rating = $request->star_rating;
            $review->user_id = auth('api')->user()->id;
            $review->update();

            $review = new ReviewResource($review);
            return $this->sendResponse($review, 'Updated!');
        } else {
            return $this->sendError('You are not authorized to update this review!', 401);
        }
    }

    public function reviewDestroy(Restaurant $restaurant, Review $review)
    {
        if ($review->user_id === auth('api')->user()->id) {
            $review->delete();
            return $this->sendResponse([], 'Deleted!');
        } else {
            return $this->sendError('You are not authorized to delete this review!', 401);
        }
    }
}
