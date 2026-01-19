<?php

namespace Database\Seeders;

use App\Models\Bonus;
use App\Models\FilterGroup;
use App\Models\FilterOption;
use App\Models\Page;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $group = FilterGroup::firstOrCreate(
            ['slug' => 'type'],
            ['name' => 'Type', 'is_active' => true, 'sort_order' => 0]
        );

        $options = [
            'sticky' => 'Sticky',
            'non-sticky' => 'Non-Sticky',
            'exclusive' => 'Exclusive',
        ];

        foreach ($options as $slug => $name) {
            FilterOption::firstOrCreate(
                ['slug' => $slug],
                ['filter_group_id' => $group->id, 'name' => $name, 'is_active' => true, 'sort_order' => 0]
            );
        }

        Page::firstOrCreate(
            ['slug' => 'gluecksrad'],
            [
                'title' => 'Glücksrad',
                'status' => 'published',
                'content' => '<p>Welcome to the Glücksrad bonus page.</p>',
                'seo_title' => 'Glücksrad Bonus',
                'seo_description' => 'Learn about our Glücksrad bonus.',
            ]
        );

        $bonus = Bonus::firstOrCreate(
            ['slug' => 'welcome-bonus'],
            [
                'title' => 'Welcome Bonus',
                'casino_name' => 'BonusPilot Casino',
                'short_text' => 'Get 100% up to €200',
                'content' => 'Claim your welcome bonus and start playing today.',
                'bonus_code' => 'SLOTHUNTERZZ',
                'bonus_code_label' => 'Code',
                'bonus_percent' => 100,
                'max_bonus' => '€200',
                'wager' => '35x',
                'cta_label' => 'Claim Bonus',
                'play_url' => 'https://example.com/play',
                'terms_url' => 'https://example.com/terms',
                'back_text' => 'Deposit bonus with flexible wagering and fast withdrawals.',
                'payment_methods' => 'Visa, MasterCard, PayPal, Skrill',
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 0,
            ]
        );

        $option = FilterOption::where('slug', 'exclusive')->first();
        if ($option) {
            $bonus->filterOptions()->syncWithoutDetaching([$option->id]);
        }
    }
}
