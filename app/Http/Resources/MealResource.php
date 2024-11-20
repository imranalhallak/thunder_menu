<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MealResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'menu' => new MenuResource(resource: $this->menu), // Include category resource
            'arabic_name' =>  $this->category_id,
            'english_name'=>$this->number_of_pages,
            'turkish_name'=>$this->type_of_spiral,
            'price_2' => $this->price_1,
            'price_1' => $this->price_2,
            'price_3' => $this->price_3,
            'images' => $this->images,

            'created_at' => $this->created_at->format(' j F, Y'), // Example format: October 19, 2024
            'updated_at' => $this->updated_at,


        ];
    }
}
