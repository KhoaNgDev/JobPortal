<?php

namespace App\Http\Controllers\Admin\Decorators;
use App\Http\Requests\Admin\BlogCreateRequest;
use App\Http\Requests\Admin\BlogUpdateRequest;
use Illuminate\View\View;

interface BlogControllerDecoratorInterface
{
    public function index(): View;
    public function create(): View;
    public function store(BlogCreateRequest $request);
    public function edit(string $id): View;
    public function update(BlogUpdateRequest $request, string $id);
    public function destroy(string $id);
}
