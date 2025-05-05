<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détail de l'objectif</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-5">
    <div class="container">
        <h1 class="mb-4">Objectif : {{ $objectifs->nom }}</h1>

        <div class="card shadow-sm p-4">
            @if($objectifs->lieu)
                <h4>Lieu : {{ $objectifs->lieu }}</h4>
            @endif
            
            @if($objectifs->description)
                <p><strong>Description :</strong> {{ $objectifs->description }}</p>
            @endif
            
            <p><strong>Slug :</strong> {{ $objectifs->slug }}</p>
            
            @if($objectifs->date_debut)
                <p><strong>Date de début :</strong> {{ $objectifs->date_debut }}</p>
            @endif
            
            @if($objectifs->date_limite)
                <p><strong>Date limite :</strong> {{ $objectifs->date_limite }}</p>
            @endif
            
            <p><strong>Catégorie :</strong> {{ $objectifs->categorie }}</p>
            <p><strong>Visibilité :</strong> {{ $objectifs->visibilite }}</p>
            
            <div class="progress mb-3">
                <div class="progress-bar" role="progressbar" style="width: {{ $objectifs->progression }}%">
                    {{ $objectifs->progression }}%
                </div>
            </div>
            
            <div class="mt-4">
                <a href="{{ url('/map') }}" class="btn btn-primary">Retour à la carte</a>
                <a href="{{ route('objectifs.edit', $objectif) }}" class="btn btn-warning">Modifier</a>
                
                <form action="{{ route('objectifs.destroy', $objectif) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet objectif?')">
                        Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>