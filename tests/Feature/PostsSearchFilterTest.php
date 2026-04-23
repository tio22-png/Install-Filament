<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostsSearchFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_and_category_filter_combination_returns_expected_posts()
    {
        // create categories
        $catA = Category::create(["name" => "News", "slug" => "news"]);
        $catB = Category::create(["name" => "Blog", "slug" => "blog"]);

        // create posts
        $post1 = Post::create([
            'title' => 'Breaking News Today',
            'slug' => 'breaking-news-today',
            'category_id' => $catA->id,
        ]);

        $post2 = Post::create([
            'title' => 'Weekly Blog Roundup',
            'slug' => 'weekly-blog-roundup',
            'category_id' => $catB->id,
        ]);

        $post3 = Post::create([
            'title' => 'News Analysis',
            'slug' => 'news-analysis',
            'category_id' => $catA->id,
        ]);

        // simulate a user searching for "News" while filtering by category News (catA)
        $search = 'News';
        $categoryId = $catA->id;

        $results = Post::where('category_id', $categoryId)
            ->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    });
            })->get();

        // Expect post1 and post3 (both in News category and match "News" in title/slug)
        $this->assertTrue($results->contains('id', $post1->id));
        $this->assertTrue($results->contains('id', $post3->id));
        $this->assertFalse($results->contains('id', $post2->id));
    }
}
