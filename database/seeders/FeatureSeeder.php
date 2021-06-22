<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Feature::factory()->create([
            'name' => 'Task oEmbed',
            'slug' => 'oembed',
            'description' => 'oEmbed for Tasks',
        ]);

        Feature::factory()->create([
            'name' => 'Social auth',
            'slug' => 'social_auth',
            'description' => 'Social authentication for Taskord',
        ]);

        Feature::factory()->create([
            'name' => 'Pride flag 🏳️‍🌈',
            'slug' => 'pride',
            'description' => 'Pride month logo on the navbar',
            'staff' => false,
            'beta' => false,
            'contributor' => false,
            'public' => false,
        ]);

        Feature::factory()->create([
            'name' => 'API',
            'slug' => 'api',
            'description' => 'Taskord GraphQL API',
        ]);

        Feature::factory()->create([
            'name' => 'FAQ Section',
            'slug' => 'faq_section',
            'description' => 'FAQ Section in about page',
        ]);

        Feature::factory()->create([
            'name' => 'Year in review',
            'slug' => 'year_in_review',
            'description' => 'Year in review page for all Taskord users',
            'staff' => false,
            'beta' => false,
            'contributor' => false,
            'public' => false,
        ]);

        Feature::factory()->create([
            'name' => 'Explore - Products',
            'slug' => 'explore_products',
            'description' => 'Products explore page that show famous products',
        ]);

        Feature::factory()->create([
            'name' => 'Explore - Makers',
            'slug' => 'explore_makers',
            'description' => 'Makers explore page that show famous makers',
        ]);

        Feature::factory()->create([
            'name' => 'Help menu',
            'slug' => 'help_menu',
            'description' => 'Help menu in navbar dropdown',
        ]);

        Feature::factory()->create([
            'name' => 'Meetups',
            'slug' => 'meetups',
            'description' => 'User can host meetups in Taskord',
        ]);
    }
}
