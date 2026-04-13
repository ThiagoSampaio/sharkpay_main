<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Productcategory;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Auth;
use DB;

class ProductController extends Controller
{
    public function index()
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $products = Product::where('user_id', Auth::id())
            ->with(['category', 'images'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('seller.products.index', compact('products', 'lang'));
    }

    public function create()
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $categories = Productcategory::where('status', 1)->get();
        return view('seller.products.create', compact('categories', 'lang'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:5120',
        ]);

        $handle = fopen($request->file('file')->getRealPath(), 'r');

        if ($handle === false) {
            return back()->with('error', 'Nao foi possivel abrir o arquivo CSV enviado.');
        }

        DB::beginTransaction();

        try {
            $imported = 0;
            $skipped = 0;
            $lineNumber = 0;

            while (($row = fgetcsv($handle, 0, ',')) !== false) {
                $lineNumber++;
                $row = array_map(static fn ($value) => is_string($value) ? trim($value) : $value, $row);

                if ($this->isEmptyImportRow($row)) {
                    continue;
                }

                if ($lineNumber === 1 && $this->looksLikeImportHeader($row)) {
                    continue;
                }

                if (count($row) < 5 || empty($row[0]) || empty($row[1]) || empty($row[2])) {
                    $skipped++;
                    continue;
                }

                $category = Productcategory::firstOrCreate(
                    ['name' => $row[1]],
                    ['status' => 1]
                );

                $deliveryType = $this->normalizeDeliveryType($row[4] ?? null);
                $amount = $this->normalizeMoneyValue($row[2]);
                $quantity = $this->resolveImportedQuantity($deliveryType, $row[5] ?? null);

                Product::create([
                    'user_id' => Auth::id(),
                    'cat_id' => $category->id,
                    'name' => $row[0],
                    'amount' => $amount,
                    'price_promo' => 0,
                    'currency' => 'BRL',
                    'quantity' => $quantity,
                    'quantity_status' => $deliveryType === 'digital' ? 0 : 1,
                    'description' => $row[3] ?: 'Produto importado via CSV.',
                    'delivery_type' => $deliveryType,
                    'external_link' => null,
                    'tags' => null,
                    'ref_id' => $this->generateRefId(),
                    'status' => 1,
                    'active' => 1,
                    'sold' => 0,
                ]);

                $imported++;
            }

            fclose($handle);
            DB::commit();

            if ($imported === 0) {
                return back()->with('error', 'Nenhum produto valido foi encontrado no CSV.');
            }

            $message = "Importacao concluida com sucesso: {$imported} produto(s) cadastrados";

            if ($skipped > 0) {
                $message .= ", {$skipped} linha(s) ignoradas";
            }

            return redirect()->route('seller.products')->with('success', $message . '.');
        } catch (\Throwable $exception) {
            fclose($handle);
            DB::rollBack();

            return back()->with('error', 'Erro ao importar produtos: ' . $exception->getMessage());
        }
    }

