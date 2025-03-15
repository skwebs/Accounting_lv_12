<?php


namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    private $orderBy = 'created_at';
    private $orderDir = 'desc';
    private $allowedColumns = ['created_at', 'title', 'id'];

    public function index(Request $request)
    {
        $query = Post::query();

        if ($request->has('orderBy') && in_array($request->orderBy, $this->allowedColumns)) {
            $this->orderBy = $request->orderBy;
        }
        if ($request->has('orderDir') && in_array(strtolower($request->orderDir), ['asc', 'desc'])) {
            $this->orderDir = strtolower($request->orderDir);
        }

        $query->orderBy($this->orderBy, $this->orderDir);

        if ($request->has('limit')) {
            $query->limit($request->limit);
        }

        return response()->json(['data' => $query->get(), 'message' => 'Posts retrieved.'], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:posts',
            'content' => 'required|string',
            'user_id' => ['required', Rule::exists('users', 'id')],
        ]);


        $post = Post::create($validated);
        return response()->json(['data' => $post, 'message' => 'Post created.'], 201);
    }

    public function show($id)
    {
        $post = Post::find($id);
        return $post ? response()->json(['data' => $post, 'message' => 'Post retrieved.'], 200) :
            response()->json(['message' => 'Post not found.'], 404);
    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['message' => 'Post not found.'], 404);
        }

        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
        ]);

        $post->update($validated);
        return response()->json(['data' => $post, 'message' => 'Post updated.'], 200);
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['message' => 'Post not found.'], 404);
        }
        $post->delete();
        return response()->json(['message' => 'Post deleted.'], 200);
    }

    public function trashed()
    {
        $posts = Post::onlyTrashed()->get();
        return $posts->isEmpty() ? response()->json(['message' => 'Trashed posts not found.'], 404) :
            response()->json(['data' => $posts, 'message' => 'Trashed posts retrieved.'], 200);
    }

    public function restore($id)
    {
        $post = Post::onlyTrashed()->find($id);
        if (!$post) {
            return response()->json(['message' => 'Post not found.'], 404);
        }
        $post->restore();
        return response()->json(['data' => $post, 'message' => 'Post restored.'], 200);
    }

    public function restoreAll()
    {
        Post::onlyTrashed()->restore();
        return response()->json(['message' => 'All trashed posts restored.'], 200);
    }

    public function forceDelete($id)
    {
        $post = Post::withTrashed()->find($id);
        if (!$post) {
            return response()->json(['message' => 'Post not found.'], 404);
        }
        $post->forceDelete();
        return response()->json(['message' => 'Post deleted permanently.'], 200);
    }

    public function forceDeleteAllTrashed()
    {
        Post::onlyTrashed()->forceDelete();
        return response()->json(['message' => 'All trashed posts deleted permanently.'], 200);
    }

    public function search(Request $request)
    {
        $posts = Post::search($request->keyword)->get();
        return response()->json($posts);
    }
}


// namespace App\Http\Controllers\API;

// use App\Http\Controllers\Controller;
// use App\Models\Post;
// use Illuminate\Http\Request;
// use Illuminate\Validation\Rule;

// class PostController extends Controller
// {
//     private $orderBy = 'created_at';
//     private $orderDir = 'desc';
//     private $allowedColumns = ['created_at', 'title', 'id'];

//     /**
//      * Display a listing of the resource.
//      *
//      * The index method retrieves all of the posts from the database and returns
//      * them in a JSON response. The method also accepts the following query
//      * parameters:
//      *
//      * - orderBy: specifies the column to order the results by. The default is
//      *   created_at.
//      *
//      * - orderDir: specifies the direction of the ordering. The default is desc.
//      *
//      * - limit: specifies the maximum number of posts to return.
//      */
//     public function index(Request $request)
//     {
//         // Start building the query
//         $query = Post::query();

