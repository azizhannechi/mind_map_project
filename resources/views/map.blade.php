<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to FocusMap - Vos objectifs en carte mentale</title>

    <!-- LeafletJS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <!-- GoJS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gojs/2.3.7/go.js"></script>
      <script> window.objectifsFromLaravel = @json($objectifs)
</script>
    <script src="{{ asset('js/map.js') }}"></script>

    <style>
        :root {
            --primary-color: #4a6fa5;
            --secondary-color: #6b8cae;
            --accent-color: #ff7e5f;
            --light-bg: #f8f9fa;
            --dark-text: #2c3e50;
        }
        
        body {
            background-color: var(--light-bg);
            color: var(--dark-text);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color) !important;
        }
        
        #map {
            height: 500px;
            width: 100%;
            border-radius: 12px;
            margin-top: 20px;
            z-index: 1;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        #mindmap {
            height: 500px;
            width: 100%;
            border-radius: 12px;
            margin-top: 20px;
            background-color: white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .progress-container {
            margin-top: 20px;
            background-color: #e9ecef;
            border-radius: 10px;
            height: 10px;
        }
        
        .progress-bar {
            background-color: var(--accent-color);
        }
        
        .card {
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
            transition: transform 0.2s;
            margin-bottom: 20px;
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .timeline {
            position: relative;
            padding-left: 50px;
            margin-top: 30px;
        }
        
        .timeline-item {
            position: relative;
            padding-bottom: 30px;
        }
        
        .timeline-item:before {
            content: '';
            position: absolute;
            left: -30px;
            top: 0;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: var(--accent-color);
            border: 3px solid white;
        }
        
        .timeline-item:after {
            content: '';
            position: absolute;
            left: -21px;
            top: 20px;
            width: 2px;
            height: 100%;
            background-color: #dee2e6;
        }
        
        .timeline-item:last-child:after {
            display: none;
        }
        
        .floating-action-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: var(--accent-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            z-index: 1000;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="bi bi-bullseye me-2"></i>FocusMap
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#"><i class="bi bi-house-door me-1"></i> Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="bi bi-gear me-1"></i> paramétre</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="bi bi-calendar-check me-1"></i> Calendrier</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="bi bi-people me-1"></i> Communauté</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <div class="row mb-4">
            <div class="col-md-8">
                <h1 class="display-5 fw-bold"><i class="bi bi-bullseye text-primary me-2"></i>Vos objectifs</h1>
                <p class="lead">Visualisez et suivez votre progression vers vos objectifs personnels</p>
            </div>
            <div class="col-md-4 text-end">
                <div class="dropdown">
                    <button class="btn btn-outline-primary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown">
                        <i class="bi bi-funnel me-1"></i>Filtrer
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Tous les objectifs</a></li>
                        <li><a class="dropdown-item" href="#">En cours</a></li>
                        <li><a class="dropdown-item" href="#">Terminés</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Par catégorie</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Section Progression globale -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-graph-up me-2"></i>Votre progression globale</h5>
                <div class="progress-container">
                    <div class="progress-bar" role="progressbar" style="width: 65%"></div>
                </div>
                <div class="d-flex justify-content-between mt-2">
                    <small>65% complété</small>
                    <small>12/18 objectifs</small>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Colonne MindMap -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-diagram-3 me-2"></i>Carte mentale</h5>
                        <button class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-arrows-angle-expand"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="mindmap"></div>
                    </div>
                </div>
            </div>

            <!-- Colonne Carte géographique -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-globe2 me-2"></i>Carte géographique</h5>
                        <div>
                            <button class="btn btn-sm btn-outline-primary me-2">
                                <i class="bi bi-layers"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-arrows-angle-expand"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                    <div id="map" style="height: 500px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Timeline de motivation -->
        <div class="card mt-4">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Timeline de motivation</h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item">
                        <h6>Objectif "Apprendre le japonais" créé</h6>
                        <p class="text-muted small mb-2">15 jours ago</p>
                        <p>Vous avez défini votre premier objectif ! Commencez par apprendre les hiragana.</p>
                    </div>
                    <div class="timeline-item">
                        <h6>Première étape complétée</h6>
                        <p class="text-muted small mb-2">10 jours ago</p>
                        <p>Félicitations ! Vous avez complété la première étape de votre objectif "Courir un semi-marathon".</p>
                    </div>
                    <div class="timeline-item">
                        <h6>Nouveau record personnel</h6>
                        <p class="text-muted small mb-2">5 jours ago</p>
                        <p>Vous avez couru 15km en 1h25, un nouveau record ! Continuez comme ça.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bouton flottant pour ajouter un objectif -->
    <div class="floating-action-btn" data-bs-toggle="modal" data-bs-target="#newGoalModal">
        <i class="bi bi-plus-lg"></i>
    </div>

    <!-- Modal pour nouvel objectif -->
    <div class="modal fade" id="newGoalModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Nouvel objectif</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Nom de l'objectif</label>
                            <input type="text" class="form-control" placeholder="Ex: Apprendre le japonais">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Catégorie</label>
                            <select class="form-select">
                                <option>Études</option>
                                <option>Sport</option>
                                <option>Lecture</option>
                                <option>Projets</option>
                                <option>Santé</option>
                                <option>Autre</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" rows="3"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Date de début</label>
                                <input type="date" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Date limite</label>
                                <input type="date" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Localisation (optionnel)</label>
                            <input type="text" class="form-control" placeholder="Rechercher un lieu...">
                            <small class="text-muted">Ajoutez un lieu pour visualiser cet objectif sur la carte</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Visibilité</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="visibility" id="private" checked>
                                <label class="form-check-label" for="private">
                                    <i class="bi bi-lock"></i> Privé (seulement moi)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="visibility" id="friends">
                                <label class="form-check-label" for="friends">
                                    <i class="bi bi-people"></i> Amis
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="visibility" id="public">
                                <label class="form-check-label" for="public">
                                    <i class="bi bi-globe"></i> Public
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Enregistrer l'objectif
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
    // Référence au bouton de recherche et au champ d'adresse
    const searchBtn = document.getElementById('searchLocation');
    const lieuInput = document.getElementById('lieu');
    const latitudeInput = document.getElementById('latitude');
    const longitudeInput = document.getElementById('longitude');
    const locationMapDiv = document.getElementById('locationMap');
    
    let locationMap;
    let locationMarker;
    
    // Initialiser la carte pour la sélection d'emplacement
    function initLocationMap() {
        if (!locationMap) {
            locationMapDiv.style.display = 'block';
            locationMap = L.map('locationMap').setView([46.603354, 1.888334], 5);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 18
            }).addTo(locationMap);
            
            // Permettre de cliquer sur la carte pour définir l'emplacement
            locationMap.on('click', function(e) {
                setLocationMarker(e.latlng.lat, e.latlng.lng);
            });
            
            // Rafraîchir la carte après l'affichage du modal
            setTimeout(() => {
                locationMap.invalidateSize();
            }, 500);
        }
    }
    
    // Fonction pour définir un marqueur sur la carte de sélection
    function setLocationMarker(lat, lng) {
        // Mettre à jour les champs de formulaire
        latitudeInput.value = lat;
        longitudeInput.value = lng;
        
        // Mettre à jour le marqueur
        if (locationMarker) {
            locationMarker.setLatLng([lat, lng]);
        } else {
            locationMarker = L.marker([lat, lng]).addTo(locationMap);
        }
        
        // Centrer la carte sur le marqueur
        locationMap.setView([lat, lng], 12);
    }
    
    // Gérer le clic sur le bouton de recherche
    if (searchBtn) {
        searchBtn.addEventListener('click', function() {
            const address = lieuInput.value.trim();
            if (address) {
                // Initialiser la carte si pas encore fait
                initLocationMap();
                
                // Rechercher l'adresse via l'API Nominatim
                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.length > 0) {
                            const lat = parseFloat(data[0].lat);
                            const lng = parseFloat(data[0].lon);
                            setLocationMarker(lat, lng);
                        } else {
                            alert('Aucun résultat trouvé pour cette adresse');
                        }
                    })
                    .catch(error => {
                        console.error('Erreur lors du géocodage:', error);
                    });
            }
        });
    }
    
    // Afficher la carte lorsque le champ d'adresse reçoit le focus
    if (lieuInput) {
        lieuInput.addEventListener('focus', function() {
            initLocationMap();
        });
    }
    
    // Réinitialiser la carte lors de la fermeture du modal
    const newGoalModal = document.getElementById('newGoalModal');
    if (newGoalModal) {
        newGoalModal.addEventListener('hidden.bs.modal', function() {
            locationMapDiv.style.display = 'none';
            if (locationMap) {
                locationMap.remove();
                locationMap = null;
                locationMarker = null;
            }
        });
    }
});
</script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>