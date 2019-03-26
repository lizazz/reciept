<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReceiptRequest;
use Illuminate\Http\{ Request, JsonResponse };
use App\Models\Receipt;
use App\Services\{ ReceiptService, IngredientService };
use Illuminate\View\View;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

/**
 * Class ReceiptController
 * @package App\Http\Controllers
 */
class ReceiptController extends Controller
{
    /**
     * @var
     */
    protected $receiptService;

    /**
     * @var
     */
    protected $ingredientService;


    /**
     * ReceiptController constructor.
     * @param ReceiptService $receiptService
     * @param IngredientService $ingredientService
     */
    public function __construct(ReceiptService $receiptService, IngredientService $ingredientService)
    {
        $this->receiptService = $receiptService;
        $this->ingredientService = $ingredientService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function index()
    {
        return view('receipts.index');
    }

    /**
     * Process dataTable ajax response.
     *
     * @param DataTables $dataTables
     * @return JsonResponse
     */
    public function getData(DataTables $dataTables)
    {
        if (Auth::check()) {
            $query = Receipt::where('user_id', Auth::id())->select('receipts.*');
        } else {
            $query = Receipt::select('receipts.*');
        }

        $receiptDatatable = $dataTables->eloquent($query)
            ->addColumn('name', function ($receipt) {
                return '<a href="' . route('receipts.edit', ['receipt' => $receipt->id]) .
                    '">' . $receipt->name . '</a>';
            })
            ->editColumn('description', function ($receipt) {
                return substr($receipt->description, 0, 150);
            });

        if (Auth::check()) {
            $receiptDatatable->addColumn('action', function($receipt) {
                return view('receipts.parts.action', compact('receipt'))->render();
            });
        }

        return $receiptDatatable
            ->rawColumns(['name', 'description', 'action'])
            ->make();
    }

    /**
     * Show create candidate form
     * @return View
     */
    public function create() :View
    {
        $createData = $this->receiptService->getData();
        $ingredients = $createData['ingredients'];

        return view('receipts.create', compact('ingredients'));
    }

    /**
     * @param ReceiptRequest $request
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function store(ReceiptRequest $request)
    {
        $response = '';
        $request->validated();
        $requestObject = $request->all();
        $receipt = $this->receiptService->createReceipt($requestObject);

        if (!$receipt instanceof Receipt) {
            flash(__('recruit.receipt_not_created'))->error();

            $response = back()->withInput($requestObject);
        } else {
            flash(__('recruit.receipt_was_created'))->success();
            $response =  view('receipts.index');
        }

        return $response;
    }

    /**
     * @param Receipt $receipt
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function edit(Receipt $receipt)
    {
        $updateData = $this->receiptService->getData($receipt);
        $ingredients = $updateData['ingredients'];
        $existIngredients = $updateData['existIngredients'];

        return view('receipts.edit', compact('receipt', 'ingredients', 'existIngredients'));
    }

    /**
     * @param ReceiptRequest $request
     * @param Receipt $receipt
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(ReceiptRequest $request, Receipt $receipt)
    {
        $request->validated();
        $requestObject = $request->all();
        $result = $this->receiptService->updateReceipt($requestObject, $receipt);

        if ($result instanceof Receipt) {
            /*if ($result instanceof MessageBag) {
                return back()->withInput($request->all())->withErrors($result);
            }
            $existsCandidatesWithSameName =
                $this->candidateService->getSameNameCandidates($request->input('name'), $candidate->id);
*/
            flash(__('recruit.receipt_was_updated'))->success();

            $response =  view('receipts.index');
        } else {
            $response =  back()->withInput($request->all())->withErrors($result);
        }

        return $response;

    }

    /**
     * @param Request $request
     * @param Receipt $receipt
     * @return JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Request $request, Receipt $receipt)
    {
        if (!$receipt instanceof Receipt) {
            return response()->json(['success' => 'error', 'message' => 'Data is not valid'], 200);
        } else {
            if (!$result = $this->receiptService->deleteReceipt($receipt)) {
                return response()->json(['success' => 'error',
                    'message' => __('recruit.receipt_not_deleted')], 200);
            }
        }

        if ($request->ajax()) {
            return response()->json(['success' => 'success',
                'message' => __('recruit.receipt_was_deleted')], 200);
        }

        return redirect(route('receipts.index'));
    }
}
