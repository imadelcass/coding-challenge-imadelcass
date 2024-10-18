<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class ManageProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:manage {action} {name} {price?} {description?} {image?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create or delete a product';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $action = $this->argument('action');
        $name = $this->argument('name');
        $price = $this->argument('price') ?? 0;
        $description = $this->argument('description') ?? '';
        $image = $this->argument('image') ?? '';

        if ($action === 'create') {
            $product = Product::create([
                'name' => $name,
                'price' => $price,
                'description' => $description,
                'image' => $image,
            ]);
            $this->info("Product '{$name}' created successfully.");
        } elseif ($action === 'delete') {
            $product = Product::where('name', $name)->first();

            if ($product) {
                $product->delete();
                $this->info("Product '{$name}' deleted successfully.");
            } else {
                $this->error("Product '{$name}' not found.");
            }
        } else {
            $this->error("Invalid action. Use 'create' or 'delete'.");
        }
    }
}
