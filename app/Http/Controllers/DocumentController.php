<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;

class DocumentController extends Controller
{
    public function index()
    {
        $tenant = auth()->user()->tenant;
        $documents = $tenant->documents()->latest()->paginate(15);

        return view('documents.index', compact('documents'));
    }

    public function create()
    {
        $tenant = auth()->user()->tenant;

        return view('documents.create', compact('tenant'));
    }

    public function store(Request $request)
    {
        $tenant = auth()->user()->tenant;

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'document_date' => 'nullable|date',
            'reference_number' => 'nullable|string|max:255',
            'attachments_text' => 'nullable|string|max:255',
            'subject' => 'nullable|string|max:255',
            'content' => 'required|string',
            'signatures' => 'nullable|array', // Which signatures are selected for this doc
        ]);

        $tenant->documents()->create($validated);

        return redirect()->route('documents.index')->with('success', 'تم إنشاء الخطاب بنجاح.');
    }

    public function show(Document $document)
    {
        // For viewing, we can just render the PDF or show it in browser
        return redirect()->route('documents.pdf', $document);
    }

    public function edit(Document $document)
    {
        $this->authorizeDocument($document);
        $tenant = auth()->user()->tenant;

        return view('documents.edit', compact('document', 'tenant'));
    }

    public function update(Request $request, Document $document)
    {
        $this->authorizeDocument($document);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'document_date' => 'nullable|date',
            'reference_number' => 'nullable|string|max:255',
            'attachments_text' => 'nullable|string|max:255',
            'subject' => 'nullable|string|max:255',
            'content' => 'required|string',
            'signatures' => 'nullable|array',
        ]);

        $document->update($validated);

        return redirect()->route('documents.index')->with('success', 'تم تحديث الخطاب بنجاح.');
    }

    public function destroy(Document $document)
    {
        $this->authorizeDocument($document);
        $document->delete();

        return redirect()->route('documents.index')->with('success', 'تم حذف الخطاب بنجاح.');
    }

    public function pdf(Document $document)
    {
        $this->authorizeDocument($document);
        $tenant = $document->tenant;

        $pdf = PDF::loadView('documents.pdf', compact('document', 'tenant'), [], [
            'mode' => 'utf-8',
            'format' => 'A4',
            'autoArabic' => true,
            'margin_top' => 15,
            'margin_bottom' => 40,
            'margin_header' => 5,
            'margin_footer' => 5,
        ]);

        return $pdf->stream($document->title.'.pdf');
    }

    protected function authorizeDocument(Document $document)
    {
        if ($document->tenant_id !== auth()->user()->tenant_id) {
            abort(403);
        }
    }
}
