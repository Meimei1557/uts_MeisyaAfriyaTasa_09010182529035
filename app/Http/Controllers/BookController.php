<?php
namespace App\Http\Controllers;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
class BookController extends Controller {
    public function dashboard() {
        $totalBooks = Book::count(); $totalStock = Book::sum('stock'); $totalCategories = Category::count();
        $latestBooks = Book::with('category')->latest()->take(5)->get();
        return view('books.dashboard', compact('totalBooks','totalStock','totalCategories','latestBooks'));
    }
    public function index(Request $request) {
        $query = Book::with('category');
        if ($request->filled('search')) $query->where(fn($q)=>$q->where('title','like','%'.$request->search.'%')->orWhere('author','like','%'.$request->search.'%'));
        if ($request->filled('category_id')) $query->where('category_id',$request->category_id);
        $books = $query->latest()->paginate(8)->withQueryString(); $categories = Category::orderBy('name')->get();
        return view('books.index', compact('books','categories'));
    }
    public function create() { return view('books.create', ['categories'=>Category::orderBy('name')->get()]); }
    public function store(Request $request) {
        $data=$this->validated($request); Book::create($data); return redirect()->route('books.index')->with('success','Buku berhasil ditambahkan.');
    }
    public function show(Book $book) { $book->load('category'); return view('books.show', compact('book')); }
    public function edit(Book $book) { return view('books.edit', ['book'=>$book,'categories'=>Category::orderBy('name')->get()]); }
    public function update(Request $request, Book $book) { $book->update($this->validated($request)); return redirect()->route('books.index')->with('success','Buku berhasil diperbarui.'); }
    public function destroy(Book $book) { $book->delete(); return redirect()->route('books.index')->with('success','Buku berhasil dihapus.'); }
    private function validated(Request $request): array { return $request->validate(['category_id'=>'required|exists:categories,id','title'=>'required|string|max:255','author'=>'required|string|max:255','publisher'=>'required|string|max:255','year'=>'required|integer|min:1900|max:'.date('Y'),'stock'=>'required|integer|min:0']); }
}
