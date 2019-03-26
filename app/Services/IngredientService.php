<?php

namespace App\Services;

use App\Models\Ingredient;
use Illuminate\Support\MessageBag;

/**
 * Class IngredientService
 * @package App\Services
 */
class IngredientService
{

    /**
     * @param array $ingredient
     * @return mixed
     */
    public function createIngredient (array $ingredient)
    {
        $ingredient = Ingredient::create([
            'name' => $ingredient['name']
        ]);

        return $ingredient;
    }

    /**
     * @param array $ingredientRequest
     * @param Ingredient $ingredient
     * @return Ingredient|MessageBag
     */
    public function updateIngredient(array $ingredientRequest, Ingredient $ingredient)
    {
        $updateFields = [];

        if ($ingredient->name !== $ingredientRequest['name']) {
            $ingredientWithSameName = Ingredient::where('id', '!=', $ingredient->id)
                ->where('name', $ingredientRequest['name'])->first();

            if (!empty($ingredientWithSameName)) {
                flash(__('recruit.same_ingredient'))->error();
                $errors = new MessageBag();
                $errors->add('name', __('recruit.same_ingredient'));
                return $errors;
            } else {
                $updateFields['name'] = $ingredientRequest['name'];
            }
        }

        $ingredient->update($updateFields);

        return $ingredient;
    }

    /**
     * @param Ingredient $ingredient
     * @return bool
     * @throws \Exception
     */
    public function deleteIngredient(Ingredient $ingredient)
    {
        $ingredient->delete();
        $result = true;

        return $result;
    }

    /**
     * @param string $ingredientsName
     * @return mixed
     */
    public function getSameNameIngredients(string $ingredientsName)
    {
        $ingredients = Ingredient::where('name', '=', $ingredientsName)->get();

        return $ingredients;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {
        $ingredients = [];
        $ingredientCollections = Ingredient::all();

        foreach ($ingredientCollections as $ingredientCollection) {
            $ingredients[$ingredientCollection->id] = $ingredientCollection->name;
        }
        return $ingredients;
    }
}