//         // Apply ordering
//         if ($request->has('orderBy')) {
//             // Check if the specified column is in the allowed columns list
//             if (in_array($request->orderBy, $this->allowedColumns)) {
//                 // Update the orderBy variable to the specified column
//                 $this->orderBy = $request->orderBy;
//             }
//         }
//         if ($request->has('orderDir')) {
//             // Check if the specified direction is a valid direction
//             if (in_array(strtolower($request->orderDir), ['asc', 'desc'])) {
//                 // Update the orderDir variable to the specified direction
//                 $this->orderDir = strtolower($request->orderDir);
//             }
//         }

//         // Apply the ordering to the query
//         $query->orderBy($this->orderBy, $this->orderDir);

//         // If the limit query parameter is specified, apply it
//         if ($request->has('limit')) {
//             // Update the query to only return the specified number of records
//             $query->limit($request->limit);
//         }

//         // Execute the query and return the results
//         return response()->json(['data' => $query->get(), 'message' => 'Posts retrieved.'], 200);
//     }

//     /**
//      * Store a newly created resource in storage.
//      *
//      * This method validates the incoming request data according to the
//      * following rules:
//      *
//      * - title: The title of the post is optional, must be a string, and must
//      *   not exceed a maximum length of 255 characters.
//      *
//      * - content: The content of the post is optional, must be a string.
//      *
//      * - user_id: The user ID of the post is required and must exist in the
//      *   users table.
//      *
//      * If the validation is successful, the method creates a new Post model
//      * instance with the validated data and saves it to the database. The
//      * method then returns a JSON response with the post data and a success
//      * message.
//      *
//      * @param Request $request The incoming request instance containing data to store
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function store(Request $request)
//     {
//         // Validate the incoming request data
//         $validated = $request->validate([
//             'title' => 'nullable|string|max:255',
//             'content' => 'nullable|string',
//             'user_id' => ['required', Rule::exists('users', 'id')],
//         ]);

//         // Create a new Post model instance with the validated data
//         $post = Post::create($validated);

//         // Return a JSON response with the post data and a success message
//         return response()->json(['data' => $post, 'message' => 'Post created.'], 201);
//     }

//     /**
//      * Display the specified resource.
//      *
//      * @param int $id The ID of the post to display
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function show($id)
//     {
//         // Attempt to find the post by its ID
//         $post = Post::find($id);

//         // Check if the post was found
//         if ($post) {
//             // If found, return a 200 response with the post data and a success message
//             return response()->json(['data' => $post, 'message' => 'Post retrieved.'], 200);
//         } else {
//             // If not found, return a 404 response with a post not found message
//             return response()->json(['message' => 'Post not found.'], 404);
//         }
//     }

//     /**
//      * Update the specified resource in storage.
//      *
//      * @param Request $request The incoming request instance containing data to update
//      * @param int $id The ID of the post to update
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function update(Request $request, $id)
//     {
//         // Attempt to find the post by its ID
//         $post = Post::find($id);

//         // Check if the post was found
//         if (!$post) {
//             // If not found, return a 404 response with a post not found message
//             return response()->json(['message' => 'Post not found.'], 404);
//         }

//         // Validate the incoming request data
//         $validated = $request->validate([
//             'title' => 'nullable|string|max:255', // Title is optional, must be a string, max length 255
//             'content' => 'nullable|string', // Content is optional, must be a string
//             // 'user_id' => ['required', Rule::exists('users', 'id')], // User ID is required and must exist in the users table
//         ]);

//         // Update the post with the validated data
//         $post->update($validated);

//         // Return a JSON response with the updated post data and a success message
//         return response()->json(['data' => $post, 'message' => 'Post updated.'], 200);
//     }

//     /**
//      * Remove the specified resource from storage.
//      *
//      * @param int $id The ID of the post to delete
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function destroy($id)
//     {
//         $post = Post::find($id);
//         if (!$post) {
//             // If the post is not found, return a 404 response
//             return response()->json(['message' => 'Post not found.'], 404);
//         }
//         // Delete the post
//         $post->delete();
//         // Return a 200 response with a message
//         return response()->json(['message' => 'Post deleted.'], 200);
//     }

