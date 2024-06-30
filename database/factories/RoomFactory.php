<?php

namespace Database\Factories;

use App\Models\Floor;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Room::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'room_number' => $this->faker->unique()->randomNumber(3),
            'room_description' => $this->faker->paragraph,
            'floor_id' => Floor::factory()->create()->id,
            'category_id' => \App\Models\RoomCategory::factory()->create()->id,
        ];
    }
    
}
