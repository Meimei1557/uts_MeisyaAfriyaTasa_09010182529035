<?php
namespace App\Http\Controllers;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BookController extends Controller {
    public function dashboard() {
        $totalBooks = Book::count();
        $totalStock = Book::sum('stock');
        $totalCategories = Category::count();
        $latestBooks = Book::with('category')->latest()->take(5)->get();
        $lowStockBooks = Book::with('category')->where('stock','<=',3)->orderBy('stock')->take(5)->get();
        $lowStockCount = Book::where('stock','<=',3)->count();
        $categoryStats = Category::withCount('books')->orderByDesc('books_count')->get();
        $categoryMax = max(1, (int) ($categoryStats->max('books_count') ?? 1));
        return view('books.dashboard', compact('totalBooks','totalStock','totalCategories','latestBooks','lowStockBooks','lowStockCount','categoryStats','categoryMax'));
    }

    public function index(Request $request) {
        $query = Book::with('category');
        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(fn($q)=>$q->where('title','like','%'.$term.'%')->orWhere('author','like','%'.$term.'%'));
        }
        if ($request->filled('category_id')) $query->where('category_id',$request->category_id);
        if ($request->stock === 'low') $query->where('stock','<=',3);
        match ($request->sort) {
            'title' => $query->orderBy('title'),
            'stock_low' => $query->orderBy('stock')->orderBy('title'),
            'year' => $query->orderByDesc('year'),
            default => $query->latest(),
        };
        $books = $query->paginate(8)->withQueryString();
        $categories = Category::orderBy('name')->get();
        return view('books.index', compact('books','categories'));
    }

    public function export(): StreamedResponse {
        $filename = 'koleksi-buku-'.now()->format('Y-m-d-His').'.csv';
        $books = Book::with('category')->orderBy('title')->get();
        return response()->streamDownload(function () use ($books) {
            $handle = fopen('php://output','w');
            fputcsv($handle,['ID','Judul','Penulis','Penerbit','Tahun','Stok','Kategori']);
            foreach ($books as $book) fputcsv($handle,[$book->id,$book->title,$book->author,$book->publisher,$book->year,$book->stock,$book->category->name]);
            fclose($handle);
        }, $filename, ['Content-Type'=>'text/csv']);
    }

    public function create() { return view('books.create', ['categories'=>Category::orderBy('name')->get()]); }
    public function store(Request $request) { Book::create($this->validated($request)); return redirect()->route('books.index')->with('success','Buku berhasil ditambahkan.'); }
    public function show(Book $book) { $book->load('category'); return view('books.show', compact('book')); }
    public function edit(Book $book) { return view('books.edit', ['book'=>$book,'categories'=>Category::orderBy('name')->get()]); }
    public function update(Request $request, Book $book) { $book->update($this->validated($request)); return redirect()->route('books.index')->with('success','Buku berhasil diperbarui.'); }
    public function destroy(Book $book) { $book->delete(); return redirect()->route('books.index')->with('success','Buku berhasil dihapus.'); }
    private function validated(Request $request): array { return $request->validate(['category_id'=>'required|exists:categories,id','title'=>'required|string|max:255','author'=>'required|string|max:255','publisher'=>'required|string|max:255','year'=>'required|integer|min:1900|max:'.date('Y'),'stock'=>'required|integer|min:0']); }
}
