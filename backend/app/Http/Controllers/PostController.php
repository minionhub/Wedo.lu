<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display lists of all posts.
     *
     * @return PostResource
     */
    public function index()
    {
        $posts = Post::all();
        return response()->json(['status' => 'success', 'data' => $posts], 200);
    }

    /**
     * Display lists of posts by multi filter options.
     *
     * @return PostResource
     */
    public function postsByMultiOptions(Request $request)
    {
        $title = $request->get('title');
        $posts = Post::where('title', 'like',  '%' . $title . '%');

        if ($request->has('tags') && $request->get('tags') != null) {
            $tagIds = $request->get('tags');
            $postTags = DB::table('post_tags')->select('post_id')
                ->whereIn('tag_id', $tagIds)
                ->groupBy('post_id')
                ->get();

            $postIds = [];
            foreach ($postTags as $postTag) {
                $postIds[] = $postTag->post_id;
            }
            $posts = $posts->whereIn('id', $postIds);
        }

        $posts = $posts->paginate(21);

        foreach ($posts as $post) {
            $post->tags = $this->tagsByPostId($post->id);
        }

        return response()->json(['status' => 'success', 'data' => $posts], 200);
    }

    public function tagsByPostId($id)
    {
        return DB::table('tags')
            ->select(['tags.id', 'tags.name', 'tags.slug'])
            ->join('post_tags', 'tags.id', '=', 'post_tags.tag_id')
            ->where('post_tags.post_id', $id)
            ->groupBy('tags.id')
            ->get();
    }

    /**
     * Display lists of posts by importance
     *
     * @return PostResource
     */
    public function postsByImportance()
    {
        $posts = Post::inRandomOrder()->limit(4)->get();

        foreach ($posts as $post) {
            $post->tags = $this->tagsByPostId($post->id);
        }

        return response()->json(['status' => 'success', 'data' => $posts], 200);
    }

    /**
     * Display lists of posts by tag.
     *
     * @return PostResource
     */
    public function postsByTagId($id)
    {
        $tag = Tag::find($id);
        $postIds = DB::table('post_tags')
            ->select(['post_id'])
            ->where('tag_id', $tag['id'])->get();
        $posts = [];
        foreach ($postIds as $postId) {
            array_push($posts, Post::findOrFail($postId->post_id));
        }
        return response()->json(['status' => 'success', 'data' => $posts], 200);
    }

    /**
     * Display lists of posts by tag slug.
     *
     * @return PostResource
     */
    public function postsByTagSlug($slug)
    {
        $tag = Tag::where('slug', $slug)->first();
        $postTags = DB::table('post_tags')
            ->select(['post_id'])
            ->where('tag_id', $tag->id)
            ->get();

        $postIds = [];
        foreach ($postTags as $postTag) {
            $postIds[] = $postTag->post_id;
        }
        $posts = Post::whereIn('id', $postIds)->paginate(10);

        foreach ($posts as $post) {
            $post->tags = $this->tagsByPostId($post->id);
        }
        return response()->json(['status' => 'success', 'data' => $posts, 'tagName' => $tag->name], 200);
    }

    /**
     * Display the specified post by id.
     *
     * @param  int  $id
     * @return PostResource
     */
    public function postById($id)
    {
        $post = Post::findOrFail($id);
        return response()->json(['status' => 'success', 'post' => $post], 200);
    }

    /**
     * Display the specified post by slug and related posts.
     *
     * @param  int  $id
     * @return PostResource
     */
    public function postBySlug($slug)
    {
        $post = Post::where('slug', $slug)->first();
        $post->tags = $this->tagsByPostId($post->id);

        // get previous post
        $prevPost = Post::where('id', '<', $post->id)
            ->orderBy('id', 'desc')
            ->first();

        // get next post
        $nextPost = Post::where('id', '>', $post->id)
            ->orderBy('id', 'asc')
            ->first();

        $post->prevPostSlug = $prevPost ? $prevPost->slug : null;
        $post->nextPostSlug = $nextPost ? $nextPost->slug : null;

        $tagIds = [];
        foreach ($post->tags as $tag) $tagIds[] = $tag->id;

        $relatedPosts = DB::table('posts')
            ->select(['posts.*'])
            ->join('post_tags', 'posts.id', 'post_tags.post_id')
            ->whereIn('post_tags.tag_id', $tagIds)
            ->groupBy('posts.id')
            ->limit(6)
            ->get();

        foreach ($relatedPosts as $relatedPost) {
            $relatedPost->tags = $this->tagsByPostId($relatedPost->id);
        }
        return response()->json([
            'status' => 'success',
            'post' => $post,
            'relatedPosts' => $relatedPosts
        ], 200);
    }

    public function searchBlog(Request $request)
    {
        // if query is missing or empty
        if (!$request->has('query') || $request->get('query') === null || !isset($request->query))
            return response()->json(['status' => 'failure', 'error' => 'Query parameter is missing'], 400);

        // check if there are categories
        $categories = true;
        if (!$request->has('categories') || $request->get('categories') === null || !isset($request->categories))
            $categories = false;

        $query = $request->get('query');

        $searchResults = Post::searchByQuery([
            'bool' => [
                'must' => [
                    'multi_match' => [
                        'query' => $query,
                        'fields' => ['title', 'content']
                    ]
                ]
            ],
        ], null, null, 666);

        $searchResultsCollection = collect($searchResults);

        if ($categories)
            $searchResultsCollection = $searchResultsCollection->whereIn('category_id', $request->get('categories'));

        return response()->json(['status' => 'success', 'totalHits' => count(collect($searchResultsCollection)->toArray()), 'hits' => $searchResultsCollection->paginate(20)], 200);
    }

    /**
     * Store a newly created post in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return PostResource
     */
    public function store(Request $request)
    {
        $post = Post::where('title', $request->get('title'))->first();

        if ($post === null) {
            $post = new Post;
            $post->fill($request->all());
            if ($post->save()) {
                return response()->json(['status' => 'success', 'post' => $post], 200);
            }
        } else {
            return response()->json(['status' => 'failure', 'error' => 'Post already exists'], 400);
        }
        return response()->json(['status' => 'failure', 'error' => 'Post create failed'], 400);
    }

    /**
     * Update the specified post in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return PostResource
     */
    public function update(Request $request, $id)
    {
        $post = Post::find($id);

        if ($post !== null) {
            $post->fill($request->all());
            if ($post->save()) {
                return response()->json(['status' => 'success', 'post' => $post], 200);
            }
        } else {
            return response()->json(['status' => 'failure', 'error' => 'No post'], 400);
        }
        return response()->json(['status' => 'failure', 'error' => 'Post update failed'], 400);
    }

    /**
     * Remove the specified post from storage.
     *
     * @param  int  $id
     * @return PostResource
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if ($post->delete()) {
            DB::table('post_tags')->delete(['post_id' => $id]);
            return response()->json(['status' => 'success', 'post_id' => $id], 200);
        } else {
            return response()->json(['status' => 'failure', 'error' => 'Post delete failed'], 400);
        }
    }
}
