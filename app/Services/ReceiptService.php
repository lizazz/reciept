<?php

namespace App\Services;

use App\Models\{Receipt, ReceiptIngredients};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReceiptService
{
    /**
     * @var IngredientService
     */
    protected $ingredientService;

    /**
     * ReceiptService constructor.
     * @param IngredientService $ingredientService
     */
    public function __construct(IngredientService $ingredientService)
    {
        $this->ingredientService = $ingredientService;
    }

    /**
     * @param array $requestObject
     * @return bool
     */
    public function createReceipt(array $requestObject)
    {
        $response = false;
        $ingredientArray = $requestObject['ingredients'];

        DB::beginTransaction();

        try {
            if(empty($requestObject['description'])) {
                $requestObject['description'] = '';
            }

            $receipt = Receipt::create([
                'name' => $requestObject['name'],
                'description' => $requestObject['description'],
                'user_id' => Auth::id()
            ]);

            if ($receipt instanceof Receipt && !empty($ingredientArray['name']) && is_array($ingredientArray['name'])) {
                $ingredientCount = count($ingredientArray['name']);

                for ($i = 0; $i < $ingredientCount; $i++ ) {
                    if (isset($ingredientArray['quantity'][$i])) {
                        ReceiptIngredients::create([
                            'receipt_id' => (int) $receipt->id,
                            'ingredient_id' => (int) $ingredientArray['name'][$i],
                            'quantity' => (int) $ingredientArray['quantity'][$i]
                        ]);
                    }
                }
            }

            DB::commit();

            $response =  $receipt;
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
        }

        return $response;
    }

    /**
     * @param array $requestObject
     * @param Receipt $receipt
     * @return Receipt|bool
     */
    public function updateReceipt(array $requestObject, Receipt $receipt)
    {
        $response = false;
        $ingredientArray = $requestObject['ingredients'];
        $updateFields = [];

        if ($requestObject['name'] != $receipt->name) {
            $updateFields['name'] = $requestObject['name'];
        }

        if ($requestObject['description'] != $receipt->description) {
            $updateFields['description'] = $requestObject['description'];
        }

        DB::beginTransaction();

        try {
            $receipt->update($updateFields);

            if (!empty($ingredientArray['name']) && is_array($ingredientArray['name'])) {
                $ingredientCount = count($ingredientArray['name']);
                ReceiptIngredients::where('receipt_id', $receipt->id)->delete();

                for ($i = 0; $i < $ingredientCount; $i++ ) {
                    if (isset($ingredientArray['quantity'][$i]) && $ingredientArray['name'][$i] != null) {
                        ReceiptIngredients::create([
                            'receipt_id' => $receipt->id,
                            'ingredient_id' => $ingredientArray['name'][$i],
                            'quantity' => $ingredientArray['quantity'][$i]
                        ]);
                    }
                }
            }

            DB::commit();
            $response = $receipt;
        } catch (\Exception $e) {
            DB::rollBack();
        }

        return $response;
    }

    /**
     * @param Receipt $receipt
     * @return bool
     */
    public function deleteReceipt(Receipt $receipt)
    {
        DB::beginTransaction();
        $result = false;

        try {
            $receipt->delete();
            DB::commit();
            $result = true;
        } catch (\Exception $e) {
            DB::rollBack();
        }

        return $result;
    }

    /**
     * @param null $receipt
     * @return array
     */
    public function getData($receipt = null)
    {
        $ingredients = $this->ingredientService->getAll();
        $existIngredients = [];

        if ($receipt instanceof Receipt) {

            foreach ($receipt->ingredients as $ingredient) {
                $receiptIngredientCollections = ReceiptIngredients::where('receipt_id', $receipt->id)
                    ->where('ingredient_id', $ingredient->id)->get();

                foreach ($receiptIngredientCollections as $receiptIngredient) {
                    $existIngredients[] = $receiptIngredient;
                }

            }
        }

        return [
            'ingredients' => $ingredients,
            'existIngredients' => $existIngredients
        ];
    }
}