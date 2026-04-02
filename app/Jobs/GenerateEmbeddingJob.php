<?php
namespace App\Jobs;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateEmbeddingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $product;
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function handle()
    {        
        $product = Product::find($this->product->id);
        if (!$product) return;
        if (!empty($product->vector_embedding)) {
            return;
        }
        $text = $product->title 
              . ' ' . $product->description 
              . ' ' . optional($product->category)->title;
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
        ])->post('https://api.openai.com/v1/embeddings', [
            'model' => 'text-embedding-3-small',
            'input' => $text,
        ]);
        $embedding = $response['data'][0]['embedding'] ?? null;
        if ($embedding) {
            $product->vector_embedding = json_encode($embedding);
            $product->save();
        }
    }
}