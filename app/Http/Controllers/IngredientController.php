<?php

namespace App\Http\Controllers;

use App\Http\Requests\IngredientRequest;
use Illuminate\Http\{ Request, JsonResponse };
use App\Services\IngredientService;
use App\Models\Ingredient;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

/**
 * Class CandidateController
 * @package App\Http\Controllers\Candidates
 */
class IngredientController extends Controller
{
    /**
     * @var
     */
    protected $ingredientService;

    public function __construct(IngredientService $ingredientService)
    {
        $this->ingredientService = $ingredientService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function index()
    {
        return view('ingredients.index');
    }

    /**
     * Process dataTable ajax response.
     *
     * @param DataTables $dataTables
     * @return JsonResponse
     */
    public function getData(DataTables $dataTables)
    {
        $query = Ingredient::select('*');

        $ingredientDatatable = $dataTables->eloquent($query)
            ->addColumn('name', function ($ingredient) {
                return $ingredient->name;
            });

        if (Auth::check()) {
            $ingredientDatatable->addColumn('action', function($ingredient) {
                return view('ingredients.parts.action', compact('ingredient'))->render();
            });
        }

        return $ingredientDatatable
            ->rawColumns(['name','action'])
            ->make();
    }

    /**
     * @return View
     */
    public function create() :View
    {
        return view('ingredients.create');
    }

    /**
     * @param IngredientRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(IngredientRequest $request)
    {
        $request->validated();
        $ingredient = $request->all();
        $existsIngredientWithSameName = $this->ingredientService->getSameNameIngredients($ingredient['name']);

        if ($existsIngredientWithSameName instanceof Ingredient) {
            flash(__('recruit.same_ingredient'))->error();

            $response =  back()->withInput($request->all());
        } else {
            $this->ingredientService->createIngredient($ingredient);
            flash(__('recruit.ingredient_was_created'))->success();

            $response =  redirect(route('ingredients.index'));
        }

        return $response;
    }

    /**
     * @param Ingredient $ingredient
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function edit(Ingredient $ingredient)
    {
        return view('ingredients.edit', compact('ingredient'));
    }

    /**
     * @param IngredientRequest $request
     * @param Ingredient $ingredient
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(IngredientRequest $request, Ingredient $ingredient)
    {
        $request->validated();
        $ingredientRequest = $request->all();
        $result = $this->ingredientService->updateIngredient($ingredientRequest, $ingredient);

        if ($result instanceof MessageBag) {
            return back()->withInput($request->all())->withErrors($result);
        }

        flash(__('recruit.ingredient_was_updated'))->success();

        return redirect(route('ingredients.index'));
    }

    /**
     * @param Request $request
     * @param Ingredient $ingredient
     * @return JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Request $request, Ingredient $ingredient)
    {
        if (!$ingredient instanceof Ingredient) {
            return response()->json(['success' => 'error', 'message' => 'Data is not valid'], 200);
        } else {
            if (!$result = $this->ingredientService->deleteIngredient($ingredient)) {
                return response()->json(['success' => 'error',
                    'message' => __('recruit.ingredient_not_delete')], 200);
            }
        }

        if ($request->ajax()) {
            return response()->json(['success' => 'success',
                'message' => __('recruit.ingredient_was_deleted')], 200);
        }

        return redirect(route('ingredients.index'));
    }
}
