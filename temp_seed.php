<?php
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Post;
use App\Models\Product;

User::firstOrCreate(
    ['email' => 'admin@admin.com'],
    ['name' => 'Admin', 'password' => bcrypt('password')]
);

$cat1 = Category::firstOrCreate(['slug' => 'laravel'], ['name' => 'Laravel']);
$cat2 = Category::firstOrCreate(['slug' => 'php'], ['name' => 'PHP']);

$tag1 = Tag::firstOrCreate(['name' => 'Laravel 10']);
$tag2 = Tag::firstOrCreate(['name' => 'Laravel 11']);
$tag3 = Tag::firstOrCreate(['name' => 'Web Dev']);

$post1 = Post::firstOrCreate(['slug' => 'laravel-crud'], [
    'title' => 'Laravel CRUD',
    'category_id' => $cat1->id,
    'body' => 'Tutorial Laravel CRUD',
    'published' => true,
]);
$post1->tags()->sync([$tag1->id, $tag3->id]);

$post2 = Post::firstOrCreate(['slug' => 'php-basic'], [
    'title' => 'PHP Basic',
    'category_id' => $cat2->id,
    'body' => 'Tutorial PHP Basic',
    'published' => true,
]);
$post2->tags()->sync([$tag2->id]);

Product::firstOrCreate(['name' => 'Product 1'], ['price' => 10000]);
echo "Seeding completed!\n";
