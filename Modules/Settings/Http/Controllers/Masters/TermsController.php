<?php

namespace Modules\Settings\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Settings\Entities\Term;

class TermsController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'title' => ['required'],
            'description' => ['required'],
            'type' => ['required'],
        ]);
        if (Term::where('title', $request->title)->exists()) {
            $this->validationError('title', 'term name Exists');
        }
        if (Term::where('description', $request->description)->exists()) {
            $this->validationError('description', 'term port in use');
        }
        try {
            $Term = new Term();
            $Term->title = $request->title;
            $Term->description = $request->description;
            $Term->type = $request->type;
            $Term->is_financial = $request->has('is_financial');
            $Term->enabled = $request->has('enabled');
            $Term->created_by = Auth::user()->id;
            $save = $Term->save();



            if ($save) {
                return $this->responseBody(true, "save", "Term saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'title' => ['required'],
            'description' => ['required'],
            'type' => ['required']
        ]);
        $data = Term::where('title', $request->title);
        $data2 = Term::where('description', $request->description);

        if ($data->exists()) {
            if ($data->first()->id != $request->id) {
                $this->validationError('title', 'term name Exists');

            }
        }
        if ($data2->exists()) {
            if ($data2->first()->id != $request->id) {
                $this->validationError('description', 'term port in use');

            }
        }
        try {
            $Term = Term::find($request->id);
            $Term->title = $request->title;
            $Term->description = $request->description;
            $Term->type = $request->type;
            $Term->is_financial = $request->has('is_financial');
            $Term->enabled = $request->has('enabled');
            $Term->modified_by = Auth::user()->id;
            $save = $Term->save();

            if ($save) {
                return $this->responseBody(true, "save", "Term saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadTerms()
    {
        try {
            $Term = Term::orderBy('id', 'ASC')
                ->get();

            return $this->responseBody(true, "loadTerms", "found", $Term);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadTerms", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $Term = Term::where('id', $id)->delete();
            return $this->responseBody(true, "User", "Term Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadTerm($id)
    {
        try {
            $Term = Term::where('id', $id)->first();
            return $this->responseBody(true, "loadTerm", "found", $Term);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadTerm", "error", $exception->getMessage());
        }
    }
}
