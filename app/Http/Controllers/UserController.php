<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\EditUserRequest;
use App\Services\UserService;
use App\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    /** @var UserService $userService */
    protected $userService;

    /**
     * UserController constructor.
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function index()
    {
        return view('users.index');
    }

    /**
     * Process dataTable ajax response.
     *
     * @param \Yajra\Datatables\Datatables $datatables
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData(DataTables $datatables)
    {
        $query = User::query()->select('users.*');

        $usersDatatable = $datatables->eloquent($query)
            ->addColumn('name', function ($user) {
                return $user->name.((\Auth::user()->id == $user->id) ? ' <em>(you)</em>' : '');
            })
            ->editColumn('email', function ($user) {
                return '<a href="mailto:'.$user->email.'" target="_top">'.$user->email.'</a>';
            });

        if (Auth::user()) {
            $usersDatatable
            ->addColumn('action', function($user) {
                return view('users.datatables.action', compact('user'))->render();
            });
        }

        return $usersDatatable
            ->rawColumns(['name', 'email', 'action'])
            ->make();
    }


    /**
     * Show create user form
     * @return View
     */
    public function create() :View
    {
        return view('users.create');
    }

    /**
     * Save new user
     * @param CreateUserRequest $request
     * @return RedirectResponse|Redirector
     */
    public function store(CreateUserRequest $request)
    {
        $request->validated();
        $user = $this->userService->createUser($request);

        if ($user instanceof User) {
            $nameOfUser = $user->name;

            flash(str_replace('{name}', $nameOfUser, __('recruit.user_was_created')))->success();

            return redirect(route('user.index'));

        } else {
            flash(__('recruit.user_not_created'))->error();

            return back()->withInput($request->all());
        }
    }

    /**
     * Edit user information
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function edit(User $user)
    {
        $maxFileSize = (int) filter_var(
            ini_get('upload_max_filesize'),
            FILTER_SANITIZE_NUMBER_INT
        ) * 1024;

        return view('users.edit', compact('user', 'maxFileSize'));
    }

    /**
     * Update user information
     * @param EditUserRequest $request
     * @param User $user
     * @return RedirectResponse|Redirector
     */
    public function update(EditUserRequest $request, User $user)
    {
        $request->validated();
        $result = $this->userService->updateUser($request, $user);

        if ($result) {
            $nameOfUser = $request->input('name');

            flash(str_replace('{name}', $nameOfUser, __('recruit.user_was_updated')))->success();

            return redirect(route('user.index'));

        } else {
            flash(__('recruit.user_not_updated'))->success();

            return back()->withInput($request->all());
        }
    }

    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse|RedirectResponse|Redirector
     * @throws \Exception
     */
    public function destroy(Request $request, User $user)
    {
        if (!$user instanceof  User) {
            return response()->json(['success' => 'error', 'message' => 'Data is not valid'], 200);
        } else {
            $nameOfUser = $user->name;
            $this->userService->deleteUser($user);

            if($request->ajax()){
                    return response()->json(['success' => 'success', 'message' => str_replace('{name}',
                        $nameOfUser, __('recruit.user_was_deleted'))], 200);
            }
        }

        return redirect(route('user.index'));
    }
}
