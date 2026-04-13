@extends('userlayout')

@section('content')
<div class="container-fluid">
    <div class="header pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6">
                        <h1 class="display-4 text-white">API Keys</h1>
                        <p class="text-light">Gerencie suas chaves de API para integração</p>
                    </div>
                    <div class="col-lg-6 text-right">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#generateApiKeyModal">
                            <i class="fas fa-plus"></i> Gerar Nova API Key
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    @if(session('api_key'))
                    <hr>
                    <p class="mb-0"><strong>Sua API Key (copie agora, não será mostrada novamente):</strong></p>
                    <div class="input-group mt-2">
                        <input type="text" class="form-control" value="{{ session('api_key') }}" id="newApiKey" readonly>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" onclick="copyApiKey()">
                                <i class="fas fa-copy"></i> Copiar
                            </button>
                        </div>
                    </div>
                    @endif
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">Minhas API Keys</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Nome</th>
                                        <th>Chave</th>
                                        <th>Status</th>
                                        <th>Criada em</th>
                                        <th>Último uso</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($apiKeys as $key)
                                    <tr>
                                        <td>{{ $key->name }}</td>
                                        <td><code>{{ substr($key->key, 0, 20) }}...</code></td>
                                        <td>
                                            @if($key->active)
                                            <span class="badge badge-success">Ativa</span>
                                            @else
                                            <span class="badge badge-danger">Revogada</span>
                                            @endif
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($key->created_at)->format('d/m/Y H:i') }}</td>
                                        <td>{{ $key->last_used_at ? \Carbon\Carbon::parse($key->last_used_at)->format('d/m/Y H:i') : 'Nunca' }}</td>
                                        <td>
                                            @if($key->active)
                                            <form action="{{ route('seller.settings.api.revoke', $key->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Tem certeza que deseja revogar esta API key?')">
                                                    <i class="fas fa-ban"></i> Revogar
                                                </button>
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <i class="fas fa-key fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">Nenhuma API Key criada ainda.</p>
                                            <button class="btn btn-primary" data-toggle="modal" data-target="#generateApiKeyModal">
                                                Gerar Primeira API Key
                                            </button>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Documentação -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="mb-0">Documentação da API</h3>
                    </div>
                    <div class="card-body">
                        <p>Use suas API Keys para integrar com plataformas externas como N8n, Make, Zapier e muito mais.</p>

                        <h4 class="mt-4">Como usar:</h4>
                        <ol>
                            <li>Gere uma nova API Key clicando no botão acima</li>
                            <li>Copie a chave (será mostrada apenas uma vez)</li>
                            <li>Use a chave no header de autenticação das suas requisições:</li>
                        </ol>

                        <pre class="bg-dark text-white p-3 rounded"><code>Authorization: Bearer SUA_API_KEY</code></pre>

                        <h4 class="mt-4">Exemplo de Requisição:</h4>
                        <pre class="bg-dark text-white p-3 rounded"><code>curl -X GET "https://new.sharkpay.com.br/api/invoices" \
  -H "Authorization: Bearer SUA_API_KEY"</code></pre>

                        <p class="mt-3">
                            <a href="/API_INTEGRATION_GUIDE.md" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-book"></i> Ver Documentação Completa
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Gerar API Key -->
<div class="modal fade" id="generateApiKeyModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Gerar Nova API Key</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="{{ route('seller.settings.api.generate') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nome da API Key</label>
                        <input type="text" name="name" class="form-control" placeholder="Ex: Integração N8n" required>
                        <small class="form-text text-muted">Escolha um nome para identificar onde esta chave será usada</small>
                    </div>

                    <div class="alert alert-warning">
                        <strong>Atenção:</strong> A API Key completa será mostrada apenas uma vez. Certifique-se de copiá-la em um local seguro.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Gerar API Key</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function copyApiKey() {
    var copyText = document.getElementById("newApiKey");
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    document.execCommand("copy");
    alert("API Key copiada!");
}
</script>
@endsection
