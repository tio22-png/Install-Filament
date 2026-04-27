<?php
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Post;
use App\Models\Product;

// Data Categories Tambahan
$cat3 = Category::firstOrCreate(['slug' => 'javascript'], ['name' => 'JavaScript']);
$cat4 = Category::firstOrCreate(['slug' => 'python'], ['name' => 'Python']);
$cat5 = Category::firstOrCreate(['slug' => 'devops'], ['name' => 'DevOps']);

// Data Tags Tambahan
$tag4 = Tag::firstOrCreate(['name' => 'React']);
$tag5 = Tag::firstOrCreate(['name' => 'Vue JS']);
$tag6 = Tag::firstOrCreate(['name' => 'Django']);
$tag7 = Tag::firstOrCreate(['name' => 'Docker']);

// Data Posts Tambahan
$post3 = Post::firstOrCreate(['slug' => 'belajar-react'], [
    'title' => 'Belajar React JS',
    'category_id' => $cat3->id,
    'body' => 'Tutorial dasar menggunakan React JS untuk pemula.',
    'published' => true,
]);
$post3->tags()->syncWithoutDetaching([$tag4->id, Tag::where('name', 'Web Dev')->first()->id]);

$post4 = Post::firstOrCreate(['slug' => 'docker-tutorial'], [
    'title' => 'Tutorial Docker',
    'category_id' => $cat5->id,
    'body' => 'Cara menggunakan Docker untuk environment development.',
    'published' => true,
]);
$post4->tags()->syncWithoutDetaching([$tag7->id]);

$post5 = Post::firstOrCreate(['slug' => 'django-rest-framework'], [
    'title' => 'Django REST Framework',
    'category_id' => $cat4->id,
    'body' => 'Membuat API cepat dengan Django.',
    'published' => false,
]);
$post5->tags()->syncWithoutDetaching([$tag6->id]);

// Data Products Tambahan
Product::firstOrCreate(['sku' => 'PRD-001'], [
    'name' => 'MacBook Pro M3',
    'description' => 'Laptop terbaru dari Apple.',
    'price' => 25000000,
    'stock' => 10,
    'is_active' => true,
    'is_featured' => true
]);

Product::firstOrCreate(['sku' => 'PRD-002'], [
    'name' => 'Logitech MX Master 3',
    'description' => 'Mouse wireless terbaik untuk produktivitas.',
    'price' => 1500000,
    'stock' => 25,
    'is_active' => true,
    'is_featured' => false
]);

Product::firstOrCreate(['sku' => 'PRD-003'], [
    'name' => 'Keychron K2',
    'description' => 'Mechanical keyboard untuk programmer.',
    'price' => 1200000,
    'stock' => 50,
    'is_active' => true,
    'is_featured' => true
]);

echo "Seeding tambahan completed!\n";
