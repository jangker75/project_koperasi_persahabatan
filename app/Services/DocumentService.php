<?php

namespace App\Services;

use App\Models\Document;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class DocumentService
{

    public function upload(String $name, Request $request, String $module, String $alternate)
    {
        try {
            // dd($name);
            $document = $request->file($name);
            // dd($document);
            $documentName = date('YmdHis') . "." . $document->getClientOriginalExtension();
            $path =   'Document/' . $module . '/' . $documentName;
            $document->storeAs('Document/' . $module . '/', $documentName, ['disk' => 'public']);
            $size = $document->getSize();
            $extension = $document->getClientOriginalExtension();

            $doc = Document::create([
                'name' => $documentName,
                'path' => $path,
                'size' => $size,
                'ext' => $extension,
                'alternate' => slugify($name . "-" . $alternate)
            ]);

            // dd($doc);

            return [
                'status' => 'success',
                'message' => $path,
                'data' => $doc
            ];
        } catch (QueryException $e) {
            // return $e;
            return [
                'status' => false,
                'message' => $e
            ];
        }
    }

    public function update(String $name, Request $request, String $module, String $alternate, $id)
    {
        try {
            $dataDocument = Document::find($id);
            File::delete(public_path('storage/' . $dataDocument->path));
            $doc = $request->file($name);
            $docName = date('YmdHis') . "." . $doc->getClientOriginalExtension();
            $path =  'Document/' . $module . '/' . $docName;
            $doc->storeAs('Document/' . $module . '/', $docName, ['disk' => 'public']);
            $size = $doc->getSize();
            $extension = $doc->getClientOriginalExtension();

            $document = $dataDocument->update([
                'name' => $docName,
                'path' => $path,
                'size' => $size,
                'ext' => $extension,
                'alternate' => slugify($name . "-" . $alternate)
            ]);
            $document = Document::find($id);
            return [
                'status' => 'success',
                'message' => $path,
                'data' => $document
            ];
        } catch (QueryException $e) {
            return [
                'status' => false,
                'message' => $e
            ];
        }
    }

    public function delete($id)
    {
        try {
            $dataDoc = Document::find($id);
            Storage::disk('public')->delete($dataDoc->path);
            $dataDoc->delete();
            return true;
        } catch (QueryException $e) {
            return $e;
        }
    }
}
