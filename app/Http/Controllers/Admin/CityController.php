<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Services\Notify;
use App\Traits\Searchable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Iterators\CityIterator;


class CityController extends Controller
{
    use Searchable;

    public function __construct()
    {
        $this->middleware(['permission:job locations']);
    }

    /**
     * Hiển thị danh sách thành phố.
     */
    public function index(): View
    {
        $query = City::with(['country', 'state'])->latest('id')->get();

        $cityIterator = new CityIterator($query->toArray());

        return view('admin.location.city.index', compact('cityIterator'));
    }

    /**
     * Hiển thị form tạo thành phố mới.
     */
    public function create(): View
    {
        $countries = Country::all();
        return view('admin.location.city.create', compact('countries'));
    }

    /**
     * Lưu thành phố mới vào database.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'country' => ['required', 'integer', 'exists:countries,id'],
            'state'   => ['required', 'integer', 'exists:states,id'],
            'city'    => ['required', 'string', 'max:255']
        ]);

        City::create([
            'name'       => $validated['city'],
            'state_id'   => $validated['state'],
            'country_id' => $validated['country'],
        ]);

        Notify::createdNotification();

        return to_route('admin.cities.index')->with('success', 'Thành phố đã được tạo thành công.');
    }

    /**
     * Hiển thị form chỉnh sửa thành phố.
     */
    public function edit(City $city): View
    {
        $this->authorize('update', $city);

        $countries = Country::all();
        $states = State::where('country_id', $city->country_id)->get();

        return view('admin.location.city.edit', compact('countries', 'city', 'states'));
    }

    /**
     * Cập nhật thông tin thành phố.
     */
    public function update(Request $request, City $city): RedirectResponse
    {
        $this->authorize('update', $city);

        $validated = $request->validate([
            'country' => ['required', 'integer', 'exists:countries,id'],
            'state'   => ['required', 'integer', 'exists:states,id'],
            'city'    => ['required', 'string', 'max:255']
        ]);

        $city->update([
            'name'       => $validated['city'],
            'state_id'   => $validated['state'],
            'country_id' => $validated['country'],
        ]);

        Notify::updatedNotification();

        return to_route('admin.cities.index')->with('success', 'Thành phố đã được cập nhật.');
    }

    /**
     * Xóa thành phố.
     */
    public function destroy(City $city): Response
    {
        $this->authorize('delete', $city);

        try {
            $city->delete();
            Notify::deletedNotification();
            return response(['message' => 'success'], 200);
        } catch (\Throwable $e) {
            logger()->error('Lỗi khi xóa thành phố: ' . $e->getMessage());
            return response(['message' => 'Lỗi! Không thể xóa thành phố.'], 500);
        }
    }
}
