<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;

class ManageCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'category:manage {action} {name} {parent_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create or delete a category';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $action = $this->argument('action');
        $name = $this->argument('name');
        $parent_id = $this->argument('parent_id') ?? null;

        if ($action === 'create') {
            $category = Category::create([
                'name' => $name,
                'parent_id' => $parent_id,
            ]);
            $this->info("Category '{$name}' created successfully.");
        } elseif ($action === 'delete') {
            $category = Category::where('name', $name)->first();

            if ($category) {
                $category->delete();
                $this->info("Category '{$name}' deleted successfully.");
            } else {
                $this->error("Category '{$name}' not found.");
            }
        } else {
            $this->error("Invalid action. Use 'create' or 'delete'.");
        }
    }
}
