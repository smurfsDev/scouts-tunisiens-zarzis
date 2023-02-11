<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequestDocument;
use App\Models\User;
use App\Models\Troupe;
use PDF;

class RequestDocumentController extends Controller
{
    public function index()
	{
		$requestDocuments = RequestDocument::all();
		if ($requestDocuments->count() > 0) {
			return response()->json($requestDocuments, 200);
		} else {
			return response()->json(null, 404);
		}
	}

	public function getMine(Request $request)
	{
		$requestDocuments = RequestDocument::where("user_id", $request->user()->id)->get();
		if ($requestDocuments->count() > 0) {
			return response()->json($requestDocuments, 200);
		} else {
			return response()->json(null, 404);
		}
	}

	public function store(Request $request)
	{
		$requestDocument = RequestDocument::create([
			"title" => $request->title,
			"to" => $request->to,
			"date" => $request->date,
			"location" => $request->location,
			"subject" => $request->subject,
			"body" => $request->body,
			"user_id" => $request->user()->id,
			"admin_id" => null,
			"status" => 0,
		]);

		if ($requestDocument) {
			return response()->json($requestDocument, 201);
		} else {
			return response()->json(null, 500);
		}

	}

	public function show(RequestDocument $requestDocument)
	{
		return response()->json($requestDocument, 200);
	}

	public function update(Request $request, RequestDocument $requestDocument)
	{
		$requestDocument->update([
			"title" => $request->title,
			"to" => $request->to,
			"date" => $request->date,
			"location" => $request->location,
			"subject" => $request->subject,
			"body" => $request->body,
			"user_id" => $request->user()->id,
			"admin_id" => null,
			"status" => 0,
		]);

		if ($requestDocument) {
			return response()->json($requestDocument, 200);
		} else {
			return response()->json(null, 500);
		}
	}

	public function destroy(RequestDocument $requestDocument)
	{
		$requestDocument->delete();
		return response()->json(null, 204);
	}

	public function approve(Request $request, RequestDocument $requestDocument)
	{
		$requestDocument->update([
			"admin_id" => $request->user()->id,
			"status" => 1,
		]);

		if ($requestDocument) {
			return response()->json($requestDocument, 200);
		} else {
			return response()->json(null, 500);
		}
	}

	public function reject(Request $request, RequestDocument $requestDocument)
	{
		$requestDocument->update([
			"admin_id" => $request->user()->id,
			"status" => 2,
		]);

		if ($requestDocument) {
			return response()->json($requestDocument, 200);
		} else {
			return response()->json(null, 500);
		}
	}

	public function download(RequestDocument $requestDocument)
	{
		if ($requestDocument->status){

			$user = User::where("id",$requestDocument->user_id)->with('roles')
			->whereHas('roles', function ($query) {
				$query->where('responsability_id', '4');
			})
			->first();
			$troupe_name = Troupe::where("id",$user->roles[0]->troupe_id)->first()->name;
			return view('demande', 
			[
				"requestDocument" => $requestDocument,
				"user" => $user,
				"troupe_name" => $troupe_name,
				]
			);
		}else{
			return response()->json(null, 404);
		}
	}
}