//     /**
//      * Retrieve all trashed posts.
//      *
//      * This method is responsible for querying the database to find all posts
//      * that have been soft deleted. Soft deleted posts are not permanently
//      * removed from the database; instead, they are flagged as deleted, allowing
//      * for potential restoration at a later time.
//      *
//      * The method then returns the soft deleted posts in a JSON response.
//      * If no trashed posts are found, a 404 response is returned with an
//      * appropriate message.
//      *
//      * @return \Illuminate\Http\JsonResponse A JSON response containing the list of trashed posts or a not found message
//      */
//     public function trashed()
//     {
//         // Use the Post model to query the database for all posts that have been soft deleted
//         // The `onlyTrashed` method is used to include only those posts that are marked as deleted
//         $posts = Post::onlyTrashed()->get();

//         // Check if the query returned any results
//         if (sizeof($posts) == 0) {
//             // If the size of the returned collection is zero, it means no trashed posts were found
//             // Return a JSON response with a 404 status code and a message indicating no posts were found
//             return response()->json(['message' => 'Trashed posts not found.'], 404);
//         }

//         // If the collection is not empty, it means trashed posts were found
//         // Return a JSON response with a 200 status code, including the data of the trashed posts
//         // and a success message indicating that the posts were successfully retrieved
//         return response()->json(['data' => $posts, 'message' => 'Trashed posts retrieved.'], 200);
//     }


//     /**
//      * Restore the specified resource from soft delete.
//      *
//      * This method attempts to restore a post that has previously been soft
//      * deleted. It uses the `onlyTrashed` method to include soft deleted posts
//      * in the query, and then uses the `find` method to attempt to find a post
//      * with the specified ID.
//      *
//      * If the post is not found, a 404 response with a post not found message
//      * is returned. Otherwise, the post is restored using the `restore` method
//      * and a 200 response with the restored post data and a success message
//      * is returned.
//      *
//      * @param int $id The ID of the post to restore
//      * @return \Illuminate\Http\JsonResponse A JSON response indicating the result of the operation
//      */
//     public function restore($id)
//     {
//         // Attempt to find the post by its ID, including those that have been soft deleted
//         // The `onlyTrashed` method is used to include only soft deleted posts in the query
//         $post = Post::onlyTrashed()->find($id);

//         // Check if the post was found in the query
//         if (!$post) {
//             // If the post is not found, return a 404 response with a message indicating the post was not found
//             return response()->json(['message' => 'Post not found.'], 404);
//         }

//         // If the post is found, restore it using the `restore` method
//         $post->restore();

//         // After successful restoration, return a 200 response with the restored post data and a success message
//         return response()->json(['data' => $post, 'message' => 'Post restored.'], 200);
//     }

//     // restore all post data
//     public function restoreAll()
//     {
//         // Post::onlyTrashed()->restore();
//         Post::onlyTrashed()->restore();
//         return response()->json(['message' => 'All trashed posts restored.'], 200);
//     }


//     /**
//      * Permanently delete the specified resource from storage.
//      *
//      * This method attempts to permanently delete a post from the database,
//      * even if it has been soft deleted. It uses the `forceDelete` method
//      * to ensure the post is completely removed from the database.
//      *
//      * @param int $id The ID of the post to delete
//      * @return \Illuminate\Http\JsonResponse A JSON response indicating the result of the operation
//      */
//     public function forceDelete($id)
//     {
//         // Attempt to find the post by its ID, including those that have been soft deleted
//         $post = Post::withTrashed()->find($id);

//         // Check if the post was found
//         if (!$post) {
//             // If the post is not found, return a 404 response with a post not found message
//             return response()->json(['message' => 'Post not found.'], 404);
//         }

//         // Permanently delete the post from the database
//         $post->forceDelete();

//         // Return a 200 response with a success message indicating the post was deleted permanently
//         return response()->json(['message' => 'Post deleted permanently.'], 200);
//     }

//     // delete all trashed post data forever
//     public function forceDeleteAllTrashed()
//     {
//         Post::onlyTrashed()->forceDelete();
//         return response()->json(['message' => 'All trahsed posts deleted permanently.'], 200);
//     }
//     /**
//      * Search for posts based on a keyword.
//      *
//      */
//     public function search(Request $request)
//     {
//         $posts = Post::search($request->keyword)->get();
//         return response()->json($posts);
//     }
// }
