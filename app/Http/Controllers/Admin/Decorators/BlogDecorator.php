<?php
namespace App\Http\Controllers\Admin\Decorators;
use App\Http\Requests\Admin\BlogCreateRequest;
use App\Http\Requests\Admin\BlogUpdateRequest;
use App\Http\Controllers\Admin\BlogController;
use App\Models\Blog;
use App\Services\Notify;
use Illuminate\View\View;
class BlogDecorator
{
    protected $blogController;

    public function __construct()
    {
    }

    public function setBlogController(BlogController $blogController)
    {
        $this->blogController = $blogController;
    }

    public function store($request)
    {
        $this->logAction('Creating blog...');
        $response = $this->blogController->store($request);
        Notify::createdNotification();
        return $response;
    }

    public function update($request, $id)
    {
        $this->logAction('Updating blog...');
        $response = $this->blogController->update($request, $id);
        Notify::updatedNotification();
        return $response;
    }

    public function destroy($id)
    {
        $this->logAction('Deleting blog...');
        $response = $this->blogController->destroy($id);
        Notify::deletedNotification();
        return $response;
    }

    private function logAction($message)
    {
        \Log::info($message);
    }
}