    public function export()
    {
        $fileName = 'seller-products-' . now()->format('Y-m-d-His') . '.csv';

        $products = Product::where('user_id', Auth::id())
            ->with('cat')
            ->orderBy('created_at', 'desc')
            ->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        return response()->stream(function () use ($products) {
            $handle = fopen('php://output', 'w');

            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($handle, ['nome', 'categoria', 'preco', 'descricao', 'tipo', 'quantidade']);

            foreach ($products as $product) {
                fputcsv($handle, [
                    $product->name,
                    optional($product->cat)->name ?? 'Sem categoria',
                    number_format((float) $product->amount, 2, '.', ''),
                    trim(strip_tags((string) $product->description)),
                    $product->delivery_type ?? 'digital',
                    (int) $product->quantity,
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'cat_id' => 'required|exists:product_category,id',
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string',
            'quantity' => 'nullable|integer|min:0',
            'delivery_type' => 'required|in:digital,physical,service,course',
            'files.*' => 'nullable|file|max:102400', // 100MB max
            'thumbnail' => 'nullable|image|max:5120', // 5MB max
            'tags' => 'nullable|string',
            'external_link' => 'nullable|url',
            'price_promo' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $product = new Product();
            $product->user_id = Auth::id();
            $product->cat_id = $request->cat_id;
            $product->name = $request->name;
            $product->amount = $request->amount;
            $product->price_promo = $request->price_promo ?? 0;
            $product->currency = 'BRL';
            $product->quantity = $request->quantity ?? -1; // -1 for unlimited digital products
            $product->quantity_status = $request->delivery_type == 'digital' ? 0 : 1;
            $product->description = $request->description;
            $product->delivery_type = $request->delivery_type;
            $product->external_link = $request->external_link;
            $product->tags = $request->tags;
            $product->ref_id = $this->generateRefId();
            $product->status = 1;
            $product->active = 1;

            // Handle thumbnail upload
            if ($request->hasFile('thumbnail')) {
                $thumbnail = $request->file('thumbnail');
                $thumbnailName = time() . '_' . Str::slug($product->name) . '.' . $thumbnail->getClientOriginalExtension();
                $thumbnail->move(public_path('asset/thumbnails'), $thumbnailName);
                $product->thumbnail = $thumbnailName;
            }

            $product->save();

            // Handle digital product files
            if ($request->delivery_type == 'digital' && $request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('products/' . $product->id, $fileName, 'local');

                    DB::table('product_files')->insert([
                        'product_id' => $product->id,
                        'file_name' => $file->getClientOriginalName(),
                        'file_path' => $path,
                        'file_size' => $file->getSize(),
                        'file_type' => $file->getMimeType(),
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }

            // Handle product images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('asset/product_images'), $imageName);

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $imageName
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('seller.products')
                ->with('success', 'Produto criado com sucesso!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Erro ao criar produto: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $product = Product::where('user_id', Auth::id())
            ->where('id', $id)
            ->with(['category', 'images'])
            ->firstOrFail();

        $categories = Productcategory::where('status', 1)->get();

        $productFiles = DB::table('product_files')
            ->where('product_id', $id)
            ->get();

        return view('seller.products.edit', compact('product', 'categories', 'productFiles', 'lang'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'cat_id' => 'required|exists:product_category,id',
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string',
            'quantity' => 'nullable|integer|min:0',
            'tags' => 'nullable|string',
            'external_link' => 'nullable|url',
            'price_promo' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $product->name = $request->name;
            $product->cat_id = $request->cat_id;
            $product->amount = $request->amount;
            $product->price_promo = $request->price_promo ?? 0;
            $product->quantity = $request->quantity ?? -1;
            $product->description = $request->description;
            $product->external_link = $request->external_link;
            $product->tags = $request->tags;
            $product->status = $request->status ?? 1;

            // Update thumbnail if new one is uploaded
            if ($request->hasFile('thumbnail')) {
                // Delete old thumbnail
                if ($product->thumbnail) {
                    @unlink(public_path('asset/thumbnails/' . $product->thumbnail));
                }

                $thumbnail = $request->file('thumbnail');
                $thumbnailName = time() . '_' . Str::slug($product->name) . '.' . $thumbnail->getClientOriginalExtension();
                $thumbnail->move(public_path('asset/thumbnails'), $thumbnailName);
                $product->thumbnail = $thumbnailName;
            }

            $product->save();

            // Handle new digital product files
            if ($product->delivery_type == 'digital' && $request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('products/' . $product->id, $fileName, 'local');

                    DB::table('product_files')->insert([
                        'product_id' => $product->id,
                        'file_name' => $file->getClientOriginalName(),
                        'file_path' => $path,
                        'file_size' => $file->getSize(),
                        'file_type' => $file->getMimeType(),
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('seller.products')
                ->with('success', 'Produto atualizado com sucesso!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Erro ao atualizar produto: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $product = Product::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        DB::beginTransaction();

        try {
            // Delete product files
            $files = DB::table('product_files')->where('product_id', $id)->get();
            foreach ($files as $file) {
                Storage::disk('local')->delete($file->file_path);
            }
            DB::table('product_files')->where('product_id', $id)->delete();

            // Delete product images
            $images = ProductImage::where('product_id', $id)->get();
            foreach ($images as $image) {
                @unlink(public_path('asset/product_images/' . $image->image));
            }
            ProductImage::where('product_id', $id)->delete();

            // Delete thumbnail
            if ($product->thumbnail) {
                @unlink(public_path('asset/thumbnails/' . $product->thumbnail));
            }

            $product->delete();

            DB::commit();

            return redirect()->route('seller.products')
                ->with('success', 'Produto excluído com sucesso!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Erro ao excluir produto: ' . $e->getMessage());
        }
    }

    public function files($id)
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $product = Product::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $files = DB::table('product_files')
            ->where('product_id', $id)
            ->get();

        return view('seller.products.files', compact('product', 'files', 'lang'));
    }

    public function upload(Request $request, $id)
    {
        $product = Product::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $request->validate([
            'file' => 'required|file|max:102400' // 100MB max
        ]);

        try {
            $file = $request->file('file');
            $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('products/' . $product->id, $fileName, 'local');

            DB::table('product_files')->insert([
                'product_id' => $product->id,
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_size' => $file->getSize(),
                'file_type' => $file->getMimeType(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return back()->with('success', 'Arquivo enviado com sucesso!');

        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao enviar arquivo: ' . $e->getMessage());
        }
    }

    public function access($id)
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $product = Product::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $accesses = DB::table('product_access')
            ->join('users', 'product_access.user_id', '=', 'users.id')
            ->where('product_access.product_id', $id)
            ->select('product_access.*', 'users.name', 'users.email')
            ->orderBy('product_access.created_at', 'desc')
            ->paginate(20);

        return view('seller.products.access', compact('product', 'accesses', 'lang'));
    }

    private function generateRefId()
    {
        do {
            $refId = 'PRD' . strtoupper(Str::random(13));
        } while (Product::where('ref_id', $refId)->exists());

        return $refId;
    }

    private function looksLikeImportHeader(array $row): bool
    {
        $firstCell = Str::lower((string) ($row[0] ?? ''));

        return in_array($firstCell, ['nome', 'name', 'produto', 'product'], true);
    }

    private function isEmptyImportRow(array $row): bool
    {
        foreach ($row as $value) {
            if ($value !== null && $value !== '') {
                return false;
            }
        }

        return true;
    }

    private function normalizeDeliveryType(?string $value): string
    {
        $normalized = Str::lower(trim((string) $value));

        return match ($normalized) {
            'fisico', 'físico', 'physical' => 'physical',
            'servico', 'serviço', 'service' => 'service',
            'curso', 'course' => 'course',
            default => 'digital',
        };
    }

    private function normalizeMoneyValue(string $value): float
    {
        $normalized = preg_replace('/[^\d,.-]/', '', $value) ?? '0';

        if (str_contains($normalized, ',') && str_contains($normalized, '.')) {
            $normalized = str_replace('.', '', $normalized);
        }

        $normalized = str_replace(',', '.', $normalized);

        return max((float) $normalized, 0);
    }

    private function resolveImportedQuantity(string $deliveryType, mixed $value): int
    {
        if ($deliveryType === 'digital') {
            return -1;
        }

        if ($value === null || $value === '') {
            return 1;
        }

        return max((int) $value, 1);
    }
}