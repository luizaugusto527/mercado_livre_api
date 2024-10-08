<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Cadastro de Produto</title>
</head>
<body>
    <!-- Header -->
    <header class="bg-light py-3 mb-5">
        <div class="container d-flex justify-content-between align-items-center">
            <h5>Desafio Destak</h5>

            @auth
            <!-- Formulário para Logout -->
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
            @endauth
        </div>
    </header>

    <!-- Conteúdo principal -->
    <div class="container mt-5">
        <h1 class="mb-4">Cadastro de Produto</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="form-group">
            @csrf

            <div class="form-group">
                <input type="text" name="name" class="form-control mb-4" placeholder="Nome" value="{{ old('name') }}">
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <textarea name="description" class="form-control mb-4" placeholder="Descrição">{{ old('description') }}</textarea>
                @error('description')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <input type="number" name="price" class="form-control mb-4" placeholder="Preço" step="0.01" value="{{ old('price') }}">
                @error('price')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <input type="number" name="quantity" class="form-control mb-4" placeholder="Quantidade" value="{{ old('quantity') }}">
                @error('quantity')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <select name="category_id" class="form-control mb-4">
                    <option value="">Selecione uma categoria</option>
                    <option value="MLB270878" {{ old('category_id') == 'MLB270878' ? 'selected' : '' }}>Besouro</option>
                    <option value="MLB270877" {{ old('category_id') == 'MLB270877' ? 'selected' : '' }}>Grilo</option>
                    <option value="MLB3530" {{ old('category_id') == 'MLB3530' ? 'selected' : '' }}>Outros</option>
                </select>
                @error('category_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <input type="file" name="image" accept="image/*" class="form-control mb-4">
                @error('image')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Cadastrar Produto</button>
        </form>
    </div>

</body>
</html>
