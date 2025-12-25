<?php

namespace App\Http\Controllers\Catgories;

use App\Http\Controllers\Controller;
use App\Models\Catgories;
use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UpdateController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $catgory = Catgories::find($id);
        if (!$catgory) {
            return $this->errorResponse('Category not found', 404);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:catgories,name,' . $id,
            'image' => ImageHelper::getValidationRules(),
        ]);

        return DB::transaction(function () use ($catgory, $request) {
            $catgory->name = $request->name;

            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($catgory->image) {
                    ImageHelper::delete($catgory->image);
                }
                $catgory->image = ImageHelper::upload($request->file('image'), 'categories');
            }

            $catgory->save();
            return $this->successResponse($catgory, 'Category updated successfully');
        });
    }
}
