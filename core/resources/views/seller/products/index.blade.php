@extends('userlayout')

@section('css')
<style>
.product-card {
    border-radius: 15px;
    overflow: hidden;
    transition: transform 0.3s, box-shadow 0.3s;
}
.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}
.product-thumbnail {
    width: 100%;
    height: 200px;
    object-fit: cover;
}
.product-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: bold;
}
.product-stats {
    display: flex;
    justify-content: space-around;
    padding: 10px 0;
    border-top: 1px solid #e9ecef;
}
.stat-item {
    text-align: center;
}
.stat-value {
    font-size: 18px;
    font-weight: bold;
    color: #5e72e4;
}
.stat-label {
    font-size: 12px;
    color: #8898aa;
}
</style>
@endsection

@section('content')
<div class="header pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 d-inline-block mb-0">Meus Produtos</h6>
                    <nav aria-label="breadcrumb" class="d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links">
                            <li class="breadcrumb-item"><a href="{{route('seller.dashboard')}}"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Produtos</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <a href="{{route('seller.products.create')}}" class="btn btn-primary">
                        <i data-lucide="plus" style="width: 16px; height: 16px;"></i> Novo Produto
                    </a>
                    <button class="btn btn-secondary" data-toggle="modal" data-target="#importModal">
                        <i data-lucide="upload" style="width: 16px; height: 16px;"></i> Importar
                    </button>
                    <button class="btn btn-info" onclick="exportProducts()">
                        <i data-lucide="download" style="width: 16px; height: 16px;"></i> Exportar
                    </button>
                </div>
            </div>

            <!-- Filtros -->
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{route('seller.products')}}">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Buscar</label>
                                    <input type="text" name="search" class="form-control" placeholder="Nome do produto..." value="{{request('search')}}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Categoria</label>
                                    <select name="category" class="form-control">
                                        <option value="">Todas</option>
                                        @foreach(\App\Models\ProductCategory::all() as $category)
                                        <option value="{{$category->id}}" {{request('category') == $category->id ? 'selected' : ''}}>{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Tipo</label>
                                    <select name="type" class="form-control">
                                        <option value="">Todos</option>
                                        <option value="digital" {{request('type') == 'digital' ? 'selected' : ''}}>Digital</option>
                                        <option value="physical" {{request('type') == 'physical' ? 'selected' : ''}}>Físico</option>
                                        <option value="service" {{request('type') == 'service' ? 'selected' : ''}}>Serviço</option>
                                        <option value="course" {{request('type') == 'course' ? 'selected' : ''}}>Curso</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="">Todos</option>
                                        <option value="1" {{request('status') == '1' ? 'selected' : ''}}>Ativo</option>
                                        <option value="0" {{request('status') == '0' ? 'selected' : ''}}>Inativo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i data-lucide="search" style="width: 16px; height: 16px;"></i> Filtrar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mt--6">
    <!-- Cards de Resumo -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Total de Produtos</h5>
                            <span class="h2 font-weight-bold mb-0">{{$products->total()}}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
                                <i data-lucide="package" style="width: 20px; height: 20px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Produtos Ativos</h5>
                            <span class="h2 font-weight-bold mb-0">{{$products->where('status', 1)->count()}}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-success text-white rounded-circle shadow">
                                <i data-lucide="check-circle" style="width: 20px; height: 20px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Total de Vendas</h5>
                            <span class="h2 font-weight-bold mb-0">{{$products->sum('sold')}}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                <i data-lucide="shopping-cart" style="width: 20px; height: 20px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Receita Total</h5>
                            <span class="h2 font-weight-bold mb-0">R$ {{number_format($products->sum(function($p) { return $p->amount * $p->sold; }), 2, ',', '.')}}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-warning text-white rounded-circle shadow">
                                <i data-lucide="dollar-sign" style="width: 20px; height: 20px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de Produtos -->
    <div class="row">
        @foreach($products as $product)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card product-card">
                <div class="position-relative">
                    @if($product->thumbnail)
                    <img src="{{url('/')}}/asset/thumbnails/{{$product->thumbnail}}" class="product-thumbnail">
                    @else
                    <div class="product-thumbnail bg-gradient-primary d-flex align-items-center justify-content-center">
                        <i data-lucide="package" style="width: 60px; height: 60px; color: white;"></i>
                    </div>
                    @endif

                    @if($product->status == 1)
                    <span class="product-badge bg-success text-white">Ativo</span>
                    @else
                    <span class="product-badge bg-danger text-white">Inativo</span>
                    @endif

                    @if($product->price_promo > 0 && $product->price_promo < $product->amount)
                    <span class="product-badge bg-warning text-dark" style="top: 10px; left: 10px; right: auto;">
                        -{{round((($product->amount - $product->price_promo) / $product->amount) * 100)}}%
                    </span>
                    @endif
                </div>

                <div class="card-body">
                    <h4 class="card-title mb-2">{{Str::limit($product->name, 50)}}</h4>

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            @if($product->category)
                            <span class="badge badge-primary">{{$product->category->name}}</span>
                            @endif
                            <span class="badge badge-info">{{ucfirst($product->delivery_type)}}</span>
                        </div>
                        <div class="text-right">
                            @if($product->price_promo > 0 && $product->price_promo < $product->amount)
                            <small class="text-muted"><del>R$ {{number_format($product->amount, 2, ',', '.')}}</del></small><br>
                            <span class="h4 text-primary mb-0">R$ {{number_format($product->price_promo, 2, ',', '.')}}</span>
                            @else
                            <span class="h4 text-primary mb-0">R$ {{number_format($product->amount, 2, ',', '.')}}</span>
                            @endif
                        </div>
                    </div>

                    <p class="card-text text-muted mb-3">{{Str::limit($product->description, 100)}}</p>

                    <div class="product-stats">
                        <div class="stat-item">
                            <div class="stat-value">{{$product->sold ?? 0}}</div>
                            <div class="stat-label">Vendas</div>
                        </div>
                        @if($product->quantity_status == 1)
                        <div class="stat-item">
                            <div class="stat-value">{{$product->quantity}}</div>
                            <div class="stat-label">Estoque</div>
                        </div>
                        @endif
                        <div class="stat-item">
                            <div class="stat-value">{{$product->rating ?? '5.0'}}</div>
                            <div class="stat-label">Avaliação</div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <a href="{{route('seller.products.edit', $product->id)}}" class="btn btn-sm btn-primary">
                            <i data-lucide="edit" style="width: 14px; height: 14px;"></i> Editar
                        </a>
                        @if($product->delivery_type == 'digital')
                        <a href="{{route('seller.products.files', $product->id)}}" class="btn btn-sm btn-info">
                            <i data-lucide="file" style="width: 14px; height: 14px;"></i> Arquivos
                        </a>
                        @endif
                        <a href="{{route('seller.products.access', $product->id)}}" class="btn btn-sm btn-secondary">
                            <i data-lucide="users" style="width: 14px; height: 14px;"></i> Acessos
                        </a>
                        <button onclick="deleteProduct({{$product->id}})" class="btn btn-sm btn-danger">
                            <i data-lucide="trash" style="width: 14px; height: 14px;"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Paginação -->
    <div class="row">
        <div class="col-12 d-flex justify-content-center">
            {{$products->links()}}
        </div>
    </div>
</div>

<!-- Modal de Importação -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Importar Produtos</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('seller.products.import')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Arquivo CSV</label>
                        <input type="file" name="file" class="form-control" accept=".csv" required>
                        <small class="text-muted">Formato: nome, categoria, preço, descrição, tipo</small>
                    </div>
                    <button type="submit" class="btn btn-primary">Importar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
// Initialize Lucide icons
lucide.createIcons();

function deleteProduct(id) {
    if (confirm('Tem certeza que deseja excluir este produto?')) {
        // Create a form and submit it
        var form = document.createElement('form');
        form.method = 'POST';
        form.action = '/seller/products/' + id;

        var csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';

        var methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';

        form.appendChild(csrfInput);
        form.appendChild(methodInput);
        document.body.appendChild(form);
        form.submit();
    }
}

function exportProducts() {
    window.location.href = '{{route("seller.products.export")}}';
}
</script>
@endsection