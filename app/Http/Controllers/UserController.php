<?php

namespace App\Http\Controllers;

use App\Factories\UserAccountFactory;
use Illuminate\Http\Request;
use App\Repositories\UserRepositoryInterface;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $users = $this->userRepository->getAll();
        return response()->json($users);
    }

    public function show($id)
    {
        $user = $this->userRepository->getById($id);
        return response()->json($user);
    }

    public function store(Request $request)
    {
        $data = $request->only(['name', 'email', 'password']);
        $data['password'] = bcrypt($data['password']);
        $user = $this->userRepository->create($data);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $data = $request->only(['name', 'email']);
        $user = $this->userRepository->update($id, $data);
        return response()->json($user);
    }

    public function destroy($id)
    {
        $this->userRepository->delete($id);
        return response()->json(['message' => 'User deleted successfully']);
    }

    public function getUserRole(Request $request)
    {
        $type = $request->input('type', 'customer'); // Lấy loại user từ request
        $user = UserAccountFactory::create($type);

        return response()->json(['role' => $user->getRole()]);
    }
}
