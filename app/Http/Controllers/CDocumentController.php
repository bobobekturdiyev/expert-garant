<?php

namespace App\Http\Controllers;

use App\Jobs\SendDocumentChangeNotification;
use App\Models\CUsersDocument;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CDocumentController extends Controller
{
    public function editDocument(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:c_documents,id',
            'document_content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $document = Document::find($request->id);

        $document->content = $request->document_content;
        $document->update();

        $this->sendDocumentChangeNotification($document, 'updated');

        return response()->json(['message' => 'Document updated successfully']);
    }

    public function delDocument(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:c_documents,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $document = Document::find($request->id);


        $this->sendDocumentChangeNotification($document, 'deleted');

        $document->delete();

        return response()->json(['message' => 'Document deleted successfully']);
    }

    protected function sendDocumentChangeNotification(Document $document, $action)
    {
        $userDocuments = CUsersDocument::where('document_id', $document->id)->get();

        foreach ($userDocuments as $userDocument) {
            $user = $userDocument->user;
            SendDocumentChangeNotification::dispatch($user, $document, $action);
        }
    }
